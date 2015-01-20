<?php
	include("controlador/controlModelo.php");
	if (!isset($_REQUEST['usuario'])){
		$__usuario   =$campo_buscar;
	}else{
		$__usuario    =$_REQUEST['usuario'];
	}

	if (!isset($_REQUEST['password'])){
		$__password    = "";
	}else{
		$__password    =$_REQUEST['password'];
	}
	
	if (!isset($_REQUEST['email'])){
		$__email    ="";
	}else{
		$__email    =$_REQUEST['email'];
	}
	
	$control = new Conexion();
	$control->validarIngreso($__usuario,$__password,$__email);
	if ($control->_usuarioActual>0 && $control->_nivelActual>0){
		session_start();
		$_SESSION['idusuario']=$control->_usuarioActual; 
		$_SESSION['nivel']=$control->_nivelActual;
		$_SESSION['nempresa']=".."; 
		$_SESSION['mensaje']="Generador de Ventanas";
		$_SESSION['error']="";
		
	/*
		nivel 5 => todos los privilegios
		nivel 3 => consulta, generacion de excel, impresion
		nivel 1 => consulta, impresion
	*/		
		header('Location: menu.php');
	}else{
		$_SESSION['error']="Datos incorrectos, vuelva a intentarlo";
	}
?>
