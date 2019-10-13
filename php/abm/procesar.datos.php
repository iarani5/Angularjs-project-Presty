<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/Autorizador.php');
	require_once('../clases/Veraz.php');
	require_once('../clases/Prestamo.php');

	if(isset($_SESSION["s_id"])&&isset($_POST)){
        $autorizador = new Autorizador();
        $rta =  $autorizador->procesar_data($_POST);
        echo $rta;
	}