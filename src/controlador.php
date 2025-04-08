<?php
session_start();
/* $logueado = $_SESSION['log']; */

class Controlador {
	
	// Para mostrar la home
	public static function usuarioLogin() {
		$_SESSION['registrado'] = false;
		Vista::usuarioLogin();
	}

	// Para iniciar sesión
	public static function usuarioRegistro() {
		// Gestionar el inicio de sesión

		$usuario = $_POST['usuario'];
		$password = $_POST['clave'];

		$clave = Modelo::VerificarUsuario($usuario);

		if ($clave === null) {
			// El usuario no existe
			$_SESSION['registrado'] = false;
			$_SESSION['msg_aviso'] = "El usuario no existe";
			Vista::usuarioLogin();
			unset($_SESSION['msg_aviso']);
		} elseif ($clave === $_POST['clave']) {
			// La contraseña es correcta
			$_SESSION['registrado'] = true;
			$_SESSION['msg_info'] = "Inicio sesión OK";
			Vista::usuarioRegistro();
			unset($_SESSION['msg_info']);
			// Qué es password_verify???
			// Función específica de PHP para verificar si una contraseña en texto plano coincide
			//con un hash almacenado en la BD
		} else {
			// Contraseña incorrecta
			$_SESSION['registrado'] = false;
			$_SESSION['msg_error'] = "La contraseña es incorrecta";
			Vista::usuarioLogin();
			// Otra opción en vez de unset sería poner la variable vacía '', pero así borramos el contenido y es mejor
			// Hacemos esto para que no se esté mostrando el mensaje todo el rato, con que salga una vez es suficiente
			unset($_SESSION['msg_error']);
		}
	}

	// Nuevo usuario: registro
	public static function usuarioAlta() {
		Vista::usuarioAlta();

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']['usuario_alta'])) {
			$nombre = $_POST['usuario'];
			$clave = $_POST['clave'];
			
			Modelo::conectarBD();
			Modelo::registrarUsuario($nombre, $clave);
			Modelo::desconectarBD();
			$_SESSION['msg_info'] = "Usuario registrado correctamente";
			/* unset($_SESSION['msg_info']); */
		}
	}

	public static function atlasAnadir() {
		Vista::atlasAnadir();

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atlas_anadir'])) {
			Modelo::conectarBD();
			Modelo::anadirPais($_POST['pais'], $_POST['capital']);
			Modelo::desconectarBD();
			$_SESSION['msg_info'] = "País agregado correctamente";
			unset($_SESSION['msg_info']);
		}
	}

	public static function atlasModificar() {
		Vista::atlasModificar();

		// Hago este if para que no me salga el warning de [pais] vacío
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pais'], $_POST['nuevaCapital'])) {

			Modelo::conectarBD();
			$pais = $_POST['pais'];
			$nuevaCapital = $_POST['nuevaCapital'];

			$cambios = Modelo::modificarPais($pais, $nuevaCapital);

			Modelo::desconectarBD();
		}
	}

	public static function atlasEliminar() {
		/* Vista::atlasEliminar(); */

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paisEliminar'])) {

			Modelo::conectarBD();
			$pais = $_POST['paisEliminar'];

			$eliminar = Modelo::borrarPais($pais);

			Modelo::desconectarBD();

			// Pongo la Vista aquí para que se actualice el select con los países que quedan después de eliminar
			Vista::atlasEliminar();
		} else {
			// Pongo la Vista en el else para que se cargue nada más se entre en la página, pero
			//no se duplique al borrar
			Vista::atlasEliminar();
		}
	}

	public static function atlasMostrar() {
		Vista::atlasMostrar();

		Modelo::conectarBD();
		Modelo::sacarPaises();
		Modelo::desconectarBD();
	}

	public static function atlasBuscar() {
		Vista::atlasBuscar();

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paisBuscar'])) {
			Modelo::conectarBD();

			$pais = $_POST['paisBuscar'];
			$capital = Modelo::buscarPais($pais);

			if (empty($capital)) {
				echo "No se encontró el país";
			} else {
				/* echo "La capital de " . htmlspecialchars($pais) . " es: " . htmlspecialchars($capital); */
				echo "La capital de " . $pais . " es: " . $capital;
			}

			Modelo::desconectarBD();
		}
	}

}

// Inicializamos la variable de acción para evitar errores si no existe
if (!isset($_POST['accion'])) $opcion[0] = ''; else $opcion = array_keys($_POST['accion']);

// En $opcion[0] está almacenada la acción elegida por el usuario,
// por ejemplo "usuario_registro" o "usuario_alta"
switch ($opcion[0]) {
	// Acceso de usuario
	case "usuario_registro":
		Controlador::usuarioRegistro();
		break;
	// Registro de usuario
	case "usuario_alta":
		Controlador::usuarioAlta();
		break;
	// Alta de entrada en atlas
	case "atlas_anadir":
		Controlador::atlasAnadir();
		break;
	// Modificar entrada en atlas
	case "atlas_modificar":
		Controlador::atlasModificar();
		break;
	// Mostrar contenido del atlas
	case "atlas_mostrar":
		Controlador::atlasMostrar();
		break;
	// Baja de entrada en atlas
	case "atlas_eliminar":
		Controlador::atlasEliminar();
		break;
	// Buscar entrada en atlas
	case "atlas_buscar":
		Controlador::atlasBuscar();
		break;
	default:
		Controlador::usuarioLogin();
}
	
?>