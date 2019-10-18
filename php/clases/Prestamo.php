<?php

class Prestamo{

	/* A T R I B U T O S */

    private $codigo_prestamo;
    private $fk_client;
    private $fk_financiera;
    private $fk_autorizador;
    private $amount;
    private $state;
    private $created_date;
    private $borrado;

	/* G E T T E R S  &&  S E T T E R S */
	public function setCodigoPrestamo($a){
		$this->codigo_prestamo = $a;
	}
	public function getCodigoPrestamo(){
		return $this->codigo_prestamo;
	}
	public function setFkClient($a){
		$this->fk_client = $a;
	}
	public function getFkClient(){
		return $this->fk_client;
	}
	public function setFkFinanciera($a){
		$this->fk_financiera = $a;
	}
	public function getFkFinanciera(){
		return $this->fk_financiera;
	}
	public function setFkAutorizador($a){
		$this->fk_autorizador = $a;
	}
	public function getFkAutorizador(){
		return $this->fk_autorizador;
	}
	public function setAmount($a){
		$this->amount = $a;
	}
	public function getAmount(){
		return $this->amount;
	}
	public function setState($a){
		$this->state = $a;
	}
	public function getState(){
		return $this->state;
	}
	public function setCreatedDate($a){
		$this->created_date = $a;
	}
	public function getCreatedDate(){
		return $this->created_date;
	}
	public function setBorrado($a){
		$this->borrado = $a;
	}
	public function getBorrado(){
		return $this->borrado;
	}

    /* M E T O D O S   D E   L A   C L A S E */

	//nombre de la tabla y columnas de la tabla.
	public static $tabla = "Prestamo";
	private static $fila = ['FK_CLIENT', 'FK_FINANCIERA','FK_AUTORIZADOR','AMOUNT','STATE','CREATED_DATE','BORRADO'];

    public function __construct(){}

    //CREAR
    public function crear_prestamo($array){
         $bdd = new DBcnx();
		return $bdd->crear_prestamo($array);
    }


    //SOLICITUD DE PRESTAMO
	public function prestamo_concretado($array){
		$bdd = new DBcnx();
		return $bdd->prestamo_concretado($array);
	}

    //ESTADO DE PRESTAMO
	public function estado_prestamo($id){
	    $bdd = new DBcnx();
		return $bdd->estado_prestamo($id);
	}

    //CAMBIAR ESTADO
	public function cambiar_estado($estado,$id){
		$bdd = new DBcnx();
		return $bdd->estado_prestamo($estado,$id);
	}

    //GET AUTORIZADOR
	public function get_prestamos_autorizador($id){
        $bdd = new DBcnx();
		return $bdd->get_prestamos_autorizador($id);
	}

	//GET PRESTAMOS PRE OTORGADOS
    	public function get_prestamos_ya_evaluados(){
            $bdd = new DBcnx();
		return $bdd->get_prestamos_ya_evaluadosPrestamo();
    	}

    public function cargarDatos($fila){
		foreach($fila as $prop => $valor) {
			if(in_array($prop, static::$fila)) {
				switch($prop){
					case "FK_CLIENT":
						$this->setFkClient($valor);
					break;
					case "FK_FINANCIERA":
						$this->setFkFinanciera($valor);
					break;
					case "FK_AUTORIZADOR":
						$this->setFkAutorizador($valor);
					break;
					case "AMOUNT":
						$this->setAmount($valor);
					break;
					case "STATE":
						$this->setState($valor);
					break;
					case "CREATED_DATE":
						$this->setCreatedDate($valor);
					break;
					case "BORRADO":
						$this->setBorrado($valor);
					break;
				}
			}
		}
	}

}