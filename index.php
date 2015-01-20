<?php
	session_start();
	$_SESSION['nempresa']=".."; 
	$_SESSION['mensaje']="Generador de Ventanas";

	/*
		nivel 5 => todos los privilegios
		nivel 3 => consulta, generacion de excel, impresion
		nivel 1 => consulta, impresion
	*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html lang="es">
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title></title> 
</head> 
<body> 
	<h1>PRINCIPAL</h1>
	<FIELDSET>
	<LEGEND>opciones</LEGEND>
	<?php 
		echo "<a href='vista/personal/personal.php'>Personal</a><br>"; 
		echo "<a href='vista/cargo/cargo.php'>Cargo</a><br>"; 
		//echo date("Y-m-d")."\n";
	?> 
	</FIELDSET>	
	<br>
</body> 

</html>