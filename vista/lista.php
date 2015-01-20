<?php
include("../../controlador/configuracion.php");
if(!empty($valor)){
	$query="SELECT id,cedula,nombres,apellidos FROM personal WHERE ".$campo." LIKE '".$valor."%' ORDER BY ".$campo;
}else{
	$query="SELECT id,cedula,nombres,apellidos FROM personal ORDER BY ".$campo;
}

$result=mysql_query($query) or die("Error en la instruccion SQL");

//echo "<div id='datos' style='width:400px; height:300px; overflow: scroll;'>";
echo "<form name='datosEl' id='datosEl' method='post' action='marcar.php' > ";
echo "<table border = '0'> \n"; 
echo "<tr bgcolor='#cccccc'><td>Seleccionar</td><td>Cedula</td><td>Nombres</td><td>Apellidos</td></tr> \n"; 

$swcolor=false;
while ($row = mysql_fetch_row($result)){ 
	if ($swcolor){
		$color="'cceeee'";
	}else{
		$color="'eeeecc'";
	}
	$selector="";
	if(isset($_SESSION['id'])){
		if ($row[0]==$_SESSION['id']){
			$selector="checked='checked'";
			$color="'55aaff'";
		}
	}
	echo "<tr bgcolor=".$color."><td align='center'><input type='radio' name='registro' value='".$row[0]."' onClick='javascript:document.datosEl.submit();' ".$selector."/></td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr> \n"; 
	$swcolor = !$swcolor;
} 
echo "</table> \n"; 
echo "</form> \n"; 
//echo "</div>";
mysql_close();
?> 



