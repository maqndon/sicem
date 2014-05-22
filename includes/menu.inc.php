<?php

#----------------------------------------------------------------#
# Script para desarrollo de Sistemas Automatizados - Módulo Menú #
# Desarrollado por: Marcel Caraballo                             #
# mcaraballo@menpet.gob.ve caraballomh@pdvsa.com                 #
#----------------------------------------------------------------#

#funcion para crear el menu
function menu(){

#copiar todos los nombres de los enlaces separados por ","
#función htmlspecialchars para asegurar que los caracteres especiales sean mostrados correctamente en la página
$nombres = htmlspecialchars("inicio, embarcaciones, administración, soporte técnico, jtable");

#copiar todos los nombres de las páginas de los enlaces separados por ","
$enlaces = "inicio.php, buques.php, administracion.php, soporte.php, jtable.php";

#copiar todas las descripciones de los enlaces separados por ","
#función htmlspecialchars para asegurar que los caracteres especiales sean mostrados correctamente en la página
$detalles = htmlspecialchars("inicio del sistema, registro modificación y búsqueda de embarcaciones, administración del sistema,asistencia técnica del sistema de información, jtable");

#dependiendo del nivel del usuario en curso mostramos, o no, algunos enlaces
$nivel= "";

#función para crear arreglos que almacenan el nombre, archivo y descripción de cada uno de los enlaces
separador(nombre,$nombres);
separador(enlace,$enlaces);
separador(detalle,$detalles);

#llamamos a la función que creará el menú
crearMenu($GLOBALS["listado"],$GLOBALS["max"],$src);

}

#función que crea los tres arreglos nombre, enlace y detalle
function separador($clave,$valor){

#array principal que contiene todos los arreglos
$listado = array();

#con esto dividimos la cadena de caracteres que vamos a convertir en el arreglo
$separador = strtok($valor, ",");
#número de elementos en los arreglos
$max=0;

#llenamos los arreglos
while($separador){
	$max++;
	$listado[]=array("$clave" => trim($separador));
	$separador=strtok(",");
	}

#convertimos estas variables en globales
$GLOBALS["listado"][]=$listado;
$GLOBALS["max"]=$max;

}

#función para crear el menú y la leyenda
function crearMenu($listado,$max,$src){

#inicializamos en cero las variables del búcle
$j=0;
$i=0;

echo "<div id='menulateral'>";
echo "<ul>";

#búcle para los enlaces del menú
for ($i;$i<$max;$i++){
	for ($j;$j<$max;$j++){
		echo "<li>";
		echo "<div>";
		echo "<a href='".$listado[$i+1][$j][enlace]."'>".ucwords($listado[$i][$j][nombre])."</a>";
		echo "</div>";
		echo "</li>";
		}
	}

echo "</ul>";
echo "</div>";

#consultamos la pagina en la que nos encontramos
$pagina = paginaActual();

#si la pagina es inicio mostramos la leyenda
if ($pagina=="inicio.php"){

echo "<div id='leyenda'>";

$j=0;
$i=0;

#búcle para la leyenda del menú
for ($i;$i<$max;$i++){
	for ($j;$j<$max;$j++){
		echo "<div>";
		echo mayusculas($listado[$i+2][$j][detalle]);
		echo "</div>";
		}
	}

echo "</div>";

	}

}

?>
