<?php
 header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/Publicidad.php');
require_once('../clases/Administrador.php');

$administrador = new Administrador;
echo json_encode($administrador->traer_publicidad_para_home());
