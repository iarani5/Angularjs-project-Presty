<?php
//header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/Administrador.php');
require_once('../clases/Publicidad.php');

if(isset($_POST)&&$_SESSION["s_nivel"]==="Administrador") {
    $publicidad = new Publicidad();
    $administrador = new Administrador();
    if(isset($_POST["estado"])&&isset($_POST["id"])&&isset($_POST["borrado"])){
        echo $administrador->mostrar_publicidad($_POST["estado"],$_POST["id"]);
    }
    else if(isset($_POST)){

        echo $administrador->editar_publicidad($_POST);
    }
}
