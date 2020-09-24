<?php
	header("Access-Control-Allow-Origin: *");
	
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
               // echo json_encode($financiera->editar_financiera($_POST));
                if($financiera->editar_financiera($_POST)){
                    echo json_encode($financiera->getById($_POST["ID"]));
                }
            }
            else{
                echo $financiera->crear_financiera($_POST);
            }
        }
        else if($_POST["USER_TYPE"]=="Cliente"){
            $client = new Client();
            if(isset($_POST["EDITAR"])){
                if($client->editar_cliente($_POST)){
                   echo json_encode($client->getById($_POST["FK_USER"]));
                }
            }
            else {
                echo $client->crear_cliente($_POST);
            }
        }
	}



