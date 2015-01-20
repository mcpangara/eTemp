<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="es">
    <head>
        <title>Menú principal</title>
        <link rel=stylesheet type="text/css" href="estilos/estiloMenu.css">
    <body>
        <div class="marcoGeneral">
            <div class="cabecera"><center>
                <font color="blue" size="5"><?php echo $_SESSION['nempresa'];?></font><p>
            </center></div>
			<div>
            <form name="opcionMenu" method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>"  accept-charset="UTF-8">
                    <ul id="menu" >
                        <li><div class="estilo">DATOS</div>
                            <ul> 
								<li><a href='vista/personal/personal.php'>Personal</a></li>
								<li><a href='vista/cargo/cargo.php'>Cargo</a></li>
                                <li><div class="estilo2">Ordenes de Trabajo</div></li>
                            </ul>
                        </li>
                        <li><div class="estilo">PERSONAL</div>
                            <ul>
                                <li><div class="estilo2">Contrato</div></li>
                                <li><div class="estilo2">Generar Prenómina</div></li>
                                <li><div class="estilo2">Consultar Prenómina</div></li>
                            </ul>
                        </li>						
                        <li><div class="estilo">FACTURACION</div>
                            <ul> 
                                <li><div class="estilo2">Reporte Diario</div></li>
                                <li><div class="estilo2">Reporte Mensual</div></li>
                                <li><div class="estilo2">Dotacion</div></li>
                                <li><div class="estilo2">Remision</div></li>
                            </ul>
                        </li>
                        <li><div class="estilo">OPCIONES</div></li>
						<li><div class="estilo">TERMINAR</div></li>
                        <li><a href='login.html'>TERMINAR</a></li>
                    </ul>   
                <input type="hidden" name="opcion" value="">
            </form>
			</div>
        </div>	
  </head>
 </body>
</html>
