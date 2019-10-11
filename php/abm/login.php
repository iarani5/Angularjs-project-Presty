<?php
/****** Clases *****/
require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/User.php');

/****** Logeo al usuario ******/
if(isset($_POST)){
    $usuario = new User();

    $fin2=json_decode($usuario->login($_POST["EMAIL"], $_POST["PASSWORD"]),true);
    if(count($fin2)){
        foreach ($fin2 as $k => $v) {
            /***** Guardado de datos en SESSION ****/
            switch($k){
                case "ID":
                    $_SESSION['s_id'] = $v;
                    break;
                case "USER_TYPE":
                    $_SESSION['s_nivel'] = $v;
                    break;
            }
        }
        echo json_encode($fin2);
    }
}

?>