<?php
//file: /controller/HuecosController.php

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/Hueco.php");

require_once(__DIR__."/../model/EncuestaMapper.php");
require_once(__DIR__."/../model/HuecoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Clase HuecosController
*
* Controller para huecos relacionados con ese caso de uso.
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class HuecosController extends BaseController {

	/**
	* Referencia a HuecoMapper para interactúar con la Base de Datos
	*/
	private $huecomapper;

	/**
	* Referencia a EncuestaMapper para interactúar con la Base de Datos
	*/
	private $encuestamapper;

	public function __construct() {

		parent::__construct();

		$this->huecomapper = new HuecoMapper();
		$this->encuestamapper = new EncuestaMapper();
	}

	/**
	* Función para añadir un hueco a una encuesta
	*/
	public function add() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Adding polls requires login");
		}

		$encuestaid = $_GET["idEncuesta"];

		$hueco = new Hueco();

		if (isset($_POST["submit"])) { //Recibido vía HTTP
			
			$encuestaid = $_GET["idEncuesta"];

			//Rellena el objeto Hueco con los datos recibidos del formulario
			$hueco->setIdEncuesta($encuestaid);
			$hueco->setFecha($_POST["fecha"]);
			$hueco->setHoraInicio($_POST["horaInicio"]);
			$hueco->setHoraFin($_POST["horaFin"]);

			try {

				//Valida el objeto Hueco
				$hueco->checkIsValidForCreate();

				//Almacena el hueco en la Base de Datos
				$this->huecomapper->save($hueco);

				// POST-REDIRECT-GET
				// Todo correcto, redirige al usuario a editar la encuesta
				// header("Location: index.php?controller=posts&action=edit&idEncuesta=$encuestaid")
				// die();
				$this->view->redirect("encuestas", "edit", "idEncuesta=".$encuestaid);
			}
			catch(ValidationException $ex) {

				$errors = $ex->getErrors();

				$this->view->setVariable("hueco", $hueco, true);
				$this->view->setVariable("errors", $errors, true);
			}
		}

		//Envía hueco a la vista
		$this->view->setVariable("hueco", $hueco);
		//Envía encuesta a la vista
		$this->view->setVariable("encuesta", $encuestaid);

		//Renderiza la vista(/view/huecos/add.php)
		$this->view->render("huecos", "add");
	}

	/**
	* Función para borrar un hueco
	*/
	public function delete() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Adding polls requires login");
		}

		$encuestaid = $_GET["idEncuesta"];

		$hueco = new Hueco();

		if (isset($_POST["submit"])) { //RECIBIDO VÍA http
			
			$encuestaid = $_GET["idEncuesta"];
			$fecha = $_POST["fecha"];
			$horaInicio = $_POST["horaInicio"];
			$horaFin = $_POST["horaFin"];

			try {

				//Elimina el hueco de la Base de Datos
				$this->huecomapper->delete($encuestaid, $fecha, $horaInicio, $horaFin);

				// POST-REDIRECT-GET
				// Todo correcto, redirige al usuario a editar encuesta
				// header("Location: index.php?controller=encuestas&action=edit&id=$encuestaid")
				// die();
				$this->view->redirect("encuestas", "edit", "idEncuesta=".$encuestaid);
			}
			catch(ValidationException $ex) {

				$errors = $ex->getErrors();

				$this->view->setVariable("hueco", $hueco, true);
				$this->view->setVariable("errors", $errors, true);

				$this->view->redirect("encuestas", "edit", "idEncuesta=".$encuesta->getIdEncuesta());
			}
		}

		//Envía hueco a la vista
		$this->view->setVariable("hueco", $hueco);
		//Envía encuesta a la vista
		$this->view->setVariable("encuesta", $encuestaid);

		//Renderiza la vista (/view/huecos/delete.php)
		$this->view->render("huecos", "delete");
	}
}
