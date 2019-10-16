<?php

class Client extends User{

	/* A T R I B U T O S */
	private $codigo_client;
	private $fk_user;
	private $name;
	private $last_name;
	private $dni;
	private $birth_day;
	private $phone;
	private $borrado;

    //nombre de la tabla y columnas de la tabla.
    public static $tabla = "Client";
    private static $fila = ['FK_USER', 'NAME','LAST_NAME', 'DNI','BIRTH_DAY','BORRADO'];

    /* G E T T E R S  &&  S E T T E R S */

    public function getCodigoClient()
    {
        return $this->codigo_client;
    }
    public function setCodigoClient($codigo_client)
    {
        $this->codigo_client = $codigo_client;
    }
    public function getFkUser()
    {
        return $this->fk_user;
    }
    public function setFkUser($fk_user)
    {
        $this->fk_user = $fk_user;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    public function getDni()
    {
        return $this->dni;
    }
    public function setDni($dni)
    {
        $this->dni = $dni;
    }
    public function getBirthDay()
    {
        return $this->birth_day;
    }
    public function setBirthDay($birth_day)
    {
        $this->birth_day = $birth_day;
    }
    public function getBorrado()
    {
        return $this->borrado;
    }
    public function setBorrado($borrado)
    {
        $this->borrado = $borrado;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

	/* M E T O D O S   D E   L A   C L A S E */
    public function __construct(){}

    //CREAR
    	public function crear_cliente($array){
    	   	if(parent::crear_usuario($array)){
    	   	    $array["FK_USER"] = parent::ultimo_usuario()->getCodigoUsuario();
                $query = "INSERT INTO " . static::$tabla . " (FK_USER, NAME, LAST_NAME, DNI, PHONE, BIRTH_DAY)
                				VALUES (?,?,?,?,?,?)";
                $stmt = DBcnx::getStatement($query);
                return $stmt->execute([$array['FK_USER'],$array['NAME'],$array['LAST_NAME'],$array['DNI'],$array['PHONE'],$array['BIRTH_DAY']]);
    	   	}
    	}

    //CREAR
    	public function editar_cliente($array){
    	   	if(parent::crear_usuario($array)){
    	   	    $array["FK_USER"] = parent::ultimo_usuario()->getCodigoUsuario();
                $query = "INSERT INTO " . static::$tabla . " (FK_USER, NAME, LAST_NAME, DNI, PHONE, BIRTH_DAY)
                				VALUES (?,?,?,?,?,?)";
                $stmt = DBcnx::getStatement($query);
                return $stmt->execute([$array['FK_USER'],$array['NAME'],$array['LAST_NAME'],$array['DNI'],$array['PHONE'],$array['BIRTH_DAY']]);
    	   	}
    	}

    //ACEPTAR FINANCIERA
    public function aceptar_financiera($array){
        $prestamo = new Prestamo();
        return  $prestamo->prestamo_concretado($array);
    }

    //RECHAZAR FINANCIERA
    public function rechazar_financiera($array){
        $oferta = new Oferta();
        return  $oferta->rechazar_oferta($array);
    }

	public function getByPk($id){
		$query = "SELECT * FROM " . static::$tabla . "
					WHERE ID = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function getById($id){
		$query = "SELECT * FROM " . static::$tabla . "
					WHERE FK_USER = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    //RECIBE LA FILA DE LA BDD Y CARGA LOS DATOS EN LA CLASE USUARIO PHP (USA LOS SETTERS DE LA CLASE)
	public function cargarDatos($fila){
		foreach($fila as $prop => $valor) {
			if(in_array($prop, static::$fila)) {
				switch($prop){
					case "fk_user":
						$this->setFkUser($valor);
					break;
					case "name":
						$this->setName($valor);
					break;
					case "last_name":
						$this->setLastName($valor);
					break;
					case "dni":
						$this->setDni($valor);
					break;
					case "birth_day":
						$this->setBirthDay($valor);
					break;
					case "phone":
						$this->setPhone($valor);
					break;
					case "borrado":
						$this->setBorrado($valor);
					break;
				}
			}
		}
	}

    //LISTAR EL LISTADO DE LA TABLA CLIENTES
	public static function all(){
		$salida = [];
		$query = "SELECT * FROM " . static::$tabla;
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$client = new Client;
				$client->codigo_client = $fila['ID'];
				$client->fk_user = $fila['FK_USER'];
				$client->name = $fila['NAME'];
				$client->last_name = $fila['LAST_NAME'];
				$client->dni = $fila['DNI'];
				$client->birth_day = $fila['BIRTH_DAY'];
				$client->phone = $fila['PHONE'];
				$client->borrado = $fila['BORRADO'];
				$client->cargarDatos($fila);
				$salida[] = $client;
			}
		}
		return $salida;
	}
}
