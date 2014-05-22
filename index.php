<?php

#incluimos funciones y clases
include './includes/funciones.inc.php';
include './includes/class_lib.php';

#destruimos cualquier sesion que este activa
session_start();
session_destroy();

$error=$_GET['error'];

$pagina=new paginaActual($_SERVER['PHP_SELF']);
$carpetaImagenes=new carpetasSistema($_SERVER['PHP_SELF']);
$carpetaCss=new carpetasSistema($_SERVER['PHP_SELF']);
$carpetaJs=new carpetasSistema($_SERVER['PHP_SELF']);
$encabezado=new sistema($_SERVER['PHP_SELF']);
$gobierno=new sistema($_SERVER['PHP_SELF']);
$nombreSis=new sistema($_SERVER['PHP_SELF']);
$bienvenida=new sistema($_SERVER['PHP_SELF']);
$copyrights=new sistema($_SERVER['PHP_SELF']);
$validacion=new validacion();
$validarNavegador=new navegador();

?>

<!-- cabeceras xhtml -->
<?php $encabezado->getCabeceras($carpetaImagenes->getCarpeta(imagenes));?>

<style type="text/css" media="screen">
  @import '<?= $carpetaCss->getCarpeta(estilos);?>gobierno.css';
  @import '<?= $carpetaCss->getCarpeta(estilos);?>index.css';
</style>

<script type="text/javascript" src="<?= $carpetaJs->getCarpeta(javascript);?>jquery.js"></script>
<script type="text/javascript" src="<?= $carpetaJs->getCarpeta(javascript);?>validacionUsuarios.js"></script>
<script type="text/javascript" src="<?= $carpetaJs->getCarpeta(javascript);?>validacionCorreo.js"></script> 
<script type="text/javascript" src="<?= $carpetaJs->getCarpeta(javascript);?>restaurarClave.js"></script>

</head> <!-- la etiqueta de apertura <head> esta en la funcion php "cabeceras()" -->

<body>

<div id="contenedor">

<!-- imagen de la institucion -->
<?php $gobierno->getGobierno($carpetaImagenes->getCarpeta(imagenes)); ?>

<!-- nombre del sistema -->
<?php $nombreSis->getNombreSistema();?>

<div id="bienvenida"></div>

  <div id="marco"> <!-- marco del sistema -->

    <?php $validacion->validar(); ?>
    
    <?php $validarNavegador->getNavegador(); ?>

  </div> <!-- FIN DIV marco -->

<!-- derechos del sistema -->
<?php $copyrights->getDerechos($carpetaImagenes->getCarpeta(imagenes)); ?>

</div> <!-- FIN contenedor -->

</body>
</html>
