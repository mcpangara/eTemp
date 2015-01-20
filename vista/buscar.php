<?php
session_start();

$campo=$_POST['campo']; 
$valor=$_POST['valor']; 

include("../../controlador/configuracion.php");
if ($_POST['buscar']){
	$query="SELECT * FROM personal WHERE ".$campo." LIKE '".$valor."%' ORDER BY ".$campo;
	$result=mysql_query($query) or die("Error en la instruccion SQL");
	if ($registro = mysql_fetch_array($result)){ 	
		$_SESSION['id']       =$registro['id']; 
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
}
$_SESSION['campo']=$campo; 
$_SESSION['valor']=$valor; 
mysql_close();
header('Location: personal.php');
?>