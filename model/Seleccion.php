<?php
// file: model/Seleccion.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Seleccion
*
* Representa la seleccion de un hueco de una encuesta
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class Seleccion {

	/**
	* El idENcuesta del hueco
	*/
	private $idEncuesta;

	/**
	* La fecha del hueco
	*/
	private $fecha;

	/**
	* La hora de inicio del hueco
	*/
	private $horaInicio;

	/**
	* La creador del hueco
	*/
	private $email;

	/**
	* La seleccion del hueco
	*/
	private $seleccion;

	public function __construct($idEncuesta=NULL, $fecha=NULL, $horaInicio=NULL, $email=NULL, $seleccion=NULL) {

		$this->idEncuesta = $idEncuesta;
		$this->fecha = $fecha;
		$this->horaInicio = $horaInicio;
		$this->email = $email;
		$this->seleccion = $seleccion;
	}

	/**
	* Obtiene el idEncuesta
	*/
	public function getIdEncuesta(){

		return $this->idEncuesta;
	}

	/**
	* Almacena el idEncuesta
	*/
	public function setIdEncuesta($idEncuesta) {

		$this->idEncuesta = $idEncuesta;
	}

	/**
	* Obtiene la fecha
	*/
	public function getFecha() {

		return $this->fecha;
	}

	/**
	* ALmacena la fecha
	*/
	public function setFecha($fecha) {

		$this->fecha = $fecha;
	}

	/**
	* Obtiene la hora de inicio
	*/
	public function getHoraInicio() {

		return $this->horaInicio;
	}

	/**
	* Almacena la hora de inicio
	*/
	public function setHoraInicio($horaInicio){
		$this->horaInicio = $horaInicio;
	}

	/**
	* Obtiene el email delc readore
	*/
	public function getEmail() {

		return $this->email;
	}

	/**
	* Almacena el email del creador
	*/
	public function setEmail($email) {

		$this->email = $email;
	}

	/**
	* Obtiene la seleccion
	*/
	public function getSeleccion() {

		return $this->seleccion;
	}

	/**
	* Almacena la seleccion
	*/
	public function setSeleccion($seleccion) {

		$this->seleccion = $seleccion;
	}
}
