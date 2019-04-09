<?php
// file: model/Hueco.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Hueco
*
* Representa un hueco de la encuesta.
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class Hueco {

	/**
	* El idEncuesta de un hueco
	*/
	private $idEncuesta;

	/**
	* La fecha de un hueco
	*/
	private $fecha;

	/**
	* LA hora de Inicio de un hueco
	*/
	private $horaInicio;

	/**
	* LA hora de fin de un hueco
	*/
	private $horaFin;

	public function __construct($idEncuesta=NULL, $fecha=NULL, $horaInicio=NULL, $horaFin=NULL) {

		$this->idEncuesta = $idEncuesta;
		$this->fecha = $fecha;
		$this->horaInicio = $horaInicio;
		$this->horaFin = $horaFin;
	}

	/**
	* Obtiene el idEncuesta de un hueco
	*/
	public function getIdEncuesta(){

		return $this->idEncuesta;
	}

	/**
	* ALmacena el idEncuesta de un hueco
	*/
	public function setIdEncuesta($idEncuesta) {

		$this->idEncuesta = $idEncuesta;
	}

	/**
	* Obtiene la fecha d eun hueco
	*/
	public function getFecha() {

		return $this->fecha;
	}

	/**
	* Almacena a fecha de un hueco
	*/
	public function setFecha($fecha) {

		$this->fecha = $fecha;
	}

	/**
	* Obtiene la hora de inicio de un hueco
	*/
	public function getHoraInicio() {

		return $this->horaInicio;
	}

	/**
	* Almacena la hora de inicio de un hueco
	*/
	public function setHoraInicio($horaInicio){
		$this->horaInicio = $horaInicio;
	}

	/**
	* Obtiene la hora de fin de un hueco
	*/
	public function getHoraFin() {

		return $this->horaFin;
	}

	/**
	* Almacena la hora de fin de un hueco
	*/
	public function setHoraFin($horaFin) {

		$this->horaFin = $horaFin;
	}

	/**
	* Comprueba si el hueco es válido para ser creado
	*/
	public function checkIsValidForCreate() {

		$errors = array();

		if (strlen(trim($this->fecha)) < 2 ) {
			$errors["fecha"] = "fecha is mandatory";
		}

		if ($this->horaInicio == NULL ) {
			$errors["horaInicio"] = "horaInicio is mandatory";
		}
		
		if ($this->horaFin == NULL ) {
			$errors["horaFin"] = "horaFin is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "hole is not validEncuesta");
		}
	}
}
