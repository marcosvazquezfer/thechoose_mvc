<?php
// file: model/SeleccionMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/Hueco.php");
require_once(__DIR__."/../model/Seleccion.php");

/**
* Class SeleccionMapper
*
* Interfaz de Base de Datos para las entidades de Seleccion
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class SeleccionMapper {

	/**
	* Referencia a PDO connection
	*/
	private $db;

	public function __construct() {

		$this->db = PDOConnection::getInstance();
	}
}
