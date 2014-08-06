/***********************************************************\
| Desarrollado por: Marcel Caraballo												|
| mcaraballo@menpet.gob.ve caraballomh@pdvsa.com						|
| Planificación y Gestión																		|
| Dirección Regional Bolívar																|
| Dirección de Ficalización e Inspección										|
| Ministerio del Poder Popular para la Energía y Petróleo		|
| Copyright 2010																						|
\***********************************************************/

$(document).ready(function(){
	//si existe el mensaje de alerta por no colocar un correo válido, lo eliminados
	$("#correo").click(function(){
		//si existe el div "mensaje" lo elimino 
		$("#mensajeEmail").remove();
	});

});

function validarCorreo() {

//div definido en el formulario en donde vamos a colocar otro div con los mensajes de error
respuesta = document.getElementById("mensajeCorreo"); // omitimos el var para hacer de ésta una variable global

//variables del formulario de entrada al sistema
correo = document.getElementById("correo").value;

//div de los mensajes de error
var mensaje = document.getElementById("mensajeEmail");

//comprobamos si los campos del formulario estan llenos
if( !(/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(correo)) ) {

	//si no existe el div mensaje, lo creamos junto con el mensaje en si.
	if (!mensaje){
		addMensajeCorreo();
		}else{
			mensaje.parentNode.removeChild(mensaje);
			addMensajeCorreo();
			}
	return false;
	}

	pasarCorreo()

}

function addMensajeCorreo(tipo){

		var mensaje = document.createElement("div");
			mensaje.setAttribute('id','mensajeEmail');
			mensaje.setAttribute('name','mensajeEmail');
		var mensajeTexto = document.createTextNode("Disculpe, debe ingresar un correo válido");
		mensaje.appendChild(mensajeTexto);
		respuesta.appendChild(mensaje);

}

//formulario para pasar las variables al script php que hace la validación del usuario
function pasarCorreo(){

//formulario
var formulario = document.createElement("form");
	formulario.setAttribute('method','post');
	formulario.setAttribute('action','./admin/recuperarClave.php');

//input correo
var email = document.createElement("input");
	email.setAttribute('id','correo');
	email.setAttribute('name','correo');
	email.setAttribute('type','hidden');
	email.setAttribute('value',correo);

formulario.appendChild(email);
respuesta.appendChild(formulario);
formulario.submit();

}
