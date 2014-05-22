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
