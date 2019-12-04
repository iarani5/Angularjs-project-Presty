<?php
header("Access-Control-Allow-Origin: *");

/****** Clases *****/

require_once('../config.php');
require_once('../funciones.php');
require_once('../clases/DBcnx.php');
require_once('../clases/Administrador.php');
require_once('../clases/Publicidad.php');

if(isset($_POST)&&$_SESSION["s_nivel"]==="Administrador"){
    $publicidad = new Publicidad();
    $administrador = new Administrador();

    if(!empty($_FILES)&&$_FILES['IMG']['name']){ //hay foto
        if($_FILES['IMG']['type']!='image/png'&&$_FILES['IMG']['type']!='image/jpeg'&&$_FILES['IMG']['type']!='image/jpg'){
            //error formato no permitido
            echo "formato";
            return 0;
        }
        //creo carpeta para foto
        $foto = $_FILES['IMG']['name'];

        //nombre de archivo y ruta
        $foto = $_FILES['IMG']['name'];
        $destino = 'C:/xampp/htdocs/Presty/images/Publicidad/'.$foto; //almacenamiento local
        //CAMBIAR UNA VEZ SUBIDO A LA NUBE

        /**** RESIZE ****/

        $ruta_temporal = $_FILES['IMG']['tmp_name'];
        if($_FILES['IMG']['type']=='image/png'){
            $original=imagecreatefrompng( $ruta_temporal );
        }
        else if($_FILES['IMG']['type']=='image/jpeg'||$_FILES['IMG']['type']=='image/jpg'){
            $original=imagecreatefromjpeg( $ruta_temporal );
        }

        $ancho_o = imagesx( $original );
        $alto_o = imagesy( $original );
        $alto_n = 340; // de alto
        $ancho_n = round($alto_n  * $ancho_o / $alto_o) ;
        $copia = imagecreatetruecolor( $ancho_n, $alto_n );
        imagecopyresampled( $copia, $original, 0,0, 0,0, $ancho_n, $alto_n, $ancho_o, $alto_o );

        imagejpeg( $copia, $destino, 100 );

        imagedestroy($copia);
        imagedestroy($original);

        /***************/
        $_POST["IMG"]=$destino;

        echo $administrador->crear_publicidad($_POST);
    }

}
else{
    echo 0;
}
