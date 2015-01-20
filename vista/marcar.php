<?php
session_start();

$id=$_POST['registro']; 
include("../../controlador/configuracion.php");

$query="select * from personal where id=".$id;
echo "registro:".$id;
$result=mysql_query($query) or die("Error en la instruccion SQL");

if ($registro = mysql_fetch_array($result)){ 	
	$_SESSION['id']       =$id; 
	$_SESSION['cedula']   =$registro['cedula']; 
	$_SESSION['nombres']  =$registro['nombres']; 
	$_SESSION['apellidos']=$registro['apellidos']; 
	$_SESSION['direccion']=$registro['direccion']; 
	$_SESSION['telefono'] =$registro['telefono']; 
	$_SESSION['email']    =$registro['email'];
}else{
	$_SESSION['cedula']   ="";
	$_SESSION['nombres']  =""; 
	$_SESSION['apellidos']=""; 
	$_SESSION['direccion']=""; 
	$_SESSION['telefono'] =""; 
	$_SESSION['email']    ="";
}

mysql_close();
header('Location: personal.php');
?>