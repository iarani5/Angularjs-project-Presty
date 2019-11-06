<?php
/****** Clases *****/
require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');

if(isset($_SESSION['s_id'])&&isset($_SESSION['s_nivel'])){
  echo $_SESSION['s_id'];
}
else{
    echo null;
}
return 0;

