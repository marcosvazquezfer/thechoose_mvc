<?php
// file: model/HuecoMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Hueco.php");
require_once(__DIR__."/../model/Seleccion.php");

/**
* Class HuecoMapper
*
* Interfaz de Base de Datos para las entidades de Hueco
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class HuecoMapper {

	/**
	* Referencia a PDO connection
	*/
	private $db;

	public function __construct() {

		$this->db = PDOConnection::getInstance();
	}

	/**
	* Almacena un hueco
	*/
	public function save(Hueco $hueco) {

		$stmt = $this->db->prepare("INSERT INTO huecos(idEncuesta, fecha, horaInicio, horaFin) values (?,?,?,?)");
		$stmt->execute(array($hueco->getIdEncuesta(), $hueco->getFecha(), $hueco->getHoraInicio(), $hueco->getHoraFin()));
		
		return $this->db->lastInsertId();
	}

	/**
	* Elimina un hueco
	*/
	public function delete($encuestaid, $fecha, $horaInicio, $horaFin) {

		$stmt = $this->db->prepare("DELETE FROM huecos WHERE idEncuesta=? AND fecha=? AND horaInicio=? AND horaFin=?");
		$stmt->execute(array($encuestaid, $fecha, $horaInicio, $horaFin));
	}
}
