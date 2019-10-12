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
	private static $fila = ['NAME', 'LINK','IMG','BORRADO'];

	/* G E T T E R S  &&  S E T T E R S */
    	public function setCodigoPublicidad($a){
    		$this->codigo_publicidad = $a;
    	}
    	public function getCodigoPublicidad(){
    		return $this->codigo_publicidad;
    	}
    	public function setName($a){
    		$this->name = $a;
    	}
    	public function getName(){
    		return $this->name;
    	}
    	public function setLink($a){
    		$this->link = $a;
    	}
    	public function getLink(){
    		return $this->link;
    	}
    	public function setImg($a){
    		$this->img = $a;
    	}
    	public function getImg(){
    		return $this->img;
    	}
        public function setBorrado($a){
            $this->borrado = $a;
        }
        public function getBorrado(){
            return $this->borrado;
        }

    /* M E T O D O S   D E   L A   C L A S E */
    public function __construct(){}

	//CREAR
	public function crear_publicidad($array){  //REGISTRO DE USUARIO
		$query = "INSERT INTO " . static::$tabla . "  (NAME, LINK, IMG)
				VALUES (?, ?, ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["NAME"],$array["LINK"],$array["IMG"]]);
	}

	//EDITAR
	public function editar_publicidad($variable,$array){ //EDICION DE DATOS DE USUARIO
		$query = "UPDATE " . static::$tabla . "  SET $variable=? WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["VALOR"],$array["ID"]]);
	}

	//ELIMINAR
	public function eliminar_publicidad($array){
		$query = "UPDATE " . static::$tabla . "   SET BORRADO='Si' WHERE ID=? ";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["ID"]]);
	}