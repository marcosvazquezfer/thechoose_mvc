<?php
// file: model/EncuestaMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/Hueco.php");
require_once(__DIR__."/../model/Participante.php");
require_once(__DIR__."/../model/Seleccion.php");


/**
* Class EncuestaMapper
*
* Interfaz de Base de Datos para las entidades de Encuesta
*
* @author Marcos Vázquez Fernández
* @author Lara Souto Alonso
*/
class EncuestaMapper {

	/**
	* Referencia a PDO connection
	*/
	private $db;

	public function __construct() {

		$this->db = PDOConnection::getInstance();
	}

	/**
	* Devuelve todas las encuestas
	*/
	public function findAll() {

		$stmt = $this->db->query("SELECT * FROM encuestas, usuarios WHERE usuarios.email = encuestas.email");
		$encuestas_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$encuestas = array();

		foreach ($encuestas_db as $encuesta) {

			$email = new Usuario($encuesta["email"]);
			array_push($encuestas, new Encuesta($encuesta["idEncuesta"], $encuesta["titulo"], $encuesta["link"], $email));
		}

		return $encuestas;
	}

	/**
	* Retrieves todos los participantes
	*/
	public function findAllParticipants() {

		$stmt = $this->db->query("SELECT * FROM participaciones, usuarios WHERE usuarios.email = participaciones.email");
		$participantes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participantes = array();

		foreach ($participantes_db as $participante) {

			array_push($participantes, new Participante($participante["idEncuesta"], $participante["email"]));
		}

		return $participantes;
	}

	/**
	* Busca una encuesta por su id
	*/
	public function findById($encuestaid){

		$stmt = $this->db->prepare("SELECT * FROM encuestas WHERE idEncuesta=?");
		$stmt->execute(array($encuestaid));
		$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

		if($encuesta != null) {

			return new Encuesta(
			$encuesta["idEncuesta"],
			$encuesta["titulo"],
			$encuesta["link"],
			new Usuario($encuesta["email"]));
		} 
		else {
			return NULL;
		}
	}

	/**
	* Busca una encuesta por su creador y su link
	*/
	public function findByEmailLink($link, $email){

		$stmt = $this->db->prepare("SELECT * FROM encuestas WHERE link=? AND email=?");
		$stmt->execute(array($link, $email->getEmail()));
		$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

		if($encuesta != null) {

			return new Encuesta(
			$encuesta["idEncuesta"],
			$encuesta["titulo"],
			$encuesta["link"],
			new Usuario($encuesta["email"]));
		} 
		else {
			return NULL;
		}
	}

	/**
	* Busca una encuesta con sus huecos a partir del id
	*/
	public function findByIdWithHoles($encuestaid){

		$stmt = $this->db->prepare("SELECT
			E.idEncuesta as 'encuesta.idEncuesta',
			E.titulo as 'encuesta.titulo',
			E.link as 'encuesta.link',
			E.email as 'encuesta.email',
			H.idEncuesta as 'hueco.idEncuesta',
			H.fecha as 'hueco.fecha',
			H.horaInicio as 'hueco.horaInicio',
			H.horaFin as 'hueco.horaFin'

			FROM encuestas E LEFT OUTER JOIN huecos H
			ON E.idEncuesta = H.idEncuesta
			WHERE
			E.idEncuesta=? ");

		$stmt->execute(array($encuestaid));
		$encuesta_wt_holes= $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (sizeof($encuesta_wt_holes) > 0) {

			$encuesta = new Encuesta($encuesta_wt_holes[0]["encuesta.idEncuesta"],
			$encuesta_wt_holes[0]["encuesta.titulo"],
			$encuesta_wt_holes[0]["encuesta.link"],
			new Usuario($encuesta_wt_holes[0]["encuesta.email"]));

			$huecos_array = array();

			if ($encuesta_wt_holes[0]["hueco.idEncuesta"]!=null) {

				foreach ($encuesta_wt_holes as $hueco){

					$hueco = new Hueco( new Encuesta($hueco["hueco.idEncuesta"]),
					$hueco["hueco.fecha"], $hueco["hueco.horaInicio"], $hueco["hueco.horaFin"]);

					array_push($huecos_array, $hueco);
				}
			}

			$encuesta->setHuecos($huecos_array);

			return $encuesta;
		}
		else {
			return NULL;
		}
	}

	/**
	* Busca una encuesta por su creador
	*/
	public function findByEmail($email){

		$stmt = $this->db->prepare("SELECT * FROM encuestas WHERE email=?");
		$stmt->execute(array($email->getEmail()));
		$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

		if($encuesta != null) {

			return new Encuesta(
			$encuesta["idEncuesta"],
			$encuesta["titulo"],
			$encuesta["link"],
			new Usuario($encuesta["email"]));
		} 
		else {
			return NULL;
		}
	}

	/**
	* Almacena una encuesta en la Base de Datos
	*/
	public function save(Encuesta $encuesta) {

		$stmt = $this->db->prepare("INSERT INTO encuestas(link,email) values (?,?)");
		$stmt->execute(array($encuesta->getLink(), $encuesta->getEmail()->getEmail()));

		return $this->db->lastInsertId();
	}

	/**
	* Actualiza una encuesta en la Base de Datos
	*/
	public function update(Encuesta $encuesta) {

		$stmt = $this->db->prepare("UPDATE encuestas SET titulo=? WHERE idEncuesta=?");
		$stmt->execute(array($encuesta->getTitulo(), $encuesta->getIdEncuesta()));
	}

	/**
	* Actualiza el link de la encuesta
	*/
	public function updateLink(Encuesta $encuesta) {

		$stmt = $this->db->prepare("UPDATE encuestas set link=CONCAT(?,?) where idEncuesta=?");
		$stmt->execute(array($encuesta->getLink(), $encuesta->getIdEncuesta(), $encuesta->getIdEncuesta()));
	}

	/**
	* Almacena un participante de la encuesta
	*/
	public function saveParticipant($encuestaid, $currentuser){

		$stmt = $this->db->prepare("SELECT * FROM participaciones WHERE idEncuesta=? AND email=?");
		$stmt->execute(array($encuestaid, $currentuser->getEmail()));
		$participante = $stmt->fetch(PDO::FETCH_ASSOC);

		if($participante == null){

			$stmt = $this->db->prepare("INSERT INTO participaciones(idEncuesta,email) values (?,?)");
			$stmt->execute(array($encuestaid, $currentuser->getEmail()));
		}
		else{
			return NULL;
		}
	}

	/**
	* Almacena al creador de la encuesta como participante
	*/
	public function saveParticipantAdd($encuestaid, $currentuser){

		$stmt = $this->db->prepare("SELECT * FROM participaciones WHERE idEncuesta=? AND email=?");
		$stmt->execute(array($encuestaid->getIdEncuesta(), $currentuser->getEmail()));
		$participante = $stmt->fetch(PDO::FETCH_ASSOC);

		if($participante == null){

			$stmt = $this->db->prepare("INSERT INTO participaciones(idEncuesta,email) values (?,?)");
			$stmt->execute(array($encuestaid->getIdEncuesta(), $currentuser->getEmail()));
		}
		else{
			return NULL;
		}
	}

	/**
	* Busca los participantes de una encuesta
	*/
	public function findParticipants($encuestaid){

		$stmt = $this->db->prepare("SELECT
			E.idEncuesta as 'encuesta.idEncuesta',
			E.titulo as 'encuesta.titulo',
			E.link as 'encuesta.link',
			E.email as 'encuesta.email',
			P.idEncuesta as 'participante.idEncuesta',
			P.email as 'participante.idParticipante'

			FROM encuestas E LEFT OUTER JOIN participaciones P
			ON E.idEncuesta = P.idEncuesta
			WHERE
			E.idEncuesta=? ");

		$stmt->execute(array($encuestaid));
		$encuesta_wt_participants= $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (sizeof($encuesta_wt_participants) > 0) {

			$encuesta = new Encuesta($encuesta_wt_participants[0]["encuesta.idEncuesta"],
			$encuesta_wt_participants[0]["encuesta.titulo"],
			$encuesta_wt_participants[0]["encuesta.link"],
			new Usuario($encuesta_wt_participants[0]["encuesta.email"]));

			$participantes_array = array();

			if ($encuesta_wt_participants[0]["participante.idEncuesta"]!=null) {

				foreach ($encuesta_wt_participants as $participante){

					$participante = new Participante( new Encuesta($participante["participante.idEncuesta"]),
					$participante["participante.idParticipante"]);

					array_push($participantes_array, $participante);
				}
			}

			$encuesta->setParticipantes($participantes_array);

			return $encuesta;
		}
		else {
			return NULL;
		}
	}

	/**
	* Busca las selecciones de una encuesta
	*/
	public function findSelections($encuestaid){

		$stmt = $this->db->prepare("SELECT
			E.idEncuesta as 'encuesta.idEncuesta',
			E.titulo as 'encuesta.titulo',
			E.link as 'encuesta.link',
			E.email as 'encuesta.email',
			S.idEncuesta as 'seleccion.idEncuesta',
			S.fecha as 'seleccion.fecha',
			S.horaInicio as 'seleccion.horaInicio',
			S.email as 'seleccion.email',
			S.seleccion as 'seleccion.seleccion'

			FROM encuestas E LEFT OUTER JOIN seleccionados S
			ON E.idEncuesta = S.idEncuesta
			WHERE
			E.idEncuesta=? ");

		$stmt->execute(array($encuestaid));
		$encuesta_wt_selections= $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (sizeof($encuesta_wt_selections) > 0) {

			$encuesta = new Encuesta($encuesta_wt_selections[0]["encuesta.idEncuesta"],
			$encuesta_wt_selections[0]["encuesta.titulo"],
			$encuesta_wt_selections[0]["encuesta.link"],
			new Usuario($encuesta_wt_selections[0]["encuesta.email"]));

			$selecciones_array = array();

			if ($encuesta_wt_selections[0]["seleccion.idEncuesta"]!=null) {

				foreach ($encuesta_wt_selections as $seleccion){

					$seleccion = new Seleccion( new Encuesta($seleccion["seleccion.idEncuesta"]),
					$seleccion["seleccion.fecha"], $seleccion["seleccion.horaInicio"], $seleccion["seleccion.email"], $seleccion["seleccion.seleccion"]);

					array_push($selecciones_array, $seleccion);
				}
			}

			$encuesta->setSelecciones($selecciones_array);

			return $encuesta;
		}
		else {
			return NULL;
		}
	}

	/**
	* Almacena todas las selecciones de huecos de la encuesta a 0
	*/
	public function saveSelectionsIni($encuestaid, $fecha, $horaInicio, $email, $seleccion) {

		$stmt = $this->db->prepare("INSERT INTO seleccionados(idEncuesta,fecha,horaInicio,email,seleccion) values (?,?,?,?,?)");
		$stmt->execute(array($encuestaid->getIdEncuesta(), $fecha, $horaInicio, $email->getEmail(), $seleccion));

		return $this->db->lastInsertId();
	}

	/**
	* Actualiza los huecos seleccionados de la encuesta
	*/
	public function updateSelection($encuestaid, $fecha, $horaInicio, $email, $value) {

		$stmt = $this->db->prepare("UPDATE seleccionados SET seleccion=? WHERE idEncuesta=? AND fecha=? AND horaInicio=? AND email=?");
		$stmt->execute(array($value, $encuestaid, $fecha, $horaInicio, $email->getEmail()));

		return $this->db->lastInsertId();
	}

	/**
	* Elimina todas las selecciones de un hueco en función del idEncuesta y del usuario
	*/
	public function deleteSelections($encuestaid, $currentuser){

		$stmt = $this->db->prepare("DELETE FROM seleccionados WHERE idEncuesta=? AND email=?");
		$stmt->execute(array($encuestaid, $currentuser->getEmail()));
	}
}
