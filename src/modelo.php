<?php

/* Plantilla de Modelo */

class Modelo {
	private static $bd;
	
	// Conexión con la base de datos
	public static function conectarBD() {
		// Configuración de los parámetros de conexión (podrían estar en un fichero externo de configuración)
		$dsn = "mysql:dbname=atlas_plus;host=127.0.0.1";
		$usuario = "root";
		$password = "";
		try {
			// Creamos la conexión a la base de datos
			self::$bd = new PDO($dsn,$usuario,$password);
			return(false);
		}
		catch (PDOException $e) {
			// 	Establecemos el mensaje de error según el código y descripción
			$_SESSION["error"] = "Error [".$e->getCode()."] al abrir la base de datos: ".$e->getMessage();
			return($e);
		}
	}
	
	// Desconexión de la base de datos
	public static function desconectarBD() {
		self::$bd = null;
	}

	public static function sacarUsuarios() {
		$stmt = self::$bd->prepare("SELECT * FROM usuarios");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function VerificarUsuario($usuario) {
		self::conectarBD();
		try {
			$stmt = self::$bd->prepare("SELECT pass FROM usuarios WHERE nombre = :usuario");
			$stmt->bindParam(':usuario', $usuario);
			$stmt->execute();
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado ? $resultado['pass'] : null; // Para que sólo devuelva la contraseña, no todo el array
		} finally {
			self::desconectarBD();
		}
	}

	public static function registrarUsuario($nombre, $clave) {
		try {		
			$stmt = self::$bd->prepare("INSERT INTO usuarios (nombre, pass) VALUES (:nombre, :clave)");
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':clave', $clave);
			$stmt->execute();
		} catch (PDOException $e) {
			error_log("Error al registrar usuario: " . $e->getMessage());
        	return false;
		}
	}

	public static function anadirPais($pais, $capital) {
		$stmt = self::$bd->prepare("INSERT INTO atlas (pais, capital) VALUES (:pais, :capital)");
		$stmt->bindParam(':pais', $pais);
		$stmt->bindParam(':capital', $capital);
		$stmt->execute();
	}

	public static function sacarTodo() {
		self::conectarBD();
		$stmt = self::$bd->query("SELECT * FROM atlas");
		$todo = $stmt->fetchAll(PDO::FETCH_ASSOC);
		self::desconectarBD();
		return $todo;
	}

	// ¿Por qué a veces uso query y otras prepare?
	// Según he estado viendo, si no hay bindParam es mejor usar query, en cambio si vamos
	//a hacer bindParam es mejor hacer prepare
	// La consulta funciona mejor y, al parecer, query es más rápido

	public static function sacarPaises() {
		self::conectarBD();
        $stmt = self::$bd->query("SELECT DISTINCT pais FROM atlas");
        $paises = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::desconectarBD();
        return $paises;
	}

	public static function modificarPais($pais, $nuevaCapital) {
		try {
			$stmt = self::$bd->prepare("UPDATE atlas SET capital = :capital WHERE pais = :pais");
			$stmt->bindParam(':capital', $nuevaCapital);
			$stmt->bindParam(':pais', $pais);
			$stmt->execute();
			return $stmt;
		} catch (PDOException $e) {
			$_SESSION['msg_error'] = "Error al modificar: " . $e->getMessage();
			return false;
		} 
	}

	public static function borrarPais($pais) {
		$stmt = self::$bd->prepare("DELETE FROM atlas WHERE pais LIKE :pais");
		$stmt->bindParam(':pais', $pais);
		$stmt->execute();
	}

	public static function buscarPais($pais) {
		$stmt = self::$bd->prepare("SELECT capital FROM atlas WHERE pais = :pais");
		$stmt->bindParam(':pais', $pais);
		$stmt->execute();
		$capital = $stmt->fetch(PDO::FETCH_ASSOC);
		// Esto es para que SÓLO devuelva la capital
		// Si no se pone así devuelve todo en formato array y da error al imprimir la respuesta en controlador
		return $capital ? $capital['capital'] : null;
	}



}

?>