<?php
// file: model/Encuesta.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Encuesta
*
* Represents una Encuesta. Una encuesta es creada por
* un usuario específico y contiene una lista de huecos
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class Encuesta {

	/**
	* El idEncuesta de la encuesta
	*/
	private $idEncuesta;

	/**
	* El titulo de la encuesta
	*/
	private $titulo;

	/**
	* El link de la encuesta
	*/
	private $link;

	/**
	* The email del creador de la encuesta
	*/
	private $email;

	/**
	* La lista de huecos de la encuesta
	*/
	private $huecos;

	/**
	* La lista de participantes de la encuesta
	*/
	private $participantes;

	/**
	* La lista de huecos seleccionados de la encuesta
	*/
	private $selecciones;

	public function __construct($idEncuesta=NULL, $titulo=NULL, $link=NULL, Usuario $email=NULL, array $huecos=NULL, array $participantes=NULL, array $selecciones=NULL) {

		$this->idEncuesta = $idEncuesta;
		$this->titulo = $titulo;
		$this->link = $link;
		$this->email = $email;
		$this->huecos = $huecos;
		$this->participantes = $participantes;
		$this->selecciones = $selecciones;
	}

	/**
	* Obtiene el idEncuesta
	*/
	public function getIdEncuesta() {

		return $this->idEncuesta;
	}

	/**
	* Obtiene el titulo de la encuesta
	*/
	public function getTitulo() {

		return $this->titulo;
	}

	/**
	* Almacena el titulo de la encuesta
	*/
	public function setTitulo($titulo) {

		$this->titulo = $titulo;
	}

	/**
	* Obtiene el link de la encuesta
	*/
	public function getLink() {

		return $this->link;
	}

	/**
	* Almacena el link de la encuesta
	*/
	public function setLink() {

		$this->link = "http://localhost:8081/Practica_2/index.php?controller=encuestas&action=view&idEncuesta=";
	}

	/**
	* Obtiene el email del creador de la encuesta
	*/
	public function getEmail() {

		return $this->email;
	}

	/**
	* Almacena el creador de la encuesta
	*/
	public function setEmail(Usuario $email) {

		$this->email = $email;
	}

	/**
	* Obtiene la lista de huecos de la encuesta
	*/
	public function getHuecos() {

		return $this->huecos;
	}

	/**
	* Almacena los huecos de la encuesta
	*/
	public function setHuecos(array $huecos) {

		$this->huecos = $huecos;
	}

	/**
	* Obtiene la lista de participantes de la encuesta
	*/
	public function getParticipantes() {

		return $this->participantes;
	}

	/**
	* Almacena los participantes de la encuesta
	*/
	public function setParticipantes(array $participantes) {

		$this->participantes = $participantes;
	}

	/**
	* Obtiene la lista de huecos seleccionados de la encuesta
	*/
	public function getSelecciones() {

		return $this->selecciones;
	}

	/**
	* Almacena los huecos seleccionados de la encuesta
	*/
	public function setSelecciones(array $selecciones) {

		$this->selecciones = $selecciones;
	}

	/**
	* Comprueba si la encuesta es correcta para ser almacena en la base de datos
	*/
	public function checkIsValidForCreate() {

		$errors = array();

		if (strlen(trim($this->titulo)) == 0 ) {
			$errors["titulo"] = "titulo is mandatory";
		}
		if (strlen(trim($this->link)) == 0 ) {
			$errors["link"] = "link is mandatory";
		}
		if ($this->email == NULL ) {
			$errors["email"] = "email is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "post is not validEncuesta");
		}
	}

	/**
	* Comprueba si la encuesta es válida para ser modificada
	*/
	public function checkIsValidForUpdate() {

		$errors = array();

		if (!isset($this->idEncuesta)) {
			$errors["idEncuesta"] = "idEncuesta is mandatory";
		}

		try{
			$this->checkIsValidForCreate();
		}
		catch(ValidationException $ex) {

			foreach ($ex->getErrors() as $key=>$error) {

				$errors[$key] = $error;
			}
		}

		if (sizeof($errors) > 0) {
			
			throw new ValidationException($errors, "post is not validEncuesta");
		}
	}
}
