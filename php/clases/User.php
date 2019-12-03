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
		$bdd = new DBcnx();
		return $bdd->crear_usuario($array);
	}

	//EDITAR
	public function editar_usuario($variable,$array){ //EDICION DE DATOS DE USUARIO
        $bdd = new DBcnx();
        return $bdd->editar_usuario($variable,$array);
	}

	//EDITAR CLAVE
	public function editar_clave($array){ //EDICION DE CLAVE
        $bdd = new DBcnx();
        return $bdd->editar_clave($array);
	}

	//ELIMINAR
	public function eliminar_usuario($array){
        $bdd = new DBcnx();
        return $bdd->eliminar_usuario($array);
	}

    //LOGIN
    public function login($array){
        $bdd = new DBcnx();
        return $bdd->login($array);
    }

    //RECUPERAR CLAVE
    public function recuperar_clave($mail){
        $bdd = new DBcnx();
        return $bdd->recuperar_clave($mail);
    }

    public function ultimo_usuario(){
        $bdd = new DBcnx();
        return $bdd->ultimo_usuario();
	}

	public function getByPk($id){
        $bdd = new DBcnx();
        return $bdd->getByPkUser($id);
	}

	public function getById($id){
        $bdd = new DBcnx();
        return $bdd->getByIdUser($id);
	}

    //VER SI EL MAIL YA EXISTE
	public function chequear_mail($mail){
        $bdd = new DBcnx();
        return $bdd->chequear_mail($mail);
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
        $bdd = new DBcnx();
        return $bdd->allUser();
	}
}
