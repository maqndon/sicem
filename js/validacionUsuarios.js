/***********************************************************\
| Desarrollado por: Marcel Caraballo						|
| mcaraballo@menpet.gob.ve caraballomh@pdvsa.com			|
| Dirección Regional Bolívar								|
| Dirección General de Mercado e Interno					|
| Ministerio del Poder Popular para la Energía y Petróleo	|
| Copyright 2014											|
\***********************************************************/

$(document).ready(function(){

	//jquery cambia el color del borde de los inputs
	$(":input").focus(function(){
		$(this).css({"border":"1px solid #959291"});
	});

	$(":input").blur(function(){
		$(this).css({"border":"1px solid #c3d9cc"});
		//si existe el div "mensaje" lo elimino 
		$("#mensaje").remove();
	});

});

function validarUsuario() {

//div definido en el formulario en donde vamos a colocar otro div con los mensajes de error
respuesta = document.getElementById("respuesta"); // omitimos el var para hacer de ésta una variable global

//variables del formulario de entrada al sistema
usuario = document.getElementById("usuario").value;
clave = document.getElementById("clave").value;

//div de los mensajes de error
var mensaje = document.getElementById("mensaje");

//comprobamos si los campos del formulario estan llenos
if (usuario==null || usuario.length==0 || /^\s+$/.test(usuario) ){

	//si no existe el div mensaje, lo creamos junto con el mensaje en si.
	if (!mensaje){
		addMensaje("el login");
		}else{
			mensaje.parentNode.removeChild(mensaje);
			addMensaje("el login");
			}
	return false;
	}

if (clave==null || clave.length==0 || /^\s+$/.test(clave) ){

	if (!mensaje){
		addMensaje("la clave");
		}else{
			mensaje.parentNode.removeChild(mensaje);
			addMensaje("la clave");
			}
	return false;
	}

	pasarVariables()

}

function addMensaje(tipo){

		var mensaje = document.createElement("div");
			mensaje.setAttribute('id','mensaje');
			mensaje.setAttribute('name','mensaje');
		var mensajeTexto = document.createTextNode("Disculpe, debe ingresar " + tipo + " de acceso");
		mensaje.appendChild(mensajeTexto);
		respuesta.appendChild(mensaje);

}

//formulario para pasar las variables al script php que hace la validación del usuario
function pasarVariables(){

//formulario
var formulario = document.createElement("form");
	formulario.setAttribute('method','post');
	formulario.setAttribute('action','./admin/validarUsuario.php');

//input user
var user = document.createElement("input");
	user.setAttribute('id','user');
	user.setAttribute('name','user');
	user.setAttribute('type','hidden');
	user.setAttribute('value',usuario);

//input contraseña
var pass = document.createElement("input");
	pass.setAttribute('id','pass');
	pass.setAttribute('name','pass');
	pass.setAttribute('type','hidden');
	pass.setAttribute('value',clave);

formulario.appendChild(user);
formulario.appendChild(pass);
respuesta.appendChild(formulario);
formulario.submit();

}
