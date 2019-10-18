<?php

class Oferta{

	/* A T R I B U T O S */

    private $codigo_oferta;
    private $fk_financiera;
    private $fk_prestamo;
    private $state;
    private $state_client;

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
	public function setStateClient($a){
		$this->state_client = $a;
	}
	public function getStateClient(){
		return $this->state_client;
	}

    /* M E T O D O S   D E   L A   C L A S E */

	//nombre de la tabla y columnas de la tabla.
	public static $tabla = "Oferta";
	private static $fila = ['FK_FINANCIERA','FK_PRESTAMO','STATE','STATE_CLIENT'];

    //CREAR
    public function crear_oferta($array){
    	$bdd = new DBcnx();
		return $bdd->crear_oferta($array);
	}

    //RECHAZAR OFERTA
    public function rechazar_oferta($array){
        $bdd = new DBcnx();
		return $bdd->rechazar_oferta($array);
    }

    //GET PRESTAMOS YA EVALUADOS
     public function get_prestamos_ya_evaluados($id){
         $bdd = new DBcnx();
		return $bdd->get_prestamos_ya_evaluadosOferta($id);
    }

    //GET PRESTAMOS YA EVALUADOS
     public function get_prestamo_con_ofertas($id){
         $bdd = new DBcnx();
		return $bdd->get_prestamo_con_ofertas($id);
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