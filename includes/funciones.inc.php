<?php

#verificar si la sesión ha sido iniciada
function validarSesion(){

if (!$_SESSION['id_sesion']){
	header('Location: ../?error=true');
	}
}

#verificar si el usuario tiene el permiso de visualizar la página
function validarNivel($nivel){

if ($_SESSION['nivel']<$nivel){
	header('Location: 401.php');
	}
}

#manejo de error de validación
function error($error){

if ($error){
echo "<div id='mensaje'>Usted no se ha autenticado</div>";
	}

}

#nombre de la pagina actual
function paginaActual(){

$pagina=basename($_SERVER['PHP_SELF']);

return $pagina;

}

#colocar en mayúsculas sólo las palabras que tengan mas de $max caracteres
function may($valor){

$separador = strtok($valor, " ");

#longitud maxima de las palabras que no se van a colocar en mayúsculas
$max=3;

while($separador){
	$longitud=strlen($separador);
	if($longitud>$max){
		echo $palabra=ucwords($separador)." ";
		}else{
			echo $palabra=$separador." ";
			}
	$separador=strtok(" ");
	}

}

#colocar en mayúsculas sólo las palabras que tengan mas de $max caracteres
function mayusculas($valor){

$separador = strtok($valor, " ");

#longitud maxima de las palabras que no se van a colocar en mayúsculas
$max=3;

#palabras que no quiero se coloquen con la primera letra en mayúsculas (ucwords)
$GLOBALS['conectores']=array('Y'=>'y','De'=>'de', 'Del'=>'del', 'Para'=>'para', 'Como'=>'como', 'Con'=>'con', 'C/c'=>'c/c');

while($separador){
	$longitud=strlen($separador);
	echo strtr($palabra=ucwords($separador)." ",$GLOBALS['conectores']);
	$separador=strtok(" ");
	}

}

function colorearTabla(){
	
	#coloreamos la tabla
	$_SESSION['cuenta']++;
	$division=$_SESSION['cuenta']/2;
	$tipo=gettype($division);
				
	if($tipo=='integer'){
		echo "<tr id='tbl_sobre'>";
	}else if($tipo=='double'){
		echo "<tr id='tbl_sobre' class='tbl_gris'>";
	}
}

#función para devolver el primer nombre y apellido cuando existan 2
function explodeNombre($valor){
	$resultado=explode(" ",$valor);
	return ucwords($resultado[0]);
	}
	
#función para devolver un número con formato de "miles"
function miles($num){
	if($num){
		echo number_format($num, 0, '', '.');
		}else{
			echo $num;
		}
	}

#función para colocar los nombres de los meses en español 
#Formato: 20 de MES de 1978
function mesLargo($fecha){
	
	#formato de fecha día mes año
	$meses = array("January","February","March","April","May","June","July","August","September","October","November","December");

	$fecha_larga = new DateTime($fecha);
	$fecha_larga=$fecha_larga->format('d \d\e F \d\e Y');

	#Nombre de los meses en español
	if(strpos($fecha_larga,'January')){
		return str_replace($meses,'enero',$fecha_larga);
		}
	else if(strpos($fecha_larga,'February')){
		return str_replace($meses,'febrero',$fecha_larga);
		}
	else if(strpos($fecha_larga,'March')){
		return str_replace($meses,'marzo',$fecha_larga);
		}
	else if(strpos($fecha_larga,'April')){
		return str_replace($meses,'abril',$fecha_larga);
		}
	else if(strpos($fecha_larga,'May')){
		return str_replace($meses,'mayo',$fecha_larga);
		}
	else if(strpos($fecha_larga,'June')){
		return str_replace($meses,'junio',$fecha_larga);
		}
	else if(strpos($fecha_larga,'July')){
		return str_replace($meses,'julio',$fecha_larga);
		}
	else if(strpos($fecha_larga,'August')){
		return str_replace($meses,'agosto',$fecha_larga);
		}
	else if(strpos($fecha_larga,'September')){
		return str_replace($meses,'septiembre',$fecha_larga);
		}
	else if(strpos($fecha_larga,'October')){
		return str_replace($meses,'octubre',$fecha_larga);
		}
	else if(strpos($fecha_larga,'November')){
		return str_replace($meses,'noviembre',$fecha_larga);
		}
	else if(strpos($fecha_larga,'December')){
		return str_replace($meses,'diciembre',$fecha_larga);
		}
	}

#Función para colocar el formato de fecha DD-MM-AA 
#Formato 20-11-1978 (fecha_corta)
function mesCorto($fecha){
	
	$fecha_corta = new DateTime($fecha);
	$fecha_corta=$fecha_corta->format('d-m-Y');
	return $fecha_corta;
	
	}
