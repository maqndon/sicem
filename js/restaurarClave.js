/***********************************************************\
| Desarrollado por: Marcel Caraballo						|
| mcaraballo@menpet.gob.ve caraballomh@pdvsa.com			|
| Sala Situacional											|
| Dirección Regional Bolívar								|
| Dirección General de Mercado Interno						|
| Ministerio del Poder Popular para la Energía y Petróleo	|
| Copyright 2010											|
\***********************************************************/

$(document).ready(function(){

	//ocultamos el Div que contiene el formulario para recuperar la contraseña
	$("#claveDiv").hide();

	//al hacer click en el enlace mostramos el Div para recuperar la contraseña
	$("#restaurarClave").focus(function(){
		$("#claveDiv").show();
	});

	//en el formulario para recuperar la contraseña existe un link para volver
	$("#volver").click(function(){
		$("#claveDiv").hide();
	});

});
