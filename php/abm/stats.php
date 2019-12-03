<?php
//header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/User.php');
require_once('../clases/DBcnx.php');
require_once('../clases/Prestamo.php');
require_once('../clases/Administrador.php');

if($_SESSION["s_nivel"]=="Administrador"){
    $administrador = new Administrador();

    $array=[
        "users"=> $administrador->allUsers(),
        "prestamos"=>$administrador->allPrestamos()
    ];

    echo json_encode($array);
}

