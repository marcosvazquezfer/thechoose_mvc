<?php
// file: model/Usuario.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Usuario
*
* Representa un Usuario de la página
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class Usuario {

	/**
	* El email del usuario
	*/
	private $email;

	/**
	* El nombre completo del usuario
	*/
	private $nombreCompleto;

	/**
	* La contraseña del usuario
	*/
	private $passwd;
	
	public function __construct($email=NULL, $nombreCompleto=NULL, $passwd=NULL) {

		$this->email = $email;
		$this->nombreCompleto = $nombreCompleto;
		$this->passwd = $passwd;
	}

	/**
	* Obtiene el email
	*/
	public function getEmail() {

		return $this->email;
	}

	/**
	* Almacena el email
	*/
	public function setEmail($email) {

		$this->email = $email;
	}

	/**
	* Obtiene el nombre completo
	*/
	public function getNombreCompleto() {

		return $this->nombreCompleto;
	}

	/**
	* Almacena el nombre completo
	*/
	public function setNombreCompleto($nombreCompleto) {

		$this->nombreCompleto = $nombreCompleto;
	}

	/**
	* Obtiene la contraseña
	*/
	public function getPasswd() {

		return $this->passwd;
	}

	/**
	* Almacena la contraseña
	*/
	public function setPassword($passwd) {
		
		$this->passwd = $passwd;
	}

	/**
	* Comprueba si se puede crear el usuario
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForRegister() {

		$errors = array();

		if (strlen($this->email) < 5) {
			$errors["email"] = "Email must be at least 5 characters length";

		}

		if (strlen($this->nombreCompleto) < 5) {
			$errors["email"] = "Complete Name must be at least 5 characters length";

		}

		if (strlen($this->passwd) < 5) {
			$errors["passwd"] = "Password must be at least 5 characters length";
		}

		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
