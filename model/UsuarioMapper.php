<?php
// file: model/UsuarioMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class UsuarioMapper
*
* Interfaz de Base de Datos para las entidades de usuario
*
* @author Marcos Vázquez Fernández
*/
class UsuarioMapper {

	/**
	* Referencia a PDO connection
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Almacena el usuario en la Base de Datos
	*/
	public function save($usuario) {

		$stmt = $this->db->prepare("INSERT INTO usuarios values (?,?,?)");
		$stmt->execute(array($usuario->getEmail(), $usuario->getNombreCompleto(), $usuario->getPasswd()));
	}

	/**
	* Comprueba si existe el email
	*/
	public function emailExists($email) {

		$stmt = $this->db->prepare("SELECT count(email) FROM usuarios where email=?");
		$stmt->execute(array($email));

		if ($stmt->fetchColumn() > 0) {

			return true;
		}
	}

	/**
	* Comprueba si el usuario y la contraseña ya están almacenados
	*/
	public function isValidUser($email, $passwd) {

		$stmt = $this->db->prepare("SELECT count(email) FROM usuarios where email=? and passwd=?");
		$stmt->execute(array($email, $passwd));

		if ($stmt->fetchColumn() > 0) {
			
			return true;
		}
	}
}
