<?php

class Autorizador{

/* M E T O D O S   D E   L A   C L A S E */

    public function ver_pedido_prestamo($id){
        //asigna de forma random un autorizador a un prestamo
        $prestamo = new Prestamo();
         $rta= $prestamo->get_prestamos_autorizador($id);
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

    public function aprobar_prestamo($id){
        $prestamo = new Prestamo;
        $prestamo->cambiar_estado("Pre-Otorgado",$id);
    }

    public function reprobar_prestamo($id){
        $prestamo = new Prestamo;
        $prestamo->cambiar_estado("Denegado",$id);
    }

    public function listar_financieras(){

    }

    public function procesar_data($array){
        $veraz = new Veraz;
        $autorizador = new Autorizador;
        $estado =  $veraz->procesar_data();
        $autorizador -> respuesta($estado,$array["ID"]);
        echo $estado;
    }

    /*public function solicitar_prestamo(Prestamo $prestamo){

    }*/

    public function respuesta($estado,$id){
        $autorizador = new Autorizador();
        if($estado==="Aprobado"){
            $autorizador->aprobar_prestamo($id);
        }
        if($estado==="Reprobado"){
            $autorizador->reprobar_prestamo($id);
        }
    }


    //*
    //*
    //*
    //*
    //*
    //*
    //*
    //*
    // AGREGAR EN DIAGRAMA UML

     //LISTAR TODO EL LISTADO DE AUTORIZADORES
        public static function all(){
            $salida = [];
            $query = "SELECT * FROM  `User` WHERE USER_TYPE='Autorizador'" ;
            $stmt = DBcnx::getStatement($query);
            if($stmt->execute()) {
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $usuario = new User;
                    $salida[] = $fila;
                }
            }
            return $salida;
        }

        public static function asignar_autorizador(){
            $autorizador = new Autorizador();
            $listado = $autorizador->all();
            $posicion=array_rand($listado);
            return $listado[$posicion]["ID"];
        }

}

