<?php

#------------------------------------------------------------------------------#
# Script para desarrollo de Sistemas Automatizados - Módulo Diseño del Sistema #
# Desarrollado por: Marcel Caraballo                                           #
# mcaraballo@menpet.gob.ve caraballomh@pdvsa.com                               #
#------------------------------------------------------------------------------#

#carpetas utilizadas en el sistema
$carpetas=array(
	"imagenes" => "imagenes", 		#imagenes del sistema
	"javascript" => "js", 			#script de validaciones
	"estilos" => "css", 			#hojas de estilo
	"directorio" => "admin", 		#directorio de trabajo
	"includes" => "includes", 		#includes del sistema
	"jtable"=> "jtable", 			#jtable
);

#nombre del archivo del "favicon" o icono del sistema en la barra de navegación
$favicon="favicon32x32"; # se puede omitir la extensión del archivo "favicon32x32.ico"

#directorio en donde se encuentra instalado el sistema
$directorioSistema="sicem";

#nombre de la imagen del encabezado principal del sistema
$imagenInstitucion='bandera.png'; # se puede omitir la extensión del archivo "gobierno.png"
$instWidth="51"; #ancho de la imagen, si la imagen ocupa todo el ancho de la página esta variable debe tener un valor de 800 como en la línea comentada abajo
#$instWidth="800"; #si la imagen ocupa todo el ancho de la página se debe descomentar esta línea y comentar las líneas indicadas en la funcion "gobierno" mas abajo
$instHeight="59"; #alto de la imagen

$imagenAnual='logo.png';
$anualHeight='78';
$anualWidth='85';

#descomentar si estamos utilizando un encabezado completo
#en caso de que falle la carga del encabezado mostramos el nombre de la institución
#$nombreInstitucion='Gobierno Bolivariano de Venezuela | Ministerio del Poder Popular para la Energ&iacute;a y Petr&oacute;leo';

#nombre del sistema
$nombreSistema="Sistema de Control de Embarcaciones Menores";
#tamaño de letra de 1 hasta 6 (el valor mas alto es el 1)
$tamLetra='2';

#año en curso
$anio=date(Y);

#derechos del sistema
$derechos="&copy; Copyright ".$anio." - Ministerio del Poder Popular de Petr&oacute;leo y Miner&iacute;a - Todos los Derechos Reservados.";
#continuacion de los derechos del sistema
#$derechosCont="Direcci&oacute;n General de Fiscalizaci&oacute;n e Inspecci&oacute;n | Direcci&oacute;n Regional Bol&iacute;var.";
$derechosCont="Direcci&oacute;n General de Mercado Interno - Direcci&oacute;n Regional Bol&iacute;var";

#codificación de caracteres
$charset='utf-8';

#idioma del sistema
$idioma='es';

#enlace del link Olvido su Contraseña?
$olvidoClave=$carpetas[directorio];
$olvidoClave.='/restaurarClave.php';

#descomentar la línea de abajo para agregar otra carpeta al sistema y colocar la referencia y el nombre de la carpeta $carpetas['referencia']='nombredelacarpeta';
#$carpetas['']=''; #colocar la referencia y el nombre de la carpeta

#normalizacion de caracteres especiales para las direcciones URL
$GLOBALS['caracteres'] = array(
    'Á'=>'A', 'Â'=>'A', 'É'=>'E', 'Í'=>'I', 'Ñ'=>'N', 'Ó'=>'O', 'Ú'=>'U',
    'Ü'=>'U', 'á'=>'a', 'é'=>'e', 'í'=>'i', 'ñ'=>'n', 'ó'=>'o', 'ú'=>'u',
    'ü'=>'u','&ntilde;'=>'n', '&Ntilde;'=>'N', '&aacute;'=>'a','&Aacute;'=>'A',
    '&eacute;'=>'e','&Eacute;'=>'E', '&iacute;'=>'i', '&Iacute;'=>'I',
    '&oacute;'=>'o','&Oacute;'=>'O', '&uacute;'=>'u','&Uacute;'=>'U',
    '&uuml;'=>'u','&Uuml;'=>'U',
    );

#clase principal de estilos del sistema
class sistema{

#	function __construct($nuevoSistema){
#		$this->pagina=$nuevoSistema;
#	}

	#cabeceras del documento xhtml
	function getCabeceras($imagenes){

		global $nombreSistema, $favicon, $charset, $idioma;

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$idioma.'" lang="'.$idioma.'">';
		echo '<head>';
		echo '<title>'.$nombreSistema.'</title>';
		echo '<meta http-equiv="content-type" content="text/html;charset='.$charset.'" />';
		echo '<meta http-equiv="Content-Style-Type" content="text/css" />';
		echo '<link rel="icon" href="'.$imagenes.$favicon.'" type="image/x-icon">';
		echo '<link rel="shortcut icon" href="'.$imagenes.$favicon.'" type="image/x-icon">';

	}

	#encabezado principal del sistema
	function getGobierno($imagenes){

		global $imagenInstitucion,$nombreInstitucion,$instWidth,$instHeight,$imagenAnual,$anualHeight,$anualWidth;

		echo '<div id="gobierno">';
		echo '<div>';
		echo '<img src="'.$imagenes.$imagenInstitucion.'" alt="'.$nombreInstitucion.'" width="'.$instWidth.'" height="'.$instHeight.'" />';
		echo '</div>';
		# si se coloca un encabezado del ancho de la página se deben comentar todas estas líneas hasta el signo # menos el último cierre </div>
		echo '<div id="gob">';																														#<--de aquí
		echo '<div id="bolivariano" class="encabezadoGob"><font class="gris">Gobierno</font> <font class="grisBold">Bolivariano</font></div>';		#
		echo '<div class="encabezadoGob"><font class="gris">de Venezuela</font></div>';																#
		echo '</div>';																																#
		echo '<div id="bar">';																														#
		echo '<div class="encabezadoBarra"><spam class="grisBold">|</spam></div>';																	#
		echo '</div>';																																#
		echo '<div id="min">';																														#
		echo '<div id="popular" class="encabezadoMin"><font class="gris">Ministerio del Poder Popular</font></div>';								#
		echo '<div class="encabezadoMin"><font class="gris">de</font><font class="grisBold"> Petr&oacute;leo y Miner&iacute;a</font></div>';	#
		echo '</div>';																																#
		echo '<div id="segbar">';																													#
		echo '<div class="encabezadoBarra"><spam class="grisBold">|</spam></div>';																	#
		echo '</div>';																																#
		echo '<div id=vicmin>';																														#
		echo '<div class="encabezadoMin"><font class="gris">Viceministerio de</font></div>';														#
		echo '<div class="encabezadoMin"><font class="grisBold">Hidrocarburos</font></div>';														#
		echo '</div>';																																#
		echo '<div id="terbar">';																													#
		echo '<div class="encabezadoBarra"><spam class="grisBold">|</spam></div>';																	#
		echo '</div>';																																#
		echo '<div id=dgmi>';																														#
		echo '<div class="encabezadoMin"><font class="gris">Direcci&oacute;n General de</font></div>';												#
		echo '<div class="encabezadoMin"><font class="grisBold">Mercado Interno</font></div>';								#
		#echo '<div class="encabezadoMin"><font class="grisBold">Fiscalizaci&oacute;n e Inspecci&oacute;n</font></div>';
		echo '</div>';																																#<--hasta aquí
		echo '<div id="logo">';	
		echo '<img src="'.$imagenes.$imagenAnual.'" width="'.$anualWidth.'" height="'.$anualHeight.'" />';
		echo '</div>';
		echo '</div>';

	}

	#nombre del sistema
	function getNombreSistema(){

		global $nombreSistema, $tamLetra;

		echo '<div id="sistema">';
		echo "<h".$tamLetra.">".$nombreSistema."</h".$tamLetra.">";
		echo '</div>';

	}

	#bienvenida y ruta del sistema
	function getBienvenida(){

		$nombres=explodeNombre($_SESSION['nombres']);
		$apellidos=explodeNombre($_SESSION['apellidos']);
		$nivel=$_SESSION['nivel'];

		if($nivel==2){
			echo '<div id="bienvenida">';
			echo "<strong>Bienvenid@: </strong>".$nombres." ".$apellidos." - <spam class='rojo'>Administrador</spam>";
			echo '</div>';
			}else{
				echo '<div id="bienvenida">';
				echo "<strong>Bienvenid@: </strong>".$nombres." ".$apellidos;
				echo '</div>';
		}

	}

	#derechos del sistema
	function getDerechos($src){

		global $derechos,$derechosCont;

		echo "<div id='derechos'>";		echo "<p>".$derechos."</p>";		echo "<p>".$derechosCont."</p>";		echo "<p>";		echo "<a href='http://validator.w3.org'>";		echo "<img src='".$src."valid-xhtml10-blue.png' alt='Valid XHTML 1.0 Strict' width='88' height='31' />";		echo "</a>";
		echo "<a href='http://jigsaw.w3.org/css-validator/check/referer'>";
		echo "<img style='border:0;width:88px;height:31px' src='".$src."vcss-blue.gif' alt='CSS V&aacute;lido!' />";
		echo "</a>";
		echo "<a href='http://www.php.net/'>";		echo "<img src='".$src."PHP_Logo.png' alt='PHP' height='31' />";		echo "</a>";
		echo "<a href='http://www.postgresql.org/'>";		echo "<img src='".$src."Pg_logo.png' alt='PostgreSQL' height='31' />";		echo "</a>";
		echo "</p>";		echo "</div>";

	}

}

#creamos las variables de la sesion
class sesionActiva{
	
	function getSession(){
		#creamos las variables de sesion dependiendo de quien se logeo en el sistema
		$_SESSION['id_sesion']=$usuario;
		$_SESSION['nombres']=$resultado['nombres'];
		$_SESSION['clave']=$resultado['clave'];
		$_SESSION['apellidos']=$resultado['apellidos'];
		$_SESSION['cedula']=$resultado['ced'];
		$_SESSION['cargo']=$resultado['cargo'];
		$_SESSION['tel']=$resultado['tel'];
		$_SESSION['cel']=$resultado['cel'];
		$_SESSION['oficina']=$resultado['oficina'];
		$_SESSION['direccion']=$resultado['direccion'];
		$_SESSION['nivel']=$resultado['nivel'];
		$_SESSION['cuenta']=0;
		$_SESSION['fecha']=getdate();
		$_SESSION['hora']=gettimeofday();
		$_SESSION['navegador']=get_browser(null, true);
		if($_SERVER['HTTP_X_FORWARDED_FOR']):
		$_SESSION['ip']=$_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif($_SERVER['HTTP_CLIENT_IP']):
		$_SESSION['ip']=$_SERVER['HTTP_CLIENT_IP'];
		else:
		$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
		endif;
		header("Location: inicio.php");
	}
}

#clase para verificar la página actual del sistema
class paginaActual{

	function __construct($pagina){
		$this->pagina=basename($pagina);
	}

	public function getPagina(){
		return $this->pagina;
	}

	protected function setPagina($newPagina){
		$this->pagina($newPagina);
	}

}

#clase para generar la ruta de la carpeta en la cual se encuentran los distintos archivos del sistema
class carpetasSistema extends paginaActual{

	function getCarpeta($carpeta){
		global $carpetas;
		if ($this->pagina=='index.php'){
			return './'.$carpetas[$carpeta].'/';
			}else{
				return '../'.$carpetas[$carpeta].'/';
			}
	}

}

class validacion{

	function validar(){

		global $error,$olvidoClave;

echo <<< HTML
		<div id="validacion">
			<div>
				<h3 class="centrado">Autenticaci&oacute;n</h3>
			</div>

		<form method="post"/>
			<div>
				<label for="usuario">Usuario:</label>
				<input type="text" id="usuario" name="usuario" size="15"/>
			</div>
			<div>
				<label for="clave">Contrase&ntilde;a:</label>
				<input type="password" id="clave" name="clave" size="15"/>
			</div>
			<div id="respuesta">
HTML;
	error($error);
echo <<< HTML
			</div>
			<div id="opciones">
				<a href="" class="center" id='restaurarClave'>&iquest;Olvido su clave?</a>
			</div>
			<div class="centrado">
				<input class="boton" type="button" value="Ingresar" onclick="validarUsuario()" />
			</div>
			</form>
		</div> <!-- FIN validacion -->

		<div id="claveDiv">
			<div>
				<div class="pading">
					<p>Ingrese su direcci&oacute;n de correo electr&oacute;nico:</p>
				</div>
				<!-- <label for="correo">Correo:</label> -->
				<!-- <form method="post"> -->
				<div class="pading">
					<input id="correo" name="correo" size="22">
				</div>
				<div id="mensajeCorreo">
				</div>
				<div class="pading">
					<input class="boton" type="button" value="Solicitar Nueva Contrase&ntilde;a" onclick="validarCorreo()" name="solicitarCorreo"/>
				</div>
				<!-- <a href='./admin/recuperarClave.php'>Solicitar Nueva Contrase&ntilde;a</a> -->
				<!-- </form> -->
				<a href='' id="volver">Volver</a>
			</div>
		</div> <!-- FIN restaurar clave -->
HTML;
	}

}

class navegador{
	
	function getNavegador(){
	$this->navegador=get_browser(null, true);
	$this->navegador=$this->navegador[browser];
	#return $this->navegador;
	if($this->navegador=='xxx'){
	echo $this->navegador;	
echo <<< HTML
	<div id="navegador">Este Sistema ha sido desarrollado para utilizarse con Mozilla Firefox o navegadores compatibles como Iceweasel</div>
HTML;
		}
	}
	
}
	
#clase para formatear la hora de cierre y apertura
class Hora{

	function __construct($hora){
		$this->hora=substr($hora, 0, 5);
		$this->comparacion=substr($hora, 0, 2);
		$this->minutos=substr($hora, 3, 2);
	}

	public function getHora(){
		if($this->comparacion<12){
			return $this->hora.' am';
			}else if($this->comparacion==12){
				return $this->hora.' m';
				}else{
				switch($this->hora){
					case 13:
					return '01:'.$this->minutos.' pm';
					break;
					case 14:
					return '02:'.$this->minutos.' pm';
					break;
					case 15:
					return '03:'.$this->minutos.' pm';
					break;
					case 16:
					return '04:'.$this->minutos.' pm';
					break;
					case 17:
					return '05:'.$this->minutos.' pm';
					break;
					case 18:
					return '06:'.$this->minutos.' pm';
					break;
					case 19:
					return '07:'.$this->minutos.' pm';
					break;
					case 20:
					return '08:'.$this->minutos.' pm';
					break;
					case 21:
					return '09:'.$this->minutos.' pm';
					break;
					case 22:
					return '10:'.$this->minutos.' pm';
					break;
					case 23:
					return '11:'.$this->minutos.' pm';
					break;
					case 24:
					return '12:'.$this->minutos.' pm';
					break;
				}
		}
		
	}

}

?>
