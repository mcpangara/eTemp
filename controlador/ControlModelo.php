<?php
class Conexion{
	private $host;
	private $clave;
	private $usuario;
	private $bd;
	
	public $_usuarioActual;
	public $_nivelActual;

	public function __construct($host="localhost",$usuario="root",$clave="",$bd="ereporte"){
		$this->host=$host;
		$this->usuario=$usuario;
		$this->clave=$clave;
		$this->bd=$bd;
	}
	
	public function coneccionDefecto(){
		if (!$con=mysql_connect($this->host,$this->usuario,$this->clave))
			echo die ("Ocurrio el siguiente Error: ".mysql_errno());
		if(!$basedatos=mysql_select_db($this->bd,$con))
			echo die ("Ocurrio el siguiente Error: ".mysql_errno());
		return $con;
	}

	public function ejecutarQuery($query){
		$con= new Conexion();
		$resultados;
		$conecion=$con->coneccionDefecto();
		$resp=mysql_query($query,$conecion)or die (mysql_errno()) ;
		while($resultados=mysql_fetch_array($resp,MYSQL_BOTH)){
			$resul[]=$resultados;
		}	
		if(empty($resul))
			echo die ("No hay resultados");
		return  $resul;
	}
	
	public function ejecutar($query){
		$con= new Conexion();
		$conecion=$con->coneccionDefecto();
		$resp=mysql_query($query,$conecion) ;
		if(!$resp)
			echo "error:".mysql_errno();
	}

	public function validarIngreso($_usuario,$_clave,$_correo){
		$this->_usuarioActual=0;
		$this->_nivelActual=0;

		$con= new Conexion();
		$query="SELECT idusuario,nivel FROM usuario WHERE username='{$_usuario}' and email='{$_correo}' and AES_DECRYPT(password,identificacion)='{$_clave}'";
		$conecion=$con->coneccionDefecto();
		$resp=mysql_query($query,$conecion);
		if ($resp){
			$resultado = mysql_fetch_row($resp) or die ("Error en: {$query}: ".mysql_errno()) ;
			$this->_usuarioActual = $resultado[0];
			$this->_nivelActual = $resultado[1];
		}
	}
	
	public function leerListaRegistros($query,$bean){
		$resul = array();
		$con = new Conexion();
		$resultados;
		$conecion = $con->coneccionDefecto();
		$resp = mysql_query($query,$conecion)or die (mysql_errno()) ;
		while($resultados = mysql_fetch_array($resp,MYSQL_BOTH)){
			$bean2 = clone $bean;
			$nCampos = mysql_num_fields($resp);
			for ($i=0;$i<$nCampos;$i++){
				$_campo = mysql_field_name($resp, $i);
				$bean2->__set($_campo,$resultados[$_campo]);
			}	
			$resul[]=$bean2;
		}	
		return  $resul;
	}

	public function leerRegistro($query,$bean){
		$con= new Conexion();
		$resultadoBean=clone $bean;
		$conecion=$con->coneccionDefecto();
		$resp=mysql_query($query,$conecion)or die (mysql_errno()) ;
		if($resultado=mysql_fetch_array($resp,MYSQL_BOTH)){
			$bean2 = clone $bean;
			$nCampos = mysql_num_fields($resp);
			for ($i=0;$i<$nCampos;$i++){
				$_campo = mysql_field_name($resp, $i);
				$bean2->__set($_campo,$resultado[$_campo]);
			}	
			$resultadoBean=$bean2;
			//echo "id[{$resultadoBean->__get('id')}]<br>";
		}
		return  $resultadoBean;
	}	
	
	public function leerCaracteristicas($tabla,$bean){
		$caracteristicas[][]="";
		$con= new Conexion();
		$query="SELECT * FROM {$tabla}";
		$conecion=$con->coneccionDefecto();
		$resp=mysql_query($query,$conecion)or die (mysql_errno()) ;
		if($resultado=mysql_fetch_array($resp,MYSQL_BOTH)){
			$bean2 = clone $bean;
			$nCampos = mysql_num_fields($resp);
			for ($i=0;$i<$nCampos;$i++){
				$_campo = mysql_field_name($resp, $i);
				$_tipo  = mysql_field_type($resp, $i);
				$_largo = mysql_field_len($resp, $i);
			
				$caracteristicas[$_campo]["tipo"]=$_tipo;
				$caracteristicas[$_campo]["largo"]=$_largo;
				$_html="";

				if ($_tipo=="int" && $_largo>1){
					$_html="<INPUT type='text' name='{$_campo}' id='{$_campo}' value='".$bean2->__get("{$_campo}")."' size={$_largo} maxlength={$_largo} placeholder='{$_campo}' />\n";
				}else{
					if($_tipo=="string"){
						$_html="<INPUT type='text' name='{$_campo}' id='{$_campo}' value='".$bean2->__get("{$_campo}")."' size={$_largo} maxlength={$_largo} placeholder='{$_campo}' />\n";
					}else{
						if($_tipo=="date"){
							$_html="<INPUT type='text' name='{$_campo}' id='{$_campo}' value='{$bean2->__get($_campo)}' size={$_largo} maxlength={$_largo} placeholder='{$_campo}' />";
							$_html=$_html."<img src='../../iconos/calendario.gif' alt='Seleccionar Fecha' id='btn_{$_campo}' />\n";	
						}else{
							if(($_tipo=="int" && $_largo==1) || $_tipo=="boolean"){
								//$_html="<INPUT TYPE='checkbox' name='{$_campo}' id='{$_campo}' value='{$bean2->__get($_campo)}' />\n";
								$_html ="<select name='{$_campo}'>\n";
								$_html.="   <option value=0 ";
								if ($bean2->__get($_campo)==0)
									$_html.="Selected";
								$_html.=">No</option>\n";
								$_html.="   <option value=1 ";
								if ($bean2->__get($_campo)!=0)
									$_html.="Selected";
								$_html.=">Si</option>\n";
								$_html.="</select>\n";
							}else{
								$_html="<INPUT type='text' name='{$_campo}' id='{$_campo}' value='".$bean2->__get("{$_campo}")."' size={$_largo} maxlength={$_largo} placeholder='{$_campo}' />\n";
								//$_html="\n";
							}
						}
					}
				}
				$caracteristicas[$_campo]["html"]=$_html;
				//echo "html: {$_html}<br>";
			}	
		}

		return  $caracteristicas;
	}	
	
	
	public function actualizarRegistroStr($miclase,$tabla){
		//$vars_campo = get_class_vars(get_class($miclase));
		$cadena = "UPDATE {$tabla} SET ";
		$condicion ="WHERE (";
		$vars_valor = get_object_vars($miclase);
		$cantidad = count($vars_valor);
	    $i=1;
		foreach($vars_valor as $var => $value) {
			if ($var!='id'){
				$cadena .= $var."='".$value."' ";
				if ($i!=$cantidad)
					$cadena .= ",";
			}else{
				$condicion .= "{$var}={$value})";
			}
			$i++;
		}
		$cadena .= $condicion;
		//echo $cadena;
		return $cadena;
	}

	public function insertarRegistroStr(&$miclase,$tabla){
		$cadena = "INSERT INTO {$tabla} ";
		$vars_valor = get_object_vars($miclase);
		$cantidad = count($vars_valor);
	    $i=1;
		$campos="(";
		$valores="(";
		foreach($vars_valor as $var => $value) {
			if ($var!='id'){
				$campos .= $var;
				$valores .= "'".$value;
				if ($i!=$cantidad){
					$campos .= ", ";
					$valores .= "', ";
				}else{
					$campos .= ") ";
					$valores .= "') ";
				}	
			}
			$i++;
		}
		$cadena .= $campos." VALUES ".$valores;
		//echo $cadena;
		return $cadena;
	}	

	public function crearExcel($query,$bean){
		$resul = array();
		$con = new Conexion();
		$resultados;
		$conecion = $con->coneccionDefecto();
		$resp = mysql_query($query,$conecion)or die (mysql_errno()) ;
		while($resultados = mysql_fetch_array($resp,MYSQL_BOTH)){
			$bean2 = clone $bean;
			$nCampos = mysql_num_fields($resp);
			for ($i=0;$i<$nCampos;$i++){
				$_campo = mysql_field_name($resp, $i);
				$bean2->__set($_campo,$resultados[$_campo]);
			}	
			$resul[]=$bean2;
		}	
		return  $resul;
	}	
	
	public function getExcel($query,$bean,$nombreArchivo){
		include("../../controlador/excelwriter.inc.php");
		$nombreArchivo = "../../excel/{$nombreArchivo}.xls";
		$excel=new ExcelWriter($nombreArchivo);
		$con = new Conexion();
		$resultados;
		$conecion = $con->coneccionDefecto();
		$resp = mysql_query($query,$conecion)or die (mysql_errno()) ;
		$encabezado=true;
		while($resultados = mysql_fetch_array($resp,MYSQL_BOTH)){
			$nCampos = mysql_num_fields($resp);
			if ($encabezado){
				$excel->writeRow();
				for ($i=0;$i<$nCampos;$i++){
					$_campo = mysql_field_name($resp, $i);
					if ($_campo!="idusuario" and $_campo!="fechaactualiza" and $_campo!="id")
						$excel->writeCol($_campo);
				}
				$encabezado=false;
			}	
			$excel->writeRow();
			for ($i=0;$i<$nCampos;$i++){
				$_campo = mysql_field_name($resp, $i);
				if ($_campo!="idusuario" and $_campo!="fechaactualiza" and $_campo!="id")
					$excel->writeCol($resultados[$_campo]);
			}
		}	
		$excel->close();
	}
	
	public function getListaSeleccion($_campo,$_valor,$_lista,$_rotulo){
		$strSelect="\n{$_rotulo} <select name='{$_campo}'>\n";
		for ($i=0;$i<count($_lista);$i++){
			$strSelect.="<option value='{$_lista[$i]}' ";
			if ($_lista[$i]==$_valor)
				$strSelect.="selected";
			$strSelect.=">{$_lista[$i]}</option> \n";	
		}
		$strSelect.="</select>\n";
		return $strSelect;
	}
}
?>
