<?php
class PersonalBean {
	var $id;
	var $tipodoc;
	var $cedula;
	var $nombres;
	var $apellidos;
	var $direccion;
	var $municipio;
	var $telefono;
	var $fechanac;
	var $lugarnac;
	var $estadocivil;
	var $hijos;
	var $sexo;
	var $raza;
	var $estudios;
	var $rh;
	var $eps;
	var $fp;
	var $arl;
	var $cesantia;
	var $banco;
	var $ncuenta;
	var $tcuenta;
	var $email;
	var $idusuario;
	var $fechaactualiza;
	
	function __construct() {
		$this->limpiar();
	}	
	
	public function __set($_name,$_vlr){
		$this->$_name = $_vlr;
	}	

	public function __get($_name){
		return $this->$_name;
	}	
	
	public function limpiar(){
		$this->id = 0;
		$this->tipodoc = "";
		$this->cedula = "";
		$this->nombres = "";
		$this->apellidos = "";
		$this->direccion = "";
		$this->municipio = "";
		$this->telefono = "";
		$this->fechanac = "";
		$this->lugarnac = "";
		$this->estadocivil = "";
		$this->hijos = "";
		$this->sexo = "";
		$this->raza = "";
		$this->estudios = "";
		$this->rh = "";
		$this->eps = "";
		$this->fp = "";
		$this->arl = "";
		$this->cesantia = "";
		$this->banco = "";
		$this->ncuenta = "";
		$this->tcuenta = "";
		$this->email = "";
		$this->idusuario = "";
		$this->fechaactualiza = "";
	}
	
	public function actualizar($_origen){
		//($this->id == $_origen->__get('id'))? :($this->id = $_origen->__get('id'));
		($this->tipodoc != $_origen->__get('tipodoc'))? ($this->tipodoc = $_origen->__get('tipodoc')):"";
		($this->cedula == $_origen->__get('cedula'))? :($this->cedula = $_origen->__get('cedula'));
		($this->nombres == $_origen->__get('nombres'))? :($this->nombres = $_origen->__get('nombres'));
		($this->apellidos == $_origen->__get('apellidos'))? :($this->apellidos = $_origen->__get('apellidos'));
		($this->direccion == $_origen->__get('direccion'))? :($this->direccion = $_origen->__get('direccion'));
		($this->municipio == $_origen->__get('municipio'))? :($this->municipio = $_origen->__get('municipio'));
		($this->telefono == $_origen->__get('telefono'))? :($this->telefono = $_origen->__get('telefono'));
		($this->fechanac == $_origen->__get('fechanac'))? :($this->fechanac = $_origen->__get('fechanac'));
		($this->lugarnac == $_origen->__get('lugarnac'))? :($this->lugarnac = $_origen->__get('lugarnac'));
		($this->estadocivil == $_origen->__get('estadocivil'))? :($this->estadocivil = $_origen->__get('estadocivil'));
		($this->hijos == $_origen->__get('hijos'))? :($this->hijos = $_origen->__get('hijos'));
		($this->sexo == $_origen->__get('sexo'))? :($this->sexo = $_origen->__get('sexo'));
		($this->raza == $_origen->__get('raza'))? :($this->raza = $_origen->__get('raza'));
		($this->estudios == $_origen->__get('estudios'))? :($this->estudios = $_origen->__get('estudios'));
		($this->rh == $_origen->__get('rh'))? :($this->rh = $_origen->__get('rh'));
		($this->eps == $_origen->__get('eps'))? :($this->eps = $_origen->__get('eps'));
		($this->fp == $_origen->__get('fp'))? :($this->fp = $_origen->__get('fp'));
		($this->arl == $_origen->__get('arl'))? :($this->arl = $_origen->__get('arl'));
		($this->cesantia == $_origen->__get('cesantia'))? :($this->cesantia = $_origen->__get('cesantia'));
		($this->banco == $_origen->__get('banco'))? :($this->banco = $_origen->__get('banco'));
		($this->ncuenta == $_origen->__get('ncuenta'))? :($this->ncuenta = $_origen->__get('ncuenta'));
		($this->tcuenta == $_origen->__get('tcuenta'))? :($this->tcuenta = $_origen->__get('tcuenta'));
		($this->email == $_origen->__get('email'))? :($this->email = $_origen->__get('email'));
		($this->idusuario == $_origen->__get('idusuario'))? :($this->idusuario = $_origen->__get('idusuario'));
		($this->fechaactualiza == $_origen->__get('fechaactualiza'))? :($this->fechaactualiza = $_origen->__get('fechaactualiza'));		
	}
   function __destruct() {;}	
  
}
?>