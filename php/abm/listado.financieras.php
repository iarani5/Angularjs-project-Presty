<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/User.php');
	require_once('../clases/Prestamo.php');
	require_once('../clases/Oferta.php');
	require_once('../clases/Financiera.php');
	require_once('../clases/Autorizador.php');

	if(isset($_SESSION["s_id"])&&isset($_POST["FK_PRESTAMO"])){
        $autorizador = new Autorizador;
        return $autorizador->listar_financieras($_POST["FK_PRESTAMO"]);
    }