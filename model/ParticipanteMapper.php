<?php
// file: model/ParticipanteMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Participante.php");

/**
* Class ParticipanteMapper
*
* Interfaz de Base de Datos para las etidades de Participante
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class ParticipanteMapper {

	/**
	* Referencia a PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {

		$this->db = PDOConnection::getInstance();
	}

	/**
	* Busca todos los participantes de una encuesta
	*/
	public function findParticipants($encuestaid){

		$stmt = $this->db->query("SELECT * FROM participaciones WHERE idEncuesta=?");
		$stmt->execute(array($encuestaid));
		$participantes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participantes = array();

		foreach ($participantes_db as $participante) {

			array_push($participantes, new Participante($participante["idEncuesta"], $participante["idParticipante"]));
		}

		return $participantes;
	}
}
