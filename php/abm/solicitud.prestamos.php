<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/Prestamo.php');
	require_once('../clases/User.php');
	require_once('../clases/Client.php');
	require_once('../clases/Financiera.php');
	require_once('../clases/Oferta.php');

	if(isset($_SESSION["s_id"])){
        $financiera = new Financiera;
        return $financiera->solicitud_de_prestamo($_SESSION["s_id"]);
    }

?>