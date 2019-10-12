<?php

/*CREATE TABLE Prestamo(
	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	FK_CLIENT INT(9) UNSIGNED NOT NULL,
	FK_FINANCIERA INT(9) UNSIGNED NOT NULL,
	FK_AUTORIZADOR INT(9) UNSIGNED NOT NULL,
	AMOUNT INT(11) NOT NULL,
	`STATE` ENUM('Pedido','Pre-Otorgado','Otorgado','Denegado') DEFAULT 'Pedido',
	CREATED_DATE DATETIME NOT NULL,
	BORRADO ENUM('Si','No') NOT NULL DEFAULT 'No',

	FOREIGN KEY (FK_CLIENT) REFERENCES Client(ID),
	FOREIGN KEY (FK_FINANCIERA) REFERENCES Financiera(ID),
	FOREIGN KEY (FK_AUTORIZADOR) REFERENCES `User`(ID)
);*/

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

    //CREAR
    public function crear_prestamo($array){
    		$query = "INSERT INTO " . static::$tabla . " (FK_CLIENT, FK_AUTORIZADOR, AMOUNT, CREATED_DATE)
    				VALUES (?, ?, ?, ?)";
    		$stmt = DBcnx::getStatement($query);
    		return $stmt->execute([$array["FK_CLIENT"],$array["FK_AUTORIZADOR"],$array["AMOUNT"],$array["CREATED_DATE"]]);
    }

    //SOLICITUD DE PRESTAMO
	public function solicitud_de_prestamo($id){
		$query = "UPDATE " . static::$tabla . "  SET FK_FINANCIERA=? AND STATE='Pre-Otorgado' WHERE ID=?";
		$stmt = DBcnx::getStatement($query);
		return $stmt->execute([$id]);
	}

    //ESTADO DE PRESTAMO
	public function estado_prestamo($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE FK_CLIENT = $id ORDER BY ID DESC LIMIT 1";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    //GET AUTORIZADOR
	public function get_prestamos_autorizador($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE FK_AUTORIZADOR = $id AND STATE='Pedido'";
        $stmt = DBcnx::getStatement($query);
        $stmt->execute([$id]);
        $salida=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        		$prestamo = new Prestamo;
        		$prestamo->codigo_prestamo = $fila['ID'];
        		$prestamo->fk_client = $fila['FK_CLIENT'];
        		$prestamo->fk_autorizador = $fila['FK_AUTORIZADOR'];
        		$prestamo->amount = $fila['AMOUNT'];
        		$prestamo->created_date = $fila['CREATED_DATE'];
        		$prestamo->cargarDatos($fila);
        		$salida[] = $prestamo;
        }
        return $salida;

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