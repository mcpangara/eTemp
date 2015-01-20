<?php
	session_start();
	
	// ***************************************
	//    BUSCAR Y REEMPLAZAR:
	//          PersonalBean -> TablaBean
	//          personal     -> tabla_origen
	//          cedula       -> campo_de_busqueda
	// 
	// ***************************************
	
	include("../../beans/CargoBean.php");
	include("../../controlador/controlModelo.php");
	include("../../controlador/Constantes.php");
		
	$tabla_origen = "cargo";
	$campo_buscar = "codigo";
	$titulosTabla = array("CODIGO","CARGO","SALARIO");
	$camposTabla= array("codigo","cargo","salario");
	
	$control = new Conexion();
	
	$bean = new CargoBean();
	$BeanUnico = clone $bean;
	$bean_temp =  clone $bean;
	
	$beanActual = $control->leerCaracteristicas($tabla_origen,$bean_temp);
		
	if (!isset($_REQUEST['__campo'])){
		$__campo    =$campo_buscar;
	}else{
		$__campo    =$_REQUEST['__campo'];
	}

	if (!isset($_REQUEST['__valor'])){
		$__valor    = "";
	}else{
		$__valor    =$_REQUEST['__valor'];
	}
	
	if (!isset($_REQUEST['registro'])){
		$id    =0;
	}else{
		$id    =$_REQUEST['registro'];
	}
	
	if (isset($_REQUEST['buscar']) or isset($_REQUEST['actualizar']) or isset($_REQUEST['eliminar']) or isset($_REQUEST['registro'])  or isset($_REQUEST['limpiar']) or isset($_REQUEST['excel'])){
		if (isset($_REQUEST['buscar'])){
			$query="SELECT * FROM ".$tabla_origen." WHERE ".$__campo." LIKE '".$__valor."%' ORDER BY ".$__campo;
			$bean = $control->leerRegistro($query,clone $BeanUnico);
		}else{
			if (isset($_REQUEST['actualizar'])){
				$bean_temp = clone $BeanUnico;
		
				//$query="select * from ".$tabla_origen." where {$campo_buscar}='{$bean_temp->__get('cedula')}'";
				$query="select * from ".$tabla_origen." where {$campo_buscar}='{$_REQUEST[$campo_buscar]}'";
				//echo $query."\n";
				$bean = $control->leerRegistro($query,clone $BeanUnico);
// *********************** PERSONALIZACION BEAN ***************************		
				$fechaactualiza=date("Y-m-d");
				
				// los demas campos del bean
				/*** se activa cunado esten todos los campos***/
				$_campos = get_object_vars($bean);
				$cantidad = count($_campos);
				foreach($_campos as $var => $value) {
					if (isset($_REQUEST[$var]))
						$bean->__set($var,$_REQUEST[$var]);
				}
				$bean->__set('idusuario',$_SESSION['idusuario']); 
				$bean->__set('fechaactualiza',$fechaactualiza);				
				// los demas campos del bean
// *********************** PERSONALIZACION BEAN ***************************		
				$bean_temp =clone $bean;
				if ($bean->__get('id')!=0){
					$control->ejecutar($control->actualizarRegistroStr($bean,$tabla_origen));
					//echo "Actualizado<br>";
					$id=$bean->__get('id');
				}else{
					$control->ejecutar($control->insertarRegistroStr($bean,$tabla_origen));
					//echo "Creado<br>";
				}
				$beanActual = $control->leerCaracteristicas($tabla_origen,$bean_temp);
				
			}else{
				if (isset($_REQUEST['eliminar'])){
					//$query = "delete from ".$tabla_origen." where {$campo_buscar} = '{$cedula}'";  
					$query = "delete from ".$tabla_origen." where id = {$id}";  
					$control->ejecutar($query);
					//echo "Eliminado<br>";
				}else{
					if (isset($_REQUEST['registro'])){
						$query="select * from ".$tabla_origen." where id=".$id;
						$bean_temp = $control->leerRegistro($query,clone $BeanUnico);
						$beanActual = $control->leerCaracteristicas($tabla_origen,$bean_temp);
					}else{
						if (isset($_REQUEST['limpiar'])){
							$id=0;
							$bean = clone $BeanUnico;
						}else{
							if (isset($_REQUEST['excel'])){
								if(!empty($__valor)){
									$query="SELECT * FROM ".$tabla_origen." WHERE {$__campo} LIKE '{$__valor}%' ORDER BY ".$__campo;
								}else{
									$query="SELECT * FROM {$tabla_origen} ORDER BY {$__campo}";
								}
								$x=$control->getExcel($query,$bean_temp,$tabla_origen);
							}
						}
					}
				}
			}
		}
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="es">
<head> 
	<meta charset="utf-8">

	<title>Personal</title> 
    <script src="../../src/js/jscal2.js"></script>
    <script src="../../src/js/lang/es.js"></script>
	<link rel="stylesheet" type="text/css" href="../../estilos/estiloPag.css" />
    <link rel="stylesheet" type="text/css" href="../../src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../../src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../../src/css/steel/steel.css" />	
</head> 
<body> 
	<div id="divPrincipal" >
		<h1 id="titulo"><?php echo "{$_SESSION['nempresa']} CRUD {$tabla_origen}"; ?></h1>
	<div id="divCabecera">
	<table id="tableCabecera">
		<tr>
			<td>
				<form name="datos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  accept-charset="UTF-8"> 
					<table>
						<tr>
							<td>Criterio de Orden y Busqueda</td>
							<td>
								<select name="__campo">
									<option value='codigo' <?php if($__campo=='codigo'){echo " selected ";} ?>>Codigo</option>
									<option value='cargo'<?php if($__campo=='cargo'){echo " selected ";} ?>>Cargo</option>
									<option value='salario'<?php if($__campo=='salario'){echo " selected ";} ?>>Salario</option>
								</select>				
							</td>
							<td>
								<input name="__valor" value="<?php echo $__valor; ?>" placeholder="Valor a Buscar" size="40"/>
							</td>
							<td>
								<button name="buscar" type="submit" id="buttonBuscar" ><img src='../../iconos/find.gif'><span>Busca el criterio dentro de la base de datos</span></button>
							</td>
							<td>
							<?php if($_SESSION['nivel']>=3){ ?>
								<button name='excel' type='submit' id="buttonBarra">Descargar<span>Descarga en Excel la informacion mostrada la tabla</span></button>
							<?php } ?>	
							</td>							
						</tr>
					</table>
				</form>
			</td>
			<td align="right">
				<?php echo "<a href='../../menu.php'><button  id='buttonBarra'><img src='../../iconos/salir.ico'>Salir<span>Regresa al menu principal</span></button></a>"; 
				?>
			</td>
		</tr>
	</table>
	</div>
	<div id="divDatos">
	<form name="datos" id="datos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  accept-charset="UTF-8"> 
		<table id="tableDatos">
<?php 
	/*********** INICIAR CONTENIDO DE TABLA *********/
?>		
			<tr>
				<td>Codigo</td><td><?php echo "{$beanActual['codigo']['html']}";?></td><td></td>
				<td></td>
			</tr>	
			<tr>	
				<td>Cargo</td><td><?php echo $beanActual['cargo']['html']; ?></td><td></td><td></td>
			</tr>	
			<tr>	
				<td>Salario</td><td><?php echo $beanActual['salario']['html']; ?></td><td>F. Inicio:<?php echo $beanActual['finicio']['html']; ?></td><td>F final:<?php echo $beanActual['ffinal']['html']; ?></td>
			</tr>	
			<tr>	
				<td>Directo</td><td><?php echo $beanActual['directo']['html']; ?></td>
				<td></td>
			</tr>	
			<tr>
				<td colspan=4></td>
			</tr>
<?php 
	/*********** FINALIZAR CONTENIDO DE TABLA *********/
?>		

			<tr>
			<?php if($_SESSION['nivel']==5){ ?>
				<td colspan=4 align='center'>
					<table width='40%'>
						<tr>
							<td align='center'><button name="limpiar" type="submit">Nuevo<span>Limpia los controles para crear un nuevo registro</span></button></td>
							<td align='center'><button name="actualizar" type="submit">Actualizar<span>Actializa el registro en la base de datos</span></button></td>
							<td align='center'><button name="eliminar" type="submit">Borrar<span>Elimina permanentemente el registro</span></button></td>
						</tr>
					</table>
				</td>
			<?php } ?>	
			</tr>
		</table>
	</form> 
	</div>
	
	<?php
		if(!empty($__valor)){
			$query="SELECT * FROM ".$tabla_origen." WHERE {$__campo} LIKE '{$__valor}%' ORDER BY ".$__campo;
		}else{
			$query="SELECT * FROM ".$tabla_origen." ORDER BY ".$__campo;
		}
		$listaBean = array();
		$listaBean = $control->leerListaRegistros($query,clone $BeanUnico);
		echo "<div id='divLista'>";
		if(!empty($__valor)){
			setcookie("__campo", $__campo);
			setcookie("__valor", $__valor);		
		}
		echo "<form name='datosEl' id='datosEl' method='post' action='".$_SERVER['PHP_SELF']."'  accept-charset='UTF-8'> ";
		echo "<input type='hidden' name='__campo' value='{$__campo}' id='__campo' />";
		echo "<input type='hidden' name='__valor' value='{$__valor}' id='__valor' />";		
		echo "<table id='tablaLista'> \n"; 
		echo "<tr><th></th>";
		for ($i=0;$i<count($titulosTabla);$i++)
			echo "<th>{$titulosTabla[$i]}</th>";
		echo "</tr> \n"; 

		for ($k=0;$k<count($listaBean);$k++){ 
			$pTemp = clone $BeanUnico;
			$pTemp = $listaBean[$k];
			if (($k % 2)==0){
				$estilo="background:#ffffff;font-weight: normal;";
			}else{
				$estilo="background:#eeeeee;font-weight: normal;";
			}
			$selector="";
			if(isset($id)){
				if ($pTemp->__get('id')==$id){
					$selector="checked='checked'";
					$estilo="background:#ffff00;font-weight: bold;";
				}
			}
			echo "<tr style='{$estilo}'>";
			echo "<td align='center'><input type='radio' name='registro' value='{$pTemp->__get('id')}' onClick='javascript:document.datosEl.submit();' {$selector}/></td>";
			for ($i=0;$i<count($camposTabla);$i++)
				echo "<td>{$pTemp->__get($camposTabla[$i])}</td>";
			echo "</tr> \n"; 
		} 
		echo "</table>\n"; 
		echo "</form>\n"; 
		echo "</div>";
		mysql_close();
	?>	
    <script type="text/javascript">//<![CDATA[

					   
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() },
          showTime: false,
		  fdow : 7
      });
	  
      cal.manageFields("btn_finicio", "finicio", "%Y-%m-%d");
	  cal.manageFields("btn_ffinal", "ffinal", "%Y-%m-%d");
	  
	  // LISTA DE TODOS LOS CAMPOS FECHA ASI:
	  // "bnt_[nombre_campo_fecha]","[nombre_campo_fecha]"
	  // cal.manageFields("bnt_[nombre_campo_fecha]","[nombre_campo_fecha]", "%Y-%m-%d");

    //]]></script>
	</div>
	<footer id="divPie">
		<?php echo "...{$_SESSION['mensaje']}...";?>
	</footer>	
</body>
</html>