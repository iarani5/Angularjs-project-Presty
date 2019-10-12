<?php
	//header("Access-Control-Allow-Origin: *");

	/****** Clases *****/

	require_once('../config.php');
	require_once('../funciones.php');
	require_once('../clases/DBcnx.php');
	require_once('../clases/Prestamo.php');
	require_once('../clases/User.php');
	require_once('../clases/Client.php');

	if(isset($_SESSION["s_id"])){
        $prestamo = new Prestamo();
         $rta= $prestamo->get_prestamos_autorizador($_SESSION["s_id"]);
         $arrayFinal=[];
         $array=[];

         foreach($rta as $unPrestamo){
                 $client = new Client();
                 $rta2= $client->getByPk($unPrestamo->getFkClient());
         		$array=[
         				"ID"=>$unPrestamo->getCodigoPrestamo(),
         				"FK_CLIENT"=>$unPrestamo->getFkClient(),
         				"FK_AUTORIZADOR"=>$unPrestamo->getFkAutorizador(),
         				"AMOUNT"=>$unPrestamo->getAmount(),
         				"CREATED_DATE"=>$unPrestamo->getCreatedDate(),
         				"NAME"=>$rta2["NAME"],
                        "LAST_NAME"=>$rta2["LAST_NAME"],
                        "DNI"=>$rta2["DNI"],
                        "BIRTH_DAY"=>$rta2["BIRTH_DAY"],
                        "PHONE"=>$rta2["PHONE"]
         		];
         		$arrayFinal[]=$array;
         }
         echo json_encode($arrayFinal);
}