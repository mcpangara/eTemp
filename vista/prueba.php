<?php
	session_start();
	include("../../controlador/configuracion.php");
	include("../../beans/CargoBean.php");
	include("../../controlador/controlModelo.php");
		
	$control = new Conexion();
	$listaCargo = array();
	$listaCargo = $control->leerListaRegistros("select * from cargo order by codigo",new CargoBean());
	echo "Total Registros: ".count($listaCargo);
	for ($i=0;$i<count($listaCargo);$i++){
		$cargo = $listaCargo[$i];
		if ($i==0){
			echo "<br>";
			$control->actualizarRegistroStr($cargo,'cargo');
			echo "<br>";
			$control->insertarRegistroStr($cargo,'cargo');
			echo "<br>";
		}	
	}
	echo "-----------------------------------------------------------------";
	mysql_close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title></title> 
</head> 
<body> 

</body> 
<?php 
echo "<a href='../../index.php'><img src='../../iconos/inicio.png'></a>"; 
?> 

</html>