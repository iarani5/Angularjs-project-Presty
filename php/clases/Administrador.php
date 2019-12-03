<?php

/*  CREATE TABLE Publicidad(
    ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(45) NOT NULL,
    LINK VARCHAR(255) NOT NULL,
    IMG VARCHAR(255) NOT NULL,
    BORRADO ENUM('Si','No') NOT NULL DEFAULT 'No'
);*/


class Administrador{

    //CARGAR ESTADISTICAS
    public function cargar_estadisticas($array){

    }

    public function traer_publicidad(){
        $bdd = new DBcnx();
        return $bdd->traer_publicidad();
    }

    public function traer_publicidad_para_home(){
        $bdd = new DBcnx();
        return $bdd->traer_publicidad_para_home();
    }

    //CREAR PUBLICIDAD
    public function crear_publicidad($array){
        $publicidad = new Publicidad();
        return $publicidad->crear_publicidad($array);
    }

    //MOSTRAR PUBLICIDAD
    public function mostrar_publicidad($estado,$id){
        $DBcnx = new DBcnx();
        return $DBcnx->mostrar_publicidad($estado,$id);
    }

    //EDITAR PUBLICIDAD
    public function editar_publicidad($array){
        $DBcnx = new DBcnx();
        return $DBcnx->editar_publicidad($array);
    }

    //ELIMINAR
    public function eliminar_publicidad($array){
        $publicidad = new Publicidad();
        return $publicidad->eliminar_publicidad($array);
    }

    //LISTAR EL LISTADO DE LA TABLA CLIENTES
    public static function allUsers(){
        $bdd = new DBcnx();
        //return $bdd->allUser();
        $arrayFinal=[];
        $rta=$bdd->allUser();
        foreach($rta as $unUsuario){
            $array=[
                "ID"=>$unUsuario->getCodigoUsuario(),
                "USER_TYPE"=>$unUsuario->getUserType(),
                "BORRADO"=>$unUsuario->getBorrado()
            ];
            $arrayFinal[]=$array;
        }
        return $arrayFinal;

    }

    //LISTAR EL LISTADO DE LA TABLA PRESTAMOS
    public static function allPrestamos(){
        $bdd = new DBcnx();
        $arrayFinal=[];
        $rta=$bdd->allPrestamos();
        foreach($rta as $unPrestamo){
            $array=[
                "ID"=>$unPrestamo->getCodigoPrestamo(),
                "STATE"=>$unPrestamo->getState()
            ];
            $arrayFinal[]=$array;
        }
        return $arrayFinal;

    }

}

