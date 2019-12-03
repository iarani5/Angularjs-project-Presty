<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/User.php');
	require_once('../clases/Oferta.php');
	require_once('../clases/Financiera.php');

	if(isset($_POST)&&isset($_SESSION["s_id"])){
        $financiera = new Financiera();

        $_POST["FK_FINANCIERA"]=$_SESSION["s_id"];
        return $financiera->aceptar_cliente($_POST);
	}
