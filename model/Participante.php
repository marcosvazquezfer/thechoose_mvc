<?php
// file: model/Participante.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Participante
*
* Representa un participante de una encuesta
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class Participante {

	/**
	* EL idEncuetsa
	*/
	private $idEncuesta;

	/**
	* El idParticipante
	*/
	private $idParticipante;

	public function __construct($idEncuesta=NULL, $idParticipante=NULL) {

		$this->idEncuesta = $idEncuesta;
		$this->idParticipante = $idParticipante;
	}

	/**
	* Obtiene el idEncuesta
	*/
	public function getIdEncuesta() {

		return $this->idEncuesta;
	}

	/**
	* Obtiene el idParticipante
	*/
	public function getIdParticipante() {

		return $this->idParticipante;
	}

	/**
	* Almacena el idParticipante
	*/
	public function setIdParticipante($idParticipante) {

		$this->idParticipante = $idParticipante;
	}
}
