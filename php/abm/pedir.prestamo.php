<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/User.php');
	require_once('../clases/Prestamo.php');
	require_once('../clases/Autorizador.php');
	require_once('../clases/Client.php');

	if(isset($_POST)&&isset($_SESSION["s_id"])){
        $prestamo = new Prestamo();
        $autorizador = new Autorizador();
        $client = new Client();
        $now = new DateTime();

        $_POST["FK_CLIENT"]=$client->getById($_SESSION["s_id"])["ID"];
        $_POST["FK_AUTORIZADOR"]=$autorizador->asignar_autorizador();;
        $_POST["CREATED_DATE"]=$now->format('Y-m-d H:i:s');

        echo $prestamo->crear_prestamo($_POST);
	}
