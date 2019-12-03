<?php

class Autorizador{

/* M E T O D O S   D E   L A   C L A S E */

    public function ver_pedido_prestamo($id){
        $prestamo = new Prestamo();
        $client = new Client();

        //asigna de forma random un autorizador a un prestamo
        $rta = $prestamo->get_prestamos_autorizador($id);
         $arrayFinal=[];

         foreach($rta as $unPrestamo){
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

    public function aprobar_prestamo($id){
        $prestamo = new Prestamo;
        $prestamo->cambiar_estado("Pre-Otorgado",$id);
    }

    public function reprobar_prestamo($id){
        $prestamo = new Prestamo;
        $prestamo->cambiar_estado("Denegado",$id);
    }

    public function listar_financieras($id){
        $oferta = new Oferta;
        $financiera = new Financiera;
        $arrayFinal=[];
        $rta=$oferta->get_prestamo_con_ofertas($id);
         foreach($rta as $unaFinanciera){
              $rta2= $financiera->getByPk($unaFinanciera->getFkFinanciera());
              $array=[
                   "ID"=>$rta2["ID"],
                    "COMPANY"=>$rta2["COMPANY"]
               ];
               $arrayFinal[]=$array;
          }
          echo json_encode($arrayFinal);
    }

    public function procesar_data($array){
        $veraz = new Veraz;
        $autorizador = new Autorizador;
        $array["ANSWER"] =  $veraz->procesar_data();
        $veraz->crear_registro($array);
        $autorizador -> respuesta($array["ANSWER"],$array["ID"]);
        echo $array["ANSWER"];
    }

    public function respuesta($estado,$id){
        $autorizador = new Autorizador();
        if($estado==="Aprobado"){
            $autorizador->aprobar_prestamo($id);
        }
        if($estado==="Reprobado"){
            $autorizador->reprobar_prestamo($id);
        }
    }

     //LISTAR
        public static function all(){
            $bdd = new DBcnx();
		    return $bdd->allAutorizador();
        }

        public static function asignar_autorizador(){
            $autorizador = new Autorizador();
            $listado = $autorizador->all();
            $posicion=array_rand($listado);
            return $listado[$posicion]["ID"];
        }

}

