<?php

class Financiera extends User{

	/* A T R I B U T O S */
	private $codigo_financiera;
	private $fk_user;
	private $company;
	private $borrado;

	//nombre de la tabla y columnas de la tabla.
	public static $tabla = "financiera";
	private static $fila = ['FK_USER', 'COMPANY','BORRADO'];

	/* G E T T E R S  &&  S E T T E R S */
	public function setCodigoFinanciera($a){
		$this->codigo_financiera = $a;
	}
	public function getCodigoFinanciera(){
		return $this->codigo_financiera;
	}
	public function setFkUser($a){
		$this->fk_user = $a;
	}
	public function getFkUser(){
		return $this->company;
	}
	public function setCompany($a){
		$this->company = $a;
	}
	public function getCompany(){
		return $this->company;
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
    	public function crear_financiera($array){  //REGISTRO DE USUARIO
    	   	$bdd = new DBcnx();
			return $bdd->crear_financiera($array);
		
    	}

    //BRINDAR PRESTAMO
    public function brindar_prestamo(){
        $prestamo = new Prestamo();
        return $prestamo->get_prestamos_otorgados();
    }

    //ACPETAR CLIENTE
    public function aceptar_cliente($array){
        $oferta = new Oferta();
        $financiera=new Financiera();
        $array["FK_FINANCIERA"]=$financiera->getByPk($array["FK_FINANCIERA"])["ID"];
        $array["STATE"]="Ofertar";
        return $oferta->crear_oferta($array);
    }

    //RECHAZAR CLIENTE
    public function rechazar_cliente($array){
        $oferta = new Oferta();
              $financiera=new Financiera();
              $array["FK_FINANCIERA"]=$financiera->getByPk($array["FK_FINANCIERA"])["ID"];
              $array["STATE"]="Denegar";
              return $oferta->crear_oferta($array);
    }

    //SOLICITUD DE PRESTAMO
    public function solicitud_de_prestamo($id){
        $prestamo = new Prestamo();
        $oferta = new Oferta();
        $financiera = new Financiera();
        $ya_evaluadas = $oferta->get_prestamos_ya_evaluados($financiera->getByPk($id)["ID"]);
        $rta = $prestamo->get_prestamos_ya_evaluados();
        $arrayFinal=[];
                 foreach($rta as $unPrestamo){
                    $ban=0;
                        for($i=0;$i<count($ya_evaluadas);$i++){
                            if($ya_evaluadas[$i]->getFkPrestamo()===$unPrestamo->getCodigoPrestamo()) $ban=1;
                         }

                         if(!$ban){
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
                 }
                 echo json_encode($arrayFinal);
    }

	public function getById($id){
		$bdd = new DBcnx();
		return $bdd->getByIdFinanciera($id);
	}

	public function getByPk($id){
		$bdd = new DBcnx();
		return $bdd->getByPkFinanciera($id);
	}

    //RECIBE LA FILA DE LA BDD Y CARGA LOS DATOS EN LA CLASE USUARIO PHP (USA LOS SETTERS DE LA CLASE)
	public function cargarDatos($fila){
		foreach($fila as $prop => $valor) {
			if(in_array($prop, static::$fila)) {
				switch($prop){
					case "fk_user":
						$this->setFkUser($valor);
					break;
					case "company":
						$this->setCompany($valor);
					break;
					case "borrado":
						$this->setBorrado($valor);
					break;
				}
			}
		}
	}

    //LISTAR TODO EL LISTADO DE LA TABLA USUARIO
	public static function all(){
		$bdd = new DBcnx();
		return $bdd->allFinanciera();
	}
 }

