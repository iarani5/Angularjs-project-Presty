<?php

   /*  CREATE TABLE Publicidad(
   	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
   	NAME VARCHAR(45) NOT NULL,
   	LINK VARCHAR(255) NOT NULL,
   	IMG VARCHAR(255) NOT NULL,
   	BORRADO ENUM('Si','No') NOT NULL DEFAULT 'No'
   );*/


    class Publicidad{

        /* A T R I B U T O S */

        private $codigo_publicidad;
        private $name;
        private $link;
        private $img;
        private $borrado;

        public static $tabla = "Publicidad";
        private static $fila = ['NAME', 'LINK', 'IMG', 'BORRADO'];

        /* G E T T E R S  &&  S E T T E R S */
        public function setCodigoPublicidad($a)
        {
            $this->codigo_publicidad = $a;
        }

        public function getCodigoPublicidad()
        {
            return $this->codigo_publicidad;
        }

        public function setName($a)
        {
            $this->name = $a;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setLink($a)
        {
            $this->link = $a;
        }

        public function getLink()
        {
            return $this->link;
        }

        public function setImg($a)
        {
            $this->img = $a;
        }

        public function getImg()
        {
            return $this->img;
        }

        public function setBorrado($a)
        {
            $this->borrado = $a;
        }

        public function getBorrado()
        {
            return $this->borrado;
        }

        /* M E T O D O S   D E   L A   C L A S E */
        public function __construct()
        {
        }

        //CREAR
        public function crear_publicidad($array)
        {
            $bdd = new DBcnx();
            return $bdd->crear_publicidad($array);
        }

        //ELIMINAR
        public function eliminar_publicidad($array)
        {
            $bdd = new DBcnx();
            return $bdd->eliminar_publicidad($array);
        }

        //CARGAR DATOS
        public function cargarDatos($fila){
            foreach($fila as $prop => $valor) {
                if(in_array($prop, static::$fila)) {
                    switch($prop){
                        case "IMG":
                            $this->setImg($valor);
                            break;
                        case "LINK":
                            $this->setLink($valor);
                            break;
                        case "NAME":
                            $this->setName($valor);
                            break;
                        case "BORRADO":
                            $this->setBorrado($valor);
                            break;
                    }
                }
            }
        }
    }

