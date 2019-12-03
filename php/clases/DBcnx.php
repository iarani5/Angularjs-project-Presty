<?php

class DBcnx{

    private static $db;

	private static function connect(){
		$host = "localhost";
		$user = "root";
		$pass = "";
		$name = "Presty";
		$dsn = "mysql:host=" . $host . ";dbname=" . $name . ";charset=utf8";
		try {
			self::$db = new PDO($dsn, $user, $pass);
		} 
		catch(Exception $e) {
			echo "Ups! Hubo un error en la página: " . $e->getMessage();
		}
	}
	
	public static function getConnection(){
		if(empty(self::$db)) {
			self::connect();
		}
		return self::$db;
	}
	
	public static function getStatement($query){
		return self::getConnection()->prepare($query);
	}


	/******************************************** QUERYS *******************************************/

	/*********** USER ********/
	public function crear_usuario($array){
		$query = "INSERT INTO `User` (EMAIL, PASSWORD, USER_TYPE)
					VALUES (?, ?, ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["EMAIL"], $array["PASSWORD"], $array["USER_TYPE"]]);
	}

	public function editar_usuario($variable,$array){
		$query = "UPDATE `User` SET $variable=? WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["VALOR"],$array["ID"]]);
	}

	public function editar_clave($array){ //EDICION DE CLAVE
		$query = "UPDATE `User` SET PASSWORD=? WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["PASSWORD"],$array["ID"]]);
	}

	public function eliminar_usuario($id){
		$query = "UPDATE `User`  SET BORRADO='Si' WHERE ID=? ";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$id]);
	}

	public function login($array){
		$query = "SELECT * FROM `User` WHERE EMAIL=? AND PASSWORD=? AND BORRADO='No' ";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$array["EMAIL"],$array["PASSWORD"]]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

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
	public function ultimo_usuario(){
		$salida = [];
		$query = "SELECT * FROM `User` ORDER BY ID DESC LIMIT 1";
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$user = new User;
				$user->setCodigoUsuario( $fila['ID']);
				$user->cargarDatos($fila);
				$salida[] = $user;
			}
		}
		return $salida[0];
	}

	public function getByPkUser($id){
		$query = "SELECT * FROM `User`
					WHERE FK_USER = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getByIdUser($id){
		$query = "SELECT * FROM `User`
					WHERE ID = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

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

	public static function allUser(){
		$salida = [];
		$query = "SELECT * FROM `User`";
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$usuario = new User;
				$usuario->setCodigoUsuario($fila['ID']);
				$usuario->setEmail( $fila['EMAIL']);
				$usuario->setPassword($fila['PASSWORD']);
				$usuario->setUserType($fila['USER_TYPE']);
				$usuario->setBorrado($fila['BORRADO']);
				$usuario->cargarDatos($fila);
				$salida[] = $usuario;
			}
		}
		return $salida;
	}
	
	/*********** FINANCIERA ********/

	public function crear_financiera($array){
	    $query = "INSERT INTO Financiera (FK_USER, COMPANY)
            				VALUES (?,?)";
            $stmt = DBcnx::getStatement($query);
            return $stmt->execute([$array['FK_USER'],$array['COMPANY']]);
	}
	
	public function getByIdFinanciera($id){
		$query = "SELECT * FROM Financiera
					WHERE FK_USER = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getByPkFinanciera($id){
		$query = "SELECT * FROM Financiera
					WHERE FK_USER = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function allFinanciera(){
		$salida = [];
		$query = "SELECT * FROM Financiera";
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$financiera = new Financiera;
				$financiera->setCodigoFinanciera($fila['ID']);
				$financiera->setFkUser($fila['FK_USER']);
				$financiera->setCompany($fila['COMPANY']);
				$financiera->setBorrado($fila['BORRADO']);
				$financiera->cargarDatos($fila);
				$salida[] = $financiera;
			}
		}
		return $salida;
	}
	
	/*********** CLIENT ********/

	public function crear_cliente($array){
            $query = "INSERT INTO Client (FK_USER, NAME, LAST_NAME, DNI, PHONE, BIRTH_DAY)
            				VALUES (?,?,?,?,?,?)";
            $stmt = DBcnx::getStatement($query);
            return $stmt->execute([$array['FK_USER'],$array['NAME'],$array['LAST_NAME'],$array['DNI'],$array['PHONE'],$array['BIRTH_DAY']]);
    }

	public function editar_cliente($array){
        $query = "UPDATE Client SET NAME=?, LAST_NAME=?, DNI=?, PHONE=?, BIRTH_DAY=? WHERE FK_USER=?";
        $stmt = DBcnx::getStatement($query);
        return $stmt->execute([$array["NAME"],$array["LAST_NAME"],$array["DNI"],$array["PHONE"],$array["BIRTH_DAY"],$array["FK_USER"]]);
	}

	public function getByPkClient($id){
		$query = "SELECT * FROM Client
					WHERE ID = $id";
		$stmt = DBcnx::getStatement($query);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getByIdClient($id){
		$query = "SELECT * FROM Client
					WHERE FK_USER = $id";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public static function allClient(){
		$salida = [];
		$query = "SELECT * FROM Client";
		$stmt = DBcnx::getStatement($query);
		if($stmt->execute()) {
			while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$client = new Client;
				$client->setCodigoClient($fila['ID']);
				$client->setFkUser($fila['FK_USER']);
				$client->setName($fila['NAME']);
				$client->setLastName($fila['LAST_NAME']);
				$client->setDni($fila['DNI']);
				$client->setBirthDay($fila['BIRTH_DAY']);
				$client->setPhone($fila['PHONE']);
				$client->setBorrado($fila['BORRADO']);
				$client->cargarDatos($fila);
				$salida[] = $client;
			}
		}
		return $salida;
	}

	/*********** OFERTA ********/
	
	 public function crear_oferta($array){
		$query = "INSERT INTO Oferta (FK_FINANCIERA, FK_PRESTAMO, STATE)
				VALUES (?, ?, ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["FK_FINANCIERA"],$array["FK_PRESTAMO"],$array["STATE"]]);
	}
	
	public function rechazar_oferta($array){
        $query = "UPDATE Oferta SET STATE_CLIENT = 'Rechazada' WHERE FK_FINANCIERA=? AND FK_PRESTAMO=?";
        $stmt = DBcnx::getStatement($query);
        return $stmt->execute([$array["FK_FINANCIERA"],$array["FK_PRESTAMO"]]);
    }

	public function get_prestamos_ya_evaluadosOferta($id){
                $query = "SELECT * FROM Oferta WHERE FK_FINANCIERA=?";
                $stmt = DBcnx::getStatement($query);
                $stmt->execute([$id]);
                $salida=[];
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                		$oferta = new Oferta;
                        $oferta->setCodigoOferta($fila['ID']);
                        $oferta->setFkPrestamo($fila['FK_PRESTAMO']);
                        $oferta->setFkPrestamo($fila['FK_FINANCIERA']);
                        $oferta->cargarDatos($fila);
                        $salida[] = $oferta;
                }
                return $salida;
    }
	
     public function get_prestamo_con_ofertas($id){
           $query = "SELECT * FROM Oferta WHERE FK_PRESTAMO=? AND STATE='Ofertar' AND STATE_CLIENT IS NULL";
           $stmt = DBcnx::getStatement($query);
           $stmt->execute([$id]);
           $salida=[];
           while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $oferta = new Oferta;
                $oferta->setCodigoOferta($fila['ID']);
                $oferta->setFkFinanciera($fila['FK_FINANCIERA']);
                $oferta->cargarDatos($fila);
                $salida[] = $oferta;
           }
           return $salida;
    }
	
	/*********** PRESTAMO ********/
	
	public function crear_prestamo($array){
        $query = "INSERT INTO Prestamo (FK_CLIENT, FK_AUTORIZADOR, AMOUNT, CREATED_DATE)
				VALUES (?, ?, ?, ?)";
        $stmt = DBcnx::getStatement($query);
        return $stmt->execute([$array["FK_CLIENT"],$array["FK_AUTORIZADOR"],$array["AMOUNT"],$array["CREATED_DATE"]]);
    }

	public function prestamo_concretado($array){
		$query = "UPDATE Prestamo  SET FK_FINANCIERA=?, STATE='Otorgado' WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["FK_FINANCIERA"],$array["FK_PRESTAMO"]]);
	}

	public function estado_prestamo($id){
	    $client = new Client();
	    $id=$client->getById($id)["ID"];
        $query = "SELECT * FROM Prestamo WHERE FK_CLIENT = $id ORDER BY ID DESC LIMIT 1";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function cambiar_estado($estado,$id){
		$query = "UPDATE Prestamo SET STATE=? WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$estado,$id]);
	}
	
	public function get_prestamos_autorizador($id){
        $query = "SELECT * FROM Prestamo WHERE FK_AUTORIZADOR = $id AND STATE='Pedido'";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute([$id]);
        $salida=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        		$prestamo = new Prestamo;
        		$prestamo->setCodigoPrestamo($fila['ID']);
        		$prestamo->setFkClient($fila['FK_CLIENT']);
        		$prestamo->setFkAutorizador($fila['FK_AUTORIZADOR']);
        		$prestamo->setAmount($fila['AMOUNT']);
        		$prestamo->setCreatedDate($fila['CREATED_DATE']);
        		$prestamo->cargarDatos($fila);
        		$salida[] = $prestamo;
        }
        return $salida;
	}
	
	public function get_prestamos_ya_evaluadosPrestamo(){
            $query = "SELECT * FROM Prestamo WHERE STATE='Pre-Otorgado'";
            $stmt = DBcnx::getStatement($query);
            $stmt->execute();
            $salida=[];
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            		$prestamo = new Prestamo;
            		$prestamo->setCodigoPrestamo($fila['ID']);
            		$prestamo->setFkClient($fila['FK_CLIENT']);
            		$prestamo->setFkAutorizador($fila['FK_AUTORIZADOR']);
            		$prestamo->setAmount( $fila['AMOUNT']);
            		$prestamo->setCreatedDate($fila['CREATED_DATE']);
            		$prestamo->cargarDatos($fila);
            		$salida[] = $prestamo;
            }
            return $salida;
    	}

        public static function allPrestamos(){
            $salida = [];
            $query = "SELECT * FROM Prestamo";
            $stmt = DBcnx::getStatement($query);
            if($stmt->execute()) {
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $prestamo = new Prestamo;
                    $prestamo->setCodigoPrestamo($fila['ID']);
                    $prestamo->setState($fila['STATE']);
                    $prestamo->cargarDatos($fila);
                    $salida[] = $prestamo;
                }
            }
            return $salida;
        }
	/*********** VERAZ ********/

	public function crear_registro($array){
	    $veraz = new Veraz();
	    $array["ANSWER"]=$veraz->procesar_data();
		$query = "INSERT INTO Veraz (FK_PRESTAMO, ANSWER)
				VALUES (?, ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["ID"],$array["ANSWER"]]);
	}
	
	/*********** AUTORIZADOR ********/
	
	public static function allAutorizador(){
        $salida = [];
        $query = "SELECT * FROM  `User` WHERE USER_TYPE='Autorizador'" ;
        $stmt = DBcnx::getStatement($query);
        if($stmt->execute()) {
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario = new User;
                $salida[] = $fila;
            }
        }
        return $salida;
    }
		
	/*********** PUBLICIDAD ********/

	public function crear_publicidad($array){
		$query = "INSERT INTO Publicidad  (NAME, LINK, IMG) VALUES (?, ?, ?)";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["NAME"],$array["LINK"],$array["IMG"]]);
	}
	public function traer_publicidad(){
        $query = "SELECT * FROM Publicidad";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute();
        $salida=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $salida[] = $fila;
        }
        return $salida;
	}

	public function traer_publicidad_para_home(){
        $query = "SELECT * FROM Publicidad WHERE BORRADO='No' LIMIT 5";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute();
        $salida=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $salida[] = $fila;
        }
        return $salida;
	}

    public function mostrar_publicidad($estado,$id){
        $query = "UPDATE Publicidad SET BORRADO=? WHERE ID=?";
        $stmt = DBcnx::getStatement($query);
        return $stmt->execute([$estado,$id]);
    }

    public function editar_publicidad($array){
            $query = "UPDATE Publicidad SET NAME=?, LINK=? WHERE ID=?";
            $stmt = DBcnx::getStatement($query);
            return $stmt->execute([$array['NAME'],$array['LINK'],$array['ID']]);
    }

	public function eliminar_publicidad($array){
		$query = "UPDATE  Publicidad   SET BORRADO='Si' WHERE ID=? ";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$array["ID"]]);
	}

	// ************ STATS ************** //


}


