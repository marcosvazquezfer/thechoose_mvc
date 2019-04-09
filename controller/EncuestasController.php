<?php
//file: controller/EncuestasController.php

require_once(__DIR__."/../model/Hueco.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/EncuestaMapper.php");
require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/Participante.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class EncuestasController
*
* Controller para hacer un CRUDL de encuestas
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class EncuestasController extends BaseController {

	/**
	* Referencia a EncuestaMapper para interactuar con la Base de Datos
	*
	* @var encuestaMapper
	*/
	private $encuestaMapper;

	public function __construct() {

		parent::__construct();

		$this->encuestaMapper = new EncuestaMapper();
	}

	/**
	* Función que permite crear la vista principal de la página
	*/
	public function index() {

		// obtain the data from the database
		$encuestas = $this->encuestaMapper->findAll();

		//Envía el array que contiene las encuestas a la vista
		$this->view->setVariable("encuestas", $encuestas);

		//Renderiza la vista (/view/encuestas/index.php)
		$this->view->render("encuestas", "index");
	}

	/**
	* 
	* Función que permite ver una encuesta en detalle
	*
	*/
	public function view(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. View encuestas requires login");
		}

		if (!isset($_GET["idEncuesta"])) {

			throw new Exception("id is mandatory");
		}

		$encuestaid = $_GET["idEncuesta"];

		//Busca en la Base de Datos la encuesta con sus huecos, la encuesta con sus 
		//participantes, y la encuesta con sus selecciones
		//y la encuesta con ese id
		$encuesta = $this->encuestaMapper->findById($encuestaid);
		$encuestaHuecos = $this->encuestaMapper->findByIdWithHoles($encuestaid);
		$encuestaParticipantes = $this->encuestaMapper->findParticipants($encuestaid);
		$encuestaSelecciones = $this->encuestaMapper->findSelections($encuestaid);

		//Almacena en la parte de datos un nuevo participante de la encuesta, que es el
		//que accede a la vista
		$this->encuestaMapper->saveParticipant($encuestaid, $this->currentUser);

		if ($encuestaHuecos == NULL) {

			throw new Exception("no such encuesta with id: ".$encuestaid);
		}

		//Envía el objeto encuesta, encuestaParticipantes y encuestaSelecciones a la vista
		$this->view->setVariable("encuestaHuecos", $encuestaHuecos);
		$this->view->setVariable("encuestaParticipantes", $encuestaParticipantes);
		$this->view->setVariable("encuestaSelecciones", $encuestaSelecciones);
		$this->view->setVariable("encuesta", $encuesta);
		$this->view->setVariable("currentusername", $this->currentUser);

		//Comprueba si el hueco ya está en la vista, si no está, crea uno vacío
		$hueco = $this->view->getVariable("hueco");
		$this->view->setVariable("hueco", ($hueco==NULL)?new Hueco():$hueco);


		//Renderiza la vista (/view/encuestas/view.php)
		$this->view->render("encuestas", "view");
	}

	/**
	* Función para ñadir una nueva encuesta
	*/
	public function add() {

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding encuestas requires login");
		}

		//Crea un nuevo objeto Encuesta
		$encuesta = new Encuesta();

		//Almacena un link genérico de la encuesta en la Base de Datos
		$encuesta->setLink();

		//Almacena el creador de la encuesta en la Base de Datos (el creador es el usuario logeado)
		$encuesta->setEmail($this->currentUser);

		//Obtiene de Base de Datos el link almacenado
		$encuestalink = $encuesta->getLink();

		try {

			//Almacena el objeto Encuesta
			$this->encuestaMapper->save($encuesta);

			//Busca en la Base de Datos una encuesta por su creador y su link
			$encuestaid = $this->encuestaMapper->findByEmailLink($encuestalink, $this->currentUser);

			//Modifica el link de la encuesta para ponerle el correcto
			$this->encuestaMapper->updateLink($encuestaid);

			//Almacena en la Base de Datos también al creador como un participante
			$this->encuestaMapper->saveParticipantAdd($encuestaid, $this->currentUser);

			// POST-REDIRECT-GET
			//Todo correcto, redireccionamos al usuario a la vista de editar encuesta
			// header("Location: index.php?controller=encuestas&action=edit&idEncuesta=$encuestaid")
			// die();
			$this->view->redirect("encuestas", "edit", "idEncuesta=".$encuestaid->getIdEncuesta());

		}
		catch(ValidationException $ex) {

			//Regoge los errores dentro de la excepción
			$errors = $ex->getErrors();
			//Los pone en la vista como una variable
			$this->view->setVariable("errors", $errors);
		}

		//Envía el onjeto Encuesta a la vista
		$this->view->setVariable("encuesta", $encuesta);

		//Renderiza la vista (/view/encuestas/add.php)
		$this->view->render("encuestas", "add");

	}

	/**
	* Función para editar una encuesta
	*/
	public function edit() {

		if (!isset($_REQUEST["idEncuesta"])) {

			throw new Exception("A encuesta id is mandatory");
		}

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Editing encuestas requires login");
		}


		
		$encuestaid = $_REQUEST["idEncuesta"];

		//Busca la encuesta en la base de datos, y también la encuesta con sus huecos
		$encuesta = $this->encuestaMapper->findById($encuestaid);
		$encuestaHueco = $this->encuestaMapper->findByIdWithHoles($encuestaid);

		//Existe la encuesta?
		if ($encuesta == NULL) {

			throw new Exception("no such encuesta with id: ".$encuestaid);
		}

		//Comprueba si el creador es el usuario logeado
		if ($encuesta->getEmail() != $this->currentUser) {

			throw new Exception("logged user is not the author of the encuesta id ".$encuestaid);
		}

		if (isset($_POST["submit"])) { //Enviado a través de HTTP

			//Almacena el título de la encuesta en la Base de Datos
			$encuesta->setTitulo($_POST["titulo"]);

			try {
				//Valida el objeto encuesta
				$encuesta->checkIsValidForUpdate();

				//Modifica el objeto Encuesta en la Base de Datos
				$this->encuestaMapper->update($encuesta);

				//POST-REDIRECT-GET
				//Todo correcto, redirecciona al usuario a ver la lista de Encuestas creadas por el o en las que participa
				// header("Location: index.php?controller=encuestas&action=edit&idENcuesta=$encuestaid")
				// die();
				$this->view->redirect("encuestas", "edit", "idEncuesta=".$encuestaid);

			}catch(ValidationException $ex) {
				//Obtiene los errores dentro de la excepción
				$errors = $ex->getErrors();
				//Los envía a la vista como una variable
				$this->view->setVariable("errors", $errors);
			}
		}

		//Envía los objetos encuesta y encuestaHueco a la vista
		$this->view->setVariable("encuesta", $encuesta);
		$this->view->setVariable("encuestaHueco", $encuestaHueco);

		//Comprueba si el hueco ya está en la vista, sino pone uno vacío
		$hueco = $this->view->getVariable("hueco");
		$this->view->setVariable("hueco", ($hueco==NULL)?new Hueco():$hueco);

		//Renderiza la vista (/view/encuestas/edit.php)
		$this->view->render("encuestas", "edit");
	}

	/**
	*Función para ver las encuestas creadas y en las que participa el usuario
	* logeado
	*/
	public function viewMyPolls() {

		//Obtiene los datos de la Base de Datos
		$participantes = $this->encuestaMapper->findAllParticipants();

		//Envía a la vista el array con todos los participantes
		$this->view->setVariable("participantes", $participantes);

		//Renderiza la vista (/view/encuestas/viewMyPolls.php)
		$this->view->render("encuestas", "viewMyPolls");
	}

	/**
	*Función para participar en una encuesta
	*/
	public function participar(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Participate in encuestas requires login");
		}

		if (!isset($_REQUEST["idEncuesta"])) {

			throw new Exception("id is mandatory");
		}

		$encuestaid = $_REQUEST["idEncuesta"];

		//Busca la encuesta con sus huecos en la Base de Datos
		$encuesta = $this->encuestaMapper->findByIdWithHoles($encuestaid);

		//Existe encuesta?
		if ($encuesta == NULL) {

			throw new Exception("no such encuesta with id: ".$encuestaid);
		}

		if(!isset($_POST["submit"])){

			$this->encuestaMapper->deleteSelections($encuestaid, $this->currentUser);

			foreach($encuesta->getHuecos() as $hueco){

				$seleccion = 0;

				//Almacena en la Base de Datos las selecciones a 0
				$this->encuestaMapper->saveSelectionsIni($hueco->getIdEncuesta(), $hueco->getFecha(), $hueco->getHoraInicio(), $this->currentUser, $seleccion);
			}
		}

		//Busca los participantes de la encuesta
		$encuestaParticipantes = $this->encuestaMapper->findParticipants($encuestaid);

		//Busca las selecciones de los huecos de esa encuesta
		$encuestaSelecciones = $this->encuestaMapper->findSelections($encuestaid);

		if (isset($_POST["submit"])) { //Recibido por HTTP

			$cadena = $_POST['checkbox'];

			$fecha = null;
			$horaInicio = null;
			
			$email = $this->currentUser;

			if($_POST['checkbox'] != ""){

				if(is_array($_POST['checkbox'])){

				    while(list($key,$value) = each($_POST['checkbox'])){

			    		foreach($cadena as $array){

							$fecha = substr($array, 0, 10);
							
							$horaInicio = substr($array, 10);

							$value = 1;

				    		//Modifica la seleccion del hueco en función de lo que ha seleccionado el usuario
				    		$this->encuestaMapper->updateSelection($encuestaid, $fecha, $horaInicio, $email, $value);
						}
				  	}
				}
			}

			//POST-REDIRECT-GET
			//Todo correcto, redirecciona al usuario a ver la encuesta en detalle
			// header("Location: index.php?controller=encuestas&action=view&idEncuesta=$encuestaid")
			// die();
			$this->view->redirect("encuestas", "view", "idEncuesta=".$encuestaid);
		}

		//Envía a la vista encuesta, encuestaParticipantes y encuestaSelecciones
		$this->view->setVariable("encuesta", $encuesta);
		$this->view->setVariable("encuestaParticipantes", $encuestaParticipantes);
		$this->view->setVariable("encuestaSelecciones", $encuestaSelecciones);

		//Comprueba si ya hay una seleccion en la vista, sino pone una vacia
		$seleccion = $this->view->getVariable("seleccion");
		$this->view->setVariable("seleccion", ($seleccion==NULL)?new Hueco():$seleccion);

		//Renderiza la vista (/view/encuestas/participar.php)
		$this->view->render("encuestas", "participar");
	}

	/**
	*Función para modificar la participación en una encuesta
	*/
	public function editParticipation(){

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Participate in encuestas requires login");
		}

		if (!isset($_REQUEST["idEncuesta"])) {

			throw new Exception("id is mandatory");
		}

		$encuestaid = $_REQUEST["idEncuesta"];

		//Obtiene la encuesta con sus huecos de la Base de Datos
		$encuesta = $this->encuestaMapper->findByIdWithHoles($encuestaid);

		//No existe encuesta?
		if ($encuesta == NULL) {

			throw new Exception("no such encuesta with id: ".$encuestaid);
		}

		if(!isset($_POST["submit"])){

			$this->encuestaMapper->deleteSelections($encuestaid, $this->currentUser);

			foreach($encuesta->getHuecos() as $hueco){

				$seleccion = 0;

				//Almacena en la Base de Datos las selecciones a 0
				$this->encuestaMapper->saveSelectionsIni($hueco->getIdEncuesta(), $hueco->getFecha(), $hueco->getHoraInicio(), $this->currentUser, $seleccion);
			}
		}

		//Busca las selecciones para los huecos de la encuesta
		$encuestaSelecciones = $this->encuestaMapper->findSelections($encuestaid);

		if (isset($_POST["submit"])) { //Recibido vía HTTP

			$cadena = $_POST['checkbox'];

			$fecha = null;
			$horaInicio = null;
			
			$email = $this->currentUser;

			if($_POST['checkbox'] != ""){

				if(is_array($_POST['checkbox'])){

				    while(list($key,$value) = each($_POST['checkbox'])){

			    		foreach($cadena as $array){

							$fecha = substr($array, 0, 10);
							
							$horaInicio = substr($array, 10);

							if($value = "on"){

								$value = 1;

				    		//Modifica la seleccion del hueco en función de lo que ha seleccionado el usuario
				    		$this->encuestaMapper->updateSelection($encuestaid, $fecha, $horaInicio, $email, $value);
						}
							}
							
				  	}
				}
			}

			//POST-REDIRECT-GET
			//Todo correcto, redirecciona al usuario a ver la encuesta en detalle
			// header("Location: index.php?controller=encuestas&action=view&idEncuesta=$encuestaid")
			// die();
			$this->view->redirect("encuestas", "view", "idEncuesta=".$encuestaid);
		}

		//Envía encuesta y encuestaSelecciones a la vista
		$this->view->setVariable("encuesta", $encuesta);
		$this->view->setVariable("encuestaSelecciones", $encuestaSelecciones);

		//Comprueba si la selección ya está en la vista, sino envía una vacía
		$seleccion = $this->view->getVariable("seleccion");
		$this->view->setVariable("seleccion", ($seleccion==NULL)?new Hueco():$seleccion);

		//Renderiza la vista (/view/encuestas/editParticipation.php)
		$this->view->render("encuestas", "editParticipation");
	}
}
