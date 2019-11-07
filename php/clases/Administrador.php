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

    //CREAR PUBLICIDAD
    public function crear_publicidad($array){
        $publicidad = new Publicidad();
        return $publicidad->crear_publicidad($array);
    }

    //ELIMINAR
    public function eliminar_publicidad($array){
        $publicidad = new Publicidad();
        return $publicidad->eliminar_publicidad($array);
    }
}

