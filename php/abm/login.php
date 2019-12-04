<?php
header("Access-Control-Allow-Origin: *");

/****** Clases *****/
require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/User.php');
require_once('../clases/Client.php');
require_once('../clases/Financiera.php');

if(isset($_POST)){
    $usuario = new User();
    $fin2=$usuario->login($_POST);
    $fin3=[];
    if(count($fin2)){
       foreach ($fin2 as $k => $v) {

            /***** Guardado de datos en SESSION ****/
            switch($k){
                case "ID":
                    $_SESSION['s_id'] = $v;
                    break;
                case "USER_TYPE":
                    if($v=="Financiera"){
                        $financiera = new Financiera();
                        $fin3 = $financiera->getById($fin2["ID"]);
                    }
                    else if($v=="Cliente"){
                        $client = new Client();
                        $fin3 = $client->getById($fin2["ID"]);
                    }
                    $_SESSION['s_nivel'] = $v;
                    break;
            }
        }

     if(count($fin3)){
            $fin2=array_merge($fin2, $fin3);
        }
        echo json_encode($fin2);
    }
}
