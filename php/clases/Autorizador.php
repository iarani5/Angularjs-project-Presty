<?php

class Autorizador{

/* M E T O D O S   D E   L A   C L A S E */

    public function ver_pedido_prestamo(Prestamo $prestamo){
        //asigna de forma random un autorizador a un prestamo
    }

    public function aprobar_prestamo(Veraz $veraz, $prestamo){
    //paasarlo por el veraz
    }

    public function reprovar_prestamo(Prestamo $prestamo){
    //paasarlo por el veraz

    }

    public function listar_financieras(Prestamo $prestamo){

    }

    public function procesar_data(Prestamo $prestamo){

    }

    public function solicitar_prestamo(Prestamo $prestamo){

    }

    public function respuesta(Prestamo $prestamo){

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

