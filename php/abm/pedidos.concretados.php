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

if(isset($_SESSION["s_id"])){
    $financiera = new Financiera;
    var_dump($financiera->brindar_prestamo($financiera->getById($_SESSION["s_id"])["ID"]));
    echo json_encode( $financiera->brindar_prestamo($financiera->getById($_SESSION["s_id"])["ID"]));
}
