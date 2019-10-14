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
    	   	if(parent::crear_usuario($array)){
    	   	    $array["FK_USER"] = parent::ultimo_usuario()->getCodigoUsuario();
                $query = "INSERT INTO " . static::$tabla . " (FK_USER, COMPANY)
                				VALUES (?,?)";
                $stmt = DBcnx::getStatement($query);
                return $stmt->execute([$array['FK_USER'],$array['COMPANY']]);
    	   	}
    	   	else{
    	   	    //error
    	   	}
    	}

    //BRINDAR PRESTAMO

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
        $financiera=new Financiera();
        $ya_evaluadas = $oferta->get_prestamos_ya_evaluados($financiera->getByPk($id)["ID"]);
        $rta = $prestamo->get_prestamos_pre_otorgados();

        var_dump($ya_evaluadas);
       /* $arrayFinal=[];
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
                 echo json_encode($arrayFinal);*/
    }

    //ACEPTAR FINANCIERA

    //*
    //*
    //*
    //*
    //*
    //*
    //*
    //*
    //*
    //*

    //MAS METODOS DE LA CLASE, AGREGARLOS AL DIAGRAMA DE CLASES

	public function getByPk($id){
		$query = "SELECT * FROM " . static::$tabla . "
					WHERE FK_USER = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return /* $this->cargarDatos( */$stmt->fetch(PDO::FETCH_ASSOC)/* ) */;
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
		$salida = [];
		$query = "SELECT * FROM " . static::$tabla;
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$financiera = new Financiera;
				$financiera->codigo_financiera = $fila['ID'];
				$financiera->fk_user = $fila['FK_USER'];
				$financiera->company = $fila['COMPANY'];
				$financiera->borrado = $fila['BORRADO'];
				$financiera->cargarDatos($fila);
				$salida[] = $financiera;
			}
		}
		return $salida;
	}
 }
