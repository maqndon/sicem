<?php

require_once('../includes/conexion.inc.php');
require_once('../includes/odtPHP/odf.php');
require_once('../includes/fpdf/fpdf.php');
require_once('../includes/fpdi/fpdi.php');
require_once('../includes/funciones.inc.php');

$matricula=$_REQUEST['matricula'];

/*
$dia=date(d);
$mes=date(m);
$anio=date(Y);
$fechaActual=$dia."-".$mes."-".$anio;
*/

#Datos del Registro
$registro="SELECT tbl_registro.num_ofic as num_oficio, upper(tbl_registro.cod) as cod_reg, tbl_registro.fecha_sol as fecha_sol, initcap(tbl_ciudad.nombre) as ciudad_registro FROM tbl_registro,tbl_ciudad WHERE matricula=lower('".$_REQUEST["matricula"]."') AND tbl_ciudad.id_cdad=tbl_registro.ciudad";
$consultaRegistro=pg_query($registro);
$resultadoRegistro=pg_fetch_assoc($consultaRegistro);

$num_oficio=$resultadoRegistro['num_oficio'];
$cod_reg=$resultadoRegistro['cod_reg'];
$cdadReg=$resultadoRegistro['ciudad_registro'];
$fecha_sol_larga=mesLargo($resultadoRegistro['fecha_sol']);

#Datos de la embarcación
$buque="SELECT upper(tbl_buques.nombre) as nombre_buque, initcap(tbl_buques.bandera) as bandera, tbl_buques.fecha_irn as fechaIRN, tbl_buques.fecha_insp, initcap(tbl_actividad.nombre) as actividad, initcap(tbl_uso.nombre) as uso, initcap(tbl_tipo.nombre) as tipo_buque, initcap(tbl_ciudad.nombre) as ciudad_buque FROM tbl_buques, tbl_actividad,tbl_uso,tbl_tipo,tbl_ciudad WHERE matricula=lower('".$_REQUEST["matricula"]."') AND tbl_actividad.id=tbl_buques.actividad AND tbl_uso.id=tbl_buques.uso AND tbl_tipo.id=tbl_buques.tipo AND tbl_ciudad.id_cdad=tbl_buques.ciudad";
$consultaBuque=pg_query($buque);
$resultadoBuque=pg_fetch_assoc($consultaBuque);

$nombre_buque=$resultadoBuque['nombre_buque'];
$bandera=$resultadoBuque['bandera'];
$ciudad_buque=$resultadoBuque['ciudad_buque'];
$fechaIRN=mesLargo($resultadoBuque['fechaIRN']);
$fecha_insp=$resultadoBuque['fecha_insp'];
$uso=$resultadoBuque['uso'];
$actividad=$resultadoBuque['actividad'];
$tipo_buque=$resultadoBuque['tipo_buque'];

#Datos del Propietario
$propietario="SELECT initcap(tbl_propietarios.nombres) as nombres_pro, initcap(tbl_propietarios.apellidos) as apellidos_pro,initcap(tbl_pro_resp.tipo) as condicion, initcap(tbl_propietarios.ced) as cedula_pro FROM tbl_propietarios, tbl_buques_pro_repre, tbl_pro_resp WHERE matricula=lower('".$_REQUEST["matricula"]."') AND tbl_propietarios.ced=tbl_buques_pro_repre.ced_pro AND tbl_pro_resp.id=tbl_propietarios.tipo";
$consultaPropietario=pg_query($propietario);
$resultadoPropietario=pg_fetch_all($consultaPropietario);

#$nombres_pro=$resultadoPropietario[0]['nombres_pro'];
#$apellidos_pro=$resultadoPropietario[0]['apellidos_pro'];
$condicion=$resultadoPropietario[0]['condicion'];
$cedula_pro=$resultadoPropietario[0]['cedula_pro'];

#Datos del Representante Legal
$representanteLegal="SELECT initcap(tbl_propietarios.nombres) as nombres_pro, initcap(tbl_propietarios.apellidos) as apellidos_pro,initcap(tbl_pro_resp.tipo) as condicion, initcap(tbl_propietarios.ced) as cedula_pro FROM tbl_propietarios, tbl_buques_pro_repre, tbl_pro_resp WHERE matricula=lower('".$_REQUEST["matricula"]."') AND tbl_propietarios.ced=tbl_buques_pro_repre.ced_pro AND tbl_pro_resp.id=tbl_propietarios.tipo AND tbl_propietarios.tipo='1'";
$consultaRepresentanteLegal=pg_query($representanteLegal);
$resultadoRepresentanteLegal=pg_fetch_all($consultaRepresentanteLegal);

#si existe un único propietario sería el mismo representante legal
if($condicion='Propietario'){
		$nombresREPRE=$resultadoPropietario[0]['nombres_pro']." ".$resultadoPropietario[0]['apellidos_pro'];
		}else{
		$nombresREPRE=$resultadoRepresentanteLegal[0]['nombres_pro']." ".$resultadoRepresentanteLegal[0]['apellidos_pro'];
}

$cedulaREPRE=$resultadoRepresentanteLegal[0]['cedula_pro'];

#Cuento el numero de propietarios
$cuentaPro="SELECT COUNT(*) as cuentaPro FROM tbl_propietarios, tbl_buques_pro_repre, tbl_pro_resp WHERE matricula=lower('".$_REQUEST["matricula"]."') AND tbl_propietarios.ced=tbl_buques_pro_repre.ced_pro AND tbl_pro_resp.id=tbl_propietarios.tipo AND tbl_propietarios.tipo='1'";
$consultaCuentaPro=pg_query($cuentaPro);
$resultadoCuentaPro=pg_fetch_array($consultaCuentaPro);

#cantidad de propietarios de la embarcación
$cantidad_pro = $resultadoCuentaPro['0'];

#si tiene mas de un propietario colocamos el nombre de cada uno de ellos
if($cantidad_pro>1){
	$nombresPRO = $resultadoPropietario[0]['nombres_pro']." ".$resultadoPropietario[0]['apellidos_pro'].", ".$resultadoPropietario[1]['nombres_pro']." ".$resultadoPropietario[1]['apellidos_pro'];
	}else{
	$nombresPRO = $resultadoPropietario[0]['nombres_pro']." ".$resultadoPropietario[0]['apellidos_pro'];
	}

#datos del jefe inmediato
$jefe="SELECT tbl_gerentes.nombres as nombres, tbl_gerentes.apellidos as apellidos, tbl_gerentes.num_res as num_res, tbl_gerentes.fecha_res as fecha_res, tbl_gerentes.num_gaceta as gaceta, tbl_gerentes.fecha_gaceta as fecha_gaceta, tbl_gerentes.profesion as profesion, tbl_gerentes.direccion as direccion, tbl_gerentes.cargo as cargo FROM tbl_gerentes WHERE tbl_gerentes.cargo LIKE '%general%'";
$consultaJefe=pg_query($jefe);
$resultadoJefe=pg_fetch_assoc($consultaJefe);

$nombresJefe=ucwords($resultadoJefe['nombres']);
$apellidosJefe=ucwords($resultadoJefe['apellidos']);
$profesionJefe=ucwords($resultadoJefe['profesion']);
$numRes=$resultadoJefe['num_res'];
$fechaResJefe=mesLargo($resultadoJefe['fecha_res']);
$gacetaJefe=$resultadoJefe['gaceta'];
$fechaGacetaJefe=mesLargo($resultadoJefe['fecha_gaceta']);
#$direccionJefe=ucwords($resultadoJefe['direccion']);
$cargoJefe=ucwords($resultadoJefe['cargo']);

#Cupo de combustible
$cupoEmbarcacion="SELECT tbl_cupo.cupo_anual as cupo_anual FROM tbl_cupo,tbl_registro,tbl_buques WHERE tbl_registro.matricula=tbl_buques.matricula AND tbl_registro.cod=tbl_cupo.cod_reg AND tbl_buques.matricula=lower('".$_REQUEST["matricula"]."')";
$consultaCupo=pg_query($cupoEmbarcacion);
$resultadoCupo=pg_fetch_array($consultaCupo);

$cupoAnual=$resultadoCupo['cupo_anual'];

#Arqueo
$arqueo="SELECT UPPER(tbl_arqueo.num) as num_arq, tbl_arqueo.fecha_exp as fecha_arq, tbl_arqueo.hp as hp, tbl_arqueo.arq_bruto as uab, tbl_arqueo.capacidad as capacidad, tbl_arqueo.eslora as eslora, tbl_arqueo.manga as manga, tbl_arqueo.puntal as puntal, tbl_tipo_combustible.tipo as tipo_combustible FROM tbl_arqueo,tbl_tipo_combustible WHERE tbl_arqueo.tipo=tbl_tipo_combustible.id AND matricula=lower('".$_REQUEST["matricula"]."')";
$consultaArqueo=pg_query($arqueo);
$resultadoArqueo=pg_fetch_array($consultaArqueo);

$numArq=$resultadoArqueo['num_arq'];
$fechaArq=mesCorto($resultadoArqueo['fecha_arq']);
$hp=$resultadoArqueo['hp'];
$uab=$resultadoArqueo['uab'];
$capacidad=$resultadoArqueo['capacidad'];
$eslora=$resultadoArqueo['eslora'];
$manga=$resultadoArqueo['manga'];
$puntal=$resultadoArqueo['puntal'];
$tipoCombustible=$resultadoArqueo['tipo_combustible'];

#puerto base
$puerto="SELECT tbl_puertos_base.nombre as pbase, tbl_estados.nombre as estado FROM tbl_puertos_base,tbl_pbase,tbl_ciudad, tbl_estados, tbl_registro WHERE tbl_puertos_base.id=tbl_pbase.idpuerto AND tbl_puertos_base.idcdad=tbl_ciudad.id_cdad AND tbl_registro.cod=tbl_pbase.cod_reg AND tbl_ciudad.id_edo=tbl_estados.id AND tbl_registro.matricula=lower('".$_REQUEST["matricula"]."')";
$consultaPuerto=pg_query($puerto);
$resultadoPuerto=pg_fetch_array($consultaPuerto);

$puertoBase=ucwords($resultadoPuerto['pbase']);
$estadoPuerto=ucwords($resultadoPuerto['estado']);

$config = array(
    'ZIP_PROXY' => 'PhpZipProxy', // Make sure you have Zip extension loaded
    'DELIMITER_LEFT' => '{', // Yan can also change delimiters
    'DELIMITER_RIGHT' => '}'
);

$odf = new odf("../plantillas/01.odt",$config);
$odf->setVars('cod_reg', $cod_reg);
$odf->setVars('fecha_sol_larga', $fecha_sol_larga);
$odf->setVars('matricula', $matricula);
$odf->setVars('cdadReg', $cdadReg);
$odf->setVars('nombres_pro', $nombresPRO);
$odf->setVars('nombres_repre', $nombresREPRE);
$odf->setVars('cedula_repre', $cedulaREPRE);
$odf->setVars('nombre_buque', $nombre_buque);
$odf->setVars('bandera', $bandera);
$odf->setVars('actividad', $actividad);
$odf->setVars('fechaIRN', $fechaIRN);
$odf->setVars('uso', $uso);
$odf->setVars('condicion', $condicion);
$odf->setVars('nombres_dir', $nombresJefe);
$odf->setVars('apellidos_dir', $apellidosJefe);
$odf->setVars('profesion', $profesionJefe);
$odf->setVars('num_resolucion', $numRes);
$odf->setVars('fecha_resolucion', $fechaResJefe);
$odf->setVars('num_gaceta', $gacetaJefe);
$odf->setVars('fecha_gaceta', $fechaGacetaJefe);
$odf->setVars('cargo', $cargoJefe);
$odf->setVars('nota', $nota);
$odf->setVars('cupo_otorgado', $cupoAnual);
$odf->setVars('tipo_combustible', $tipoCombustible);
$odf->setVars('num', $numArq);
$odf->setVars('fecha_arqueo', $fechaArq);
$odf->setVars('hp', $hp);
$odf->setVars('uab', $uab);
$odf->setVars('capacidad', $capacidad);
$odf->setVars('eslora', $eslora);
$odf->setVars('manga', $manga);
$odf->setVars('puntal', $puntal);
$odf->setVars('puerto_base', $puertoBase);
$odf->setVars('estado', $estadoPuerto);

$odf->exportAsAttachedFile('Registro '.$cod_reg.'.odt');
#$odf->saveToDisk('../plantillas/'.$ciudad.'.odt');
         
?>
