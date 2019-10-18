<?php

/*  CREATE TABLE Veraz(
	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	FK_PRESTAMO INT(9) UNSIGNED NOT NULL,
	ANSWER ENUM('Aprobado','Reprobado') DEFAULT 'Reprobado',

	FOREIGN KEY (FK_PRESTAMO) REFERENCES Prestamo(ID)
);*/

    class Veraz{

   /* A T R I B U T O S */
     private $codigo_veraz;
     private $fk_prestamo;
     private $answer;

	public static $tabla = "Veraz";
	private static $fila = ['FK_PRESTAMO', 'ANSWER'];

    /* G E T T E R S  &&  S E T T E R S */
	public function setCodigoVeraz($a){
		$this->codigo_veraz = $a;
	}
	public function getCodigoVeraz(){
		return $this->codigo_veraz;
	}
	public function setFkPrestamo($a){
		$this->fk_prestamo = $a;
	}
	public function getFkPrestamo(){
		return $this->fk_prestamo;
	}
	public function setAnswer($a){
		$this->answer = $a;
	}
	public function getAnswer(){
		return $this->answer;
	}

    /* M E T O D O S   D E   L A   C L A S E */
    public function __construct(){}

	//CREAR
	public function crear_registro($array){
	      $bdd = new DBcnx();
		return $bdd->crear_registro($array);
	}

	//PROCESAR DATA
	public function procesar_data(){
		if((bool)random_int(0, 1)) {
		    return "Aprobado";
		}
		return "Reprobado";
	}
}
