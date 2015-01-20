<?php
session_start();

$cedula=$_POST['cedula']; 
$nombres=$_POST['nombres']; 
$apellidos=$_POST['apellidos']; 
$direccion=$_POST['direccion']; 
$telefono=$_POST['telefono']; 
$email=$_POST['email'];

include("../../controlador/configuracion.php");
if ($_POST['buscar']){
	$query="select * from personal where cedula='".$cedula."'";
	$result=mysql_query($query) or die("Error en la instruccion SQL");
	if ($registro = mysql_fetch_array($result)){ 	
		$_SESSION['cedula']   =$registro['cedula']; 
		$_SESSION['nombres']  =$registro['nombres']; 
		$_SESSION['apellidos']=$registro['apellidos']; 
		$_SESSION['direccion']=$registro['direccion']; 
		$_SESSION['telefono'] =$registro['telefono']; 
		$_SESSION['email']    =$registro['email'];
	}else{
		$_SESSION['cedula']   =$cedula; 
		$_SESSION['nombres']  =""; 
		$_SESSION['apellidos']=""; 
		$_SESSION['direccion']=""; 
		$_SESSION['telefono'] =""; 
		$_SESSION['email']    ="";
	}
}else{
	$_SESSION['cedula']   =$cedula; 
	$_SESSION['nombres']  =$nombres; 
	$_SESSION['apellidos']=$apellidos; 
	$_SESSION['direccion']=$direccion; 
	$_SESSION['telefono'] =$telefono; 
	$_SESSION['email']    =$email;

	if ($_POST['actualizar']){
		$query="select cedula from personal where cedula='".$cedula."'";
		$result=mysql_query($query) or die("Error en la instruccion SQL");
		if (mysql_num_rows($result) > 0) {
			$query="UPDATE personal SET cedula='$cedula',nombres='$nombres',apellidos='$apellidos',direccion='$direccion',telefono='$telefono',email='$email' 
			where cedula='$cedula'";
		} else {
			$query="insert into personal(cedula,nombres,apellidos,direccion,telefono,email) 
			values('$cedula','$nombres','$apellidos','$direccion','$telefono','$email')"; 
		} 
		$result=mysql_query($query) or die("Error ejecutar la instrucción SQL ".mysql_error()); 
	}else{
		if ($_POST['eliminar']){
			$query="select cedula from personal where cedula=".$cedula;
			$result=mysql_query($query) or die("Error en la instruccion SQL");
			if (mysql_num_rows($result) == 1) {
				$query = "delete from personal where cedula = ".$cedula;  
				$result = mysql_query($query); 
			}	
		}	
	}
}
mysql_close();
header('Location: personal.php');
?>