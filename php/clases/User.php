<?php

class User{

	/* A T R I B U T O S */
	private $codigo_usuario;
	private $email;
	private $password;
	private $user_type;
	private $borrado;
	
	//nombre de la tabla y columnas de la tabla.
	public static $tabla = "User";
	private static $fila = ['EMAIL','PASSWORD','USER_TYPE','BORRADO'];

	/* G E T T E R S  &&  S E T T E R S */
	public function setCodigoUsuario($a){
		$this->codigo_usuario = $a;
	}
	public function getCodigoUsuario(){
		return $this->codigo_usuario;
	}
	public function setEmail($a){
		$this->email = $a;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setPassword($a){
		$this->password = $a;
	}
	public function getPassword(){
		return $this->password;
	}
	public function setUserType($a){
		$this->user_type = $a;
	}
	public function getUserType(){
		return $this->user_type;
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
	public function crear_usuario($array){  //REGISTRO DE USUARIO
		$query = "INSERT INTO `User` (EMAIL, PASSWORD, USER_TYPE)
				VALUES (?, sha2(?, 224), ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["EMAIL"],$array["PASSWORD"],$array["USER_TYPE"]]);
	}

	//EDITAR
	public function editar_usuario($variable,$array){ //EDICION DE DATOS DE USUARIO
		$query = "UPDATE `User` SET $variable=? WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["VALOR"],$array["ID"]]);
	}

	//EDITAR CLAVE
	public function editar_clave($contrasenia,$id){ //EDICION DE CLAVE
		$query = "UPDATE `User` SET PASSWORD=sha2(?, 224) WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$contrasenia,$id]);
	}

	//ELIMINAR
	public function eliminar_usuario($array){
		$query = "UPDATE `User`  SET BORRADO='Si' WHERE ID=? ";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["ID"]]);
	}

    //LOGIN
    public function login($mail, $contrasenia){
    		$query = "SELECT * FROM `User` WHERE EMAIL=? AND PASSWORD=sha2(?, 224)";
    		$stmt = DBcnx::getStatement($query);
    		$array=[];
    		if($stmt->execute([$mail,$contrasenia])){
    			while($f = $stmt->fetch(PDO::FETCH_ASSOC)) {
    				$array=$f;
    			}
    		}
    		//$json=json_encode($array);
    		return $array;
    }

    //RECUPERAR CLAVE
    public function recuperar_clave($mail){
    		$query = "SELECT * FROM `User` WHERE EMAIL=? LIMIT 1";
    		$stmt = DBcnx::getStatement($query);
    		$array=[];
    		if($stmt->execute([$mail])){
    			while($f = $stmt->fetch(PDO::FETCH_ASSOC)) {
    				$array=$f;
    			}
    		}
    		$json=json_encode($array);
    		return $json;
    	}

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

    public function ultimo_usuario(){
		$salida = [];
		$query = "SELECT * FROM `User` ORDER BY ID DESC LIMIT 1";
		$stmt = DBcnx::getStatement($query);
       if($stmt->execute()) {
       		while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
       				$user = new User;
       				$user->codigo_usuario = $fila['ID'];
       				$user->cargarDatos($fila);
       				$salida[] = $user;
       			}
       		}
       		return $salida[0];
	}

	public function getByPk($id){
		$query = "SELECT * FROM `User`
					WHERE ID = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    //VER SI EL MAIL YA EXISTE
	public function chequear_mail($mail){
		$query = "SELECT * FROM `User` WHERE EMAIL=? LIMIT 1";
		$stmt = DBcnx::getStatement($query);
		$array=[];
		if($stmt->execute([$mail])){
			while($f = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array=$f;
			}
		}
		$json=json_encode($array);
		return $json;
	}

    //RECIBE LA FILA DE LA BDD Y CARGA LOS DATOS EN LA CLASE USUARIO PHP (USA LOS SETTERS DE LA CLASE)
	public function cargarDatos($fila){
		foreach($fila as $prop => $valor) {
			if(in_array($prop, static::$fila)) {
				switch($prop){
					case "email":
						$this->setEmail($valor);
					break;
					case "password":
						$this->setClave($valor);
					break;
					case "user_type":
						$this->setTipoUsuario($valor);
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
		$query = "SELECT * FROM `User`";
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$usuario = new User;
				$usuario->codigo_usuario = $fila['ID'];
				$usuario->email = $fila['EMAIL'];
				$usuario->password = $fila['PASSWORD'];
				$usuario->user_type = $fila['USER_TYPE'];
				$usuario->borrado = $fila['BORRADO'];
				$usuario->cargarDatos($fila);
				$salida[] = $usuario;
			}
		}
		return $salida;
	}
}
