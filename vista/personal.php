<?php
	session_start();
	include("../../controlador/configuracion.php");
	include("../../beans/PersonalBean.php");
	$personal = new PersonalBase();
	
		
	if (!isset($_REQUEST['campo'])){
		$campo    =$_SESSION['campo'];
	}else{
		$campo    =$_REQUEST['campo'];
	}
	$_SESSION['campo']       =$campo; 
	
	if (!isset($_REQUEST['valor'])){
		$valor    =$_SESSION['valor'];
	}else{
		$valor    =$_REQUEST['valor'];
	}
	$_SESSION['valor']       =$valor; 
	
	if (!isset($_REQUEST['registro'])){
		$id    =0;
	}else{
		$id    =$_REQUEST['registro'];
	}
	$_SESSION['id']       =$id; 
	
	$cedula   =""; 
	$nombres  =""; 
	$apellidos=""; 
	$direccion=""; 
	$telefono =""; 
	$email    =""; 

	if (isset($_REQUEST['buscar']) or isset($_REQUEST['actualizar']) or isset($_REQUEST['eliminar']) or isset($_REQUEST['registro'])){
	if (isset($_REQUEST['buscar'])){
		$query="SELECT * FROM personal WHERE ".$campo." LIKE '".$valor."%' ORDER BY ".$campo;
		$result=mysql_query($query) or die("Error en la instruccion SQL");
		if ($registro = mysql_fetch_array($result)){ 	
			$cedula   =$registro['cedula']; 
			$nombres  =$registro['nombres']; 
			$apellidos=$registro['apellidos']; 
			$direccion=$registro['direccion']; 
			$telefono =$registro['telefono']; 
			$email    =$registro['email'];
		}
	}else{
		if (isset($_REQUEST['actualizar'])){
			$cedula   =$_REQUEST['cedula']; 
			$nombres  =$_REQUEST['nombres'];  
			$apellidos=$_REQUEST['apellidos'];  
			$direccion=$_REQUEST['direccion']; 
			$telefono =$_REQUEST['telefono']; 
			$email    =$_REQUEST['email']; 
			
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
			if (isset($_REQUEST['eliminar'])){
				$query="select cedula from personal where cedula=".$cedula;
				$result=mysql_query($query) or die("Error en la instruccion SQL");
				if (mysql_num_rows($result) == 1) {
					$query = "delete from personal where cedula = ".$cedula;  
					$result = mysql_query($query); 
				}	
			}else{
				if (isset($_REQUEST['registro'])){
					$query="select * from personal where id=".$id;
					$result=mysql_query($query) or die("Error en la instruccion SQL");

					if ($registro = mysql_fetch_array($result)){ 	
						//$valor    =$registro['cedula']; 
						$cedula   =$registro['cedula']; 
						$nombres  =$registro['nombres']; 
						$apellidos=$registro['apellidos']; 
						$direccion=$registro['direccion']; 
						$telefono =$registro['telefono']; 
						$email    =$registro['email'];
					}				
				}
			}
		}
	}
	}
//	mysql_close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title></title> 
</head> 
<body> 
	<h1>CRUD PERSONAL</h1>
	<form name="datos" id="datos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" > 
		<table>
			<tr>
				<td>Criterio</td>
				<td>
					<select name="campo">
						<option value='cedula' <?php if($campo=='cedula'){echo " selected ";} ?>>Cedula</option>
						<option value='nombres'<?php if($campo=='nombres'){echo " selected ";} ?>>Nombre</option>
						<option value='apellidos'<?php if($campo=='apellidos'){echo " selected ";} ?>>Apellido</option>
					</select>				
				</td>
				<td><input name="valor" value="<?php echo $valor; ?>" /></td>
				 <?php
				//<td><input type="submit" name="buscar" value="Buscar"/></td> 
				?>
				<td>
				<button name="buscar" type="submit"><img src="../../iconos/find.ico"></button>
				</td>
			</tr>
		</table>
	</form>
	<FIELDSET>
	<LEGEND>Datos</LEGEND>
	<form name="datos" id="datos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" > 
		<table bgcolor='ffcccc'>
			<tr>
				<td>Identificacion</td><td><input name="cedula" value="<?php echo $cedula;?>" /></td><td></td><td></td>
			</tr>	
			<tr>	
				<td>Nombres</td><td><input name="nombres"  value="<?php echo $nombres;?>"/></td><td>Apellidos</td><td><input name="apellidos" value="<?php echo $apellidos;?>"/></td>
			</tr>	
			<tr>	
				<td>Direccion</td><td><input name="direccion"  value="<?php echo $direccion;?>"/></td><td>Telefono</td><td><input name="telefono" value="<?php echo $telefono;?>"/></td>
			</tr>	
			<tr>	
				<td>Email</td><td><input name="email" size="40"  value="<?php echo $email;?>"/></td><td></td>
				<td>
				<?php
				/*
				<input type="submit" name="actualizar" value="Actualizar"/>
				<input type="submit" name="eliminar" value="Eliminar"/>
				*/
				?>
				<button name="actualizar" type="submit"><img src="../../iconos/ok.ico"></button>
				<button name="eliminar" type="submit"><img src="../../iconos/del.ico"></button>
				</td>
			</tr>
		</table>
	</form> 
	</FIELDSET>	
	
	<?php
		if(!empty($valor)){
			$query="SELECT id,cedula,nombres,apellidos FROM personal WHERE ".$campo." LIKE '".$valor."%' ORDER BY ".$campo;
		}else{
			$query="SELECT id,cedula,nombres,apellidos FROM personal ORDER BY ".$campo;
		}
		$result=mysql_query($query) or die("Error en la instruccion SQL");
	
		echo "<div id='datos' style='width:700px; height:300px; overflow: scroll;'>";
		echo "<form name='datosEl' id='datosEl' method='post' action='".$_SERVER['PHP_SELF']."' > ";
		echo "<table border = '0' width='100%'> \n"; 
		echo "<tr bgcolor='#cccccc'><td align='center'>Seleccionar</td><td align='center'>Cedula</td><td align='center'>Nombres</td><td align='center'>Apellidos</td></tr> \n"; 

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
		echo "</div>";
		mysql_close();
	?>	
</body> 
<?php 
echo "<a href='../../index.php'><img src='../../iconos/inicio.png'></a>"; 
?> 

</html>