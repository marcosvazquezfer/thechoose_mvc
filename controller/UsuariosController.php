<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class UsuariosController
*
* Controller para entrar, salir y registrarse en la página
*
* @author Marcos Vázquez Fernández
*/
class UsuariosController extends BaseController {

	/**
	* Referencia a UsuarioMapper para interactúar con la Base de Datos
	*
	* @var usuarioMapper
	*/
	private $usuarioMapper;

	public function __construct() {
		parent::__construct();

		$this->usuarioMapper = new UsuarioMapper();

		// usuarios controller trabaja en una plantilla "welcome"
		// diferente de la plantilla "default"
		$this->view->setLayout("welcome");
	}

	/**
	* Función para accedar a la página
	*/
	public function login() {

		if (isset($_POST["email"])){ //Recibido vía HTTP

			//procesa el formulario de login
			if ($this->usuarioMapper->isValidUser($_POST["email"], 							 $_POST["passwd"])) {

				$_SESSION["currentuser"]=$_POST["email"];

				// envia al usuario al área restringida (HTTP 302 code)
				$this->view->redirect("encuestas", "index");

			}else{
				$errors = array();
				$errors["general"] = "Email is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}

		//Renderiza la vista (/view/usuarios/login.php)
		$this->view->render("usuarios", "login");
	}

	/**
	* Función para registrarse en la página
	*/
	public function register() {

		$usuario = new Usuario();

		if (isset($_POST["email"])){ // Recibido vía HTTTP POST

			// Rellena el objeto Usuario con los datos recibidos del formulario
			$usuario->setEmail($_POST["email"]);
			$usuario->setNombreCompleto($_POST["nombreCompleto"]);
			$usuario->setPassword($_POST["passwd"]);

			try{
				$usuario->checkIsValidForRegister();

				//Comprueba si existe el usuario en la base de datos
				if (!$this->usuarioMapper->emailExists($_POST["email"])){

					// almacena el objeto usuario en la base de datos
					$this->usuarioMapper->save($usuario);

					// POST-REDIRECT-GET
					// Todo correcto, redirige al usuario a logearse en la página
					$this->view->setFlash("Email ".$usuario->getEmail()." successfully added. Please login now");

					// header("Location: index.php?controller=usuarios&action=login")
					// die();
					$this->view->redirect("usuarios", "login");
				} else {
					$errors = array();
					$errors["email"] = "Email already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				//Obtiene los errores dentro de la excepción
				$errors = $ex->getErrors();
				// Y los envía a la vista
				$this->view->setVariable("errors", $errors);
			}
		}

		// Envía el objeto usuario a la vista
		$this->view->setVariable("usuario", $usuario);

		//Renderiza la vista (/view/usuarios/register.php)
		$this->view->render("usuarios", "register");

	}

	/**
	* Función para salir de la página
	*/
	public function logout() {
		session_destroy();

		// header("Location: index.php?controller=usuarios&action=login")
		// die();
		$this->view->redirect("usuarios", "login");

	}
}
