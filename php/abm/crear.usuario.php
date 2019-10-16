<?php
	//header("Access-Control-Allow-Origin: *");
	
	/****** Clases *****/
	
	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/User.php');
	require_once('../clases/Financiera.php');
	require_once('../clases/Client.php');

	if(isset($_POST)){

        if($_POST["USER_TYPE"]=="Financiera"){
            $financiera = new Financiera();
            if(isset($_POST["EDITAR"])){
                return $financiera->editar_financiera($_POST);
            }
            else{
                return $financiera->crear_financiera($_POST);
            }
        }
        else if($_POST["USER_TYPE"]=="Cliente"){
            $client = new Client();
            if(isset($_POST["EDITAR"])){
                return $client->editar_cliente($_POST);
            }
            else {
                return $client->crear_cliente($_POST);
            }
        }
	}



?>