<?php

class Oferta{

	/* A T R I B U T O S */

    private $codigo_oferta;
    private $fk_financiera;
    private $fk_prestamo;
    private $state;

	/* G E T T E R S  &&  S E T T E R S */
	public function setCodigoOferta($a){
		$this->codigo_oferta = $a;
	}
	public function getCodigoOferta(){
		return $this->codigo_oferta;
	}
	public function setFkFinanciera($a){
		$this->fk_financiera = $a;
	}
	public function getFkFinanciera(){
		return $this->fk_financiera;
	}
	public function setFkPrestamo($a){
		$this->fk_prestamo = $a;
	}
	public function getFkPrestamo(){
		return $this->fk_prestamo;
	}
	public function setState($a){
		$this->state = $a;
	}
	public function getState(){
		return $this->state;
	}

    /* M E T O D O S   D E   L A   C L A S E */

	//nombre de la tabla y columnas de la tabla.
	public static $tabla = "Oferta";
	private static $fila = ['FK_FINANCIERA','FK_PRESTAMO','STATE'];

    //CREAR
    public function crear_oferta($array){
    		$query = "INSERT INTO " . static::$tabla . " (FK_FINANCIERA, FK_PRESTAMO, STATE)
    				VALUES (?, ?, ?)";
    		$stmt = DBcnx::getStatement($query);
    		return $stmt->execute([$array["FK_FINANCIERA"],$array["FK_PRESTAMO"],$array["STATE"]]);
    }

    //GET PRESTAMOS YA EVALUADOS
     public function get_prestamos_ya_evaluados($id){
                $query = "SELECT * FROM " . static::$tabla . " WHERE FK_FINANCIERA=?";
                $stmt = DBcnx::getStatement($query);
                $stmt->execute([$id]);
                $salida=[];
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                		$oferta = new Oferta;
                        $oferta->codigo_oferta = $fila['ID'];
                        $oferta->fk_prestamo = $fila['FK_PRESTAMO'];
                        $oferta->cargarDatos($fila);
                        $salida[] = $oferta;
                }
                return $salida;
    }

    public function cargarDatos($fila){
		foreach($fila as $prop => $valor) {
			if(in_array($prop, static::$fila)) {
				switch($prop){
					case "FK_PRESTAMO":
						$this->setFkPrestamo($valor);
					break;
				}
			}
		}
	}
}