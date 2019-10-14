<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/User.php');
	require_once('../clases/Client.php');
	require_once('../clases/Prestamo.php');

	if(isset($_SESSION["s_id"])){
        $prestamo = new Prestamo();

        echo json_encode($prestamo->estado_prestamo($_SESSION["s_id"]));
	}
