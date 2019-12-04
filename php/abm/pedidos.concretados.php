<?php
 header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/Prestamo.php');
require_once('../clases/User.php');
require_once('../clases/Client.php');
require_once('../clases/Financiera.php');

if(isset($_SESSION["s_id"])){
    $financiera = new Financiera;
    $client = new Client;
    $user = new User;
    $rta=$financiera->brindar_prestamo($financiera->getById($_SESSION["s_id"])["ID"]);
    foreach($rta as $unOfertado){
        $rta2= $client->getByPk($unOfertado->getFkClient());
        if($rta2["BORRADO"]=="No"){
            $array=[
                "ID"=>$rta2["ID"],
                "NAME"=>$rta2["NAME"],
                "LAST_NAME"=>$rta2["LAST_NAME"],
                "DNI"=>$rta2["DNI"],
                "BIRTH_DAY"=>$rta2["BIRTH_DAY"],
                "PHONE"=>$rta2["PHONE"],
                "AMOUNT"=>$unOfertado->getAmount(),
                "CREATED_DATE"=>$unOfertado->getCreatedDate(),
            ];
            $arrayFinal[]=$array;
        }

   }
    echo json_encode($arrayFinal);



    //echo json_encode( $financiera->brindar_prestamo($financiera->getById($_SESSION["s_id"])["ID"]));
}
