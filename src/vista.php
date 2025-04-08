<?php

class Vista {
	public static function usuarioLogin() {
		$contenido = 'login.html';
		include './frm/main.php';
	}
	public static function mostrarPrincipal() {
		include './frm/main.php';
	}
	public static function usuarioRegistro() {
		$contenido = 'inicioSesion.html';
		include './frm/main.php';
	}
	public static function usuarioAlta() {
		$contenido = 'registro.html';
		include './frm/main.php';
	}
	public static function atlasAnadir() {
		$contenido = 'frm_alta.html';
		include './frm/main.php';
	}
	public static function atlasModificar() {
		$contenido = 'frm_modificar.php';
		include './frm/main.php';
	}
	public static function atlasMostrar() {
		$contenido = 'frm_mostrar.php';
		include './frm/main.php';
	}
	public static function atlasEliminar() {
		$contenido = 'frm_eliminar.php';
		include './frm/main.php';
	}
	public static function atlasBuscar() {
		$contenido = 'frm_buscar.html';
		include './frm/main.php';
	}
}
?>