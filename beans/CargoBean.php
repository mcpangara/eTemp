<?php
class CargoBean {
	var $id;
	var $codigo;
	var $cargo;
	var $salario;
	var $finicio;
	var $ffinal;
	var $directo;
	var $idusuario;
	var $fechaactualiza;
	
	function __construct() {
		$this->id = "";
		$this->codigo = "";
		$this->cargo = "";
		$this->salario = "";
		$this->finicio = "";
		$this->ffinal = "";
		$this->directo = "";
		$this->idusuario = "";
		$this->fechaactualiza = "";
	}	
	
	public function __set($_name,$_vlr){
		$this->$_name = $_vlr;
	}	

	public function __get($_name){
		return $this->$_name;
	}	
	
   function __destruct() {;}	
  
}
?>