<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/Prestamo.php');
	require_once('../clases/User.php');
	require_once('../clases/Client.php');
	require_once('../clases/Autorizador.php');

	if(isset($_SESSION["s_id"])){
        $autorizador = new Autorizador;
        return $autorizador->ver_pedido_prestamo($_SESSION["s_id"]);
    }