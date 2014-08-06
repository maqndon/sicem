<?php

#cargamos las funciones del sistema
include('../includes/funciones.inc.php');

#conexion a la BBDD
include '../includes/conexion.inc.php';

session_start();

#funcion para verificar que el usuario se haya validado
validarSesion();

try
{
	//Getting records (listAction)
	if($_GET["action"] == "list"){
		
		//Get record count
		$result = pg_query("SELECT COUNT(*) FROM tbl_buques;");
		$row = pg_fetch_array($result);
		$recordCount = $row['0'];

		//Get records from database
		$result = pg_query("SELECT tbl_buques.id as id, upper(tbl_buques.matricula) as matricula, upper(tbl_buques.nombre) as nombre,initcap(tbl_buques.bandera) as bandera,tbl_buques.tipo as idtipo,tbl_estados.id as idestado,initcap(tbl_estados.nombre) as estado,initcap(tbl_ciudad.nombre) as ciudad,tbl_ciudad.id_cdad as idciudad,tbl_buques.actividad as idactividad,tbl_buques.uso as iduso,tbl_buques.fecha_irn as fecha_irn,tbl_buques.fecha_insp as fecha_insp,initcap(tbl_tipo.nombre) as tipo,initcap(tbl_actividad.nombre) as actividad,initcap(tbl_uso.nombre) as uso FROM tbl_buques,tbl_ciudad,tbl_estados,tbl_tipo,tbl_actividad,tbl_uso WHERE tbl_buques.ciudad=tbl_ciudad.id_cdad AND tbl_ciudad.id_edo=tbl_estados.id AND tbl_actividad.id=tbl_buques.actividad AND tbl_buques.tipo=tbl_tipo.id AND tbl_uso.id=tbl_buques.uso ORDER BY ".$_GET["jtSorting"]." LIMIT ".$_GET["jtPageSize"]." OFFSET ".$_GET["jtStartIndex"]."");
		 
		//Add all records to an array
		$rows = array();
		while($row = pg_fetch_array($result))
		{
			$rows[] = $row;
		}
		 
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
		}

	//Creating a new record (createAction)
		else if($_GET["action"] == "create"){

		//Insert record into database
		$result = pg_query("INSERT INTO tbl_buques (matricula, nombre, bandera, ciudad, tipo, actividad, uso, fecha_irn, fecha_insp) VALUES (lower('".$_POST[matricula]."'),lower('".$_POST[nombre]."'),lower('".$_POST[bandera]."'),'".$_POST[idciudad]."','".$_POST[idtipo]."','".$_POST[idactividad]."','".$_POST[iduso]."','".$_POST[fecha_irn]."','".$_POST[fecha_insp]."');");
		 
		//Get last inserted record (to return to jTable)
		$lastvalue_query = pg_query("SELECT last_value as id FROM tbl_buques_id_seq");
		$lastvalue = pg_fetch_assoc($lastvalue_query);
		$result= pg_query("SELECT * from tbl_buques WHERE id='".$lastvalue['id']."'");
		$row = pg_fetch_array($result);
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;	
		print json_encode($jTableResult);
		}
		
	//Updating a record (updateAction)
		else if($_GET["action"] == "update"){
			
		//Update record in database
		$result = pg_query("UPDATE tbl_buques SET matricula=lower('".$_POST["matricula"]."'), nombre=lower('".$_POST["nombre"]."'), bandera=lower('".$_POST["bandera"]."'), ciudad='".$_POST["idciudad"]."', tipo='".$_POST["idtipo"]."', actividad='".$_POST["idactividad"]."', uso='".$_POST["iduso"]."', fecha_irn='".$_POST["fecha_irn"]."', fecha_insp='".$_POST["fecha_insp"]."' WHERE id ='".$_POST["id"]."';");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Deleting a record (deleteAction)
		else if($_GET["action"] == "delete"){
			
		//Delete from database
		$result = pg_query("DELETE FROM tbl_buques WHERE id = " . $_POST["id"] . ";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Close database connection
	pg_close($db);
		
}
	catch(Exception $ex)
	{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
	}
	
?>
