<?php
//header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/User.php');
require_once('../clases/Financiera.php');
require_once('../clases/Client.php');

if(isset($_SESSION["s_id"])) {
    $user = new User();
    if($user->eliminar_usuario($_SESSION["s_id"])){
        session_destroy();
        echo "1";
    }

}
