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
		$result = pg_query("SELECT COUNT(*) AS RecordCount FROM tbl_registro;");
		$row = pg_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		//Get records from database
		$result = pg_query("SELECT tbl_registro.id as idregistro, upper(tbl_registro.matricula) as regmatricula, upper(tbl_registro.cod) as codregistro,tbl_registro.ciudad as idciudadreg,tbl_registro.fecha_sol as fecha_sol,tbl_registro.fecha_rec as fecha_rec,tbl_registro.fecha_reg as fecha_reg,upper(tbl_registro.num_ofic) as num_ofic,tbl_registro.fecha_ofic as fecha_ofic,tbl_registro.fecha_entrega as fecha_entrega, initcap(tbl_puertos_base.nombre) as pbnombre, tbl_pbase.idpuerto as pbid,tbl_ciudad.id_edo as idestadoreg FROM tbl_registro,tbl_pbase,tbl_puertos_base,tbl_ciudad WHERE tbl_registro.matricula =lower('".$_REQUEST["matricula"]."') AND tbl_puertos_base.id=tbl_pbase.idpuerto AND tbl_pbase.cod_reg=tbl_registro.cod AND tbl_registro.ciudad=tbl_ciudad.id_cdad");
		 
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
		$result = pg_query("INSERT INTO tbl_registro (cod, fecha_sol, fecha_rec, fecha_reg, num_ofic, fecha_ofic, fecha_entrega, matricula, ciudad) VALUES (lower('".$_POST[codregistro]."'),'".$_POST[fecha_sol]."','".$_POST[fecha_rec]."','".$_POST[fecha_reg]."',lower('".$_POST[num_ofic]."'),'".$_POST[fecha_ofic]."','".$_POST[fecha_entrega]."',lower('".$_REQUEST[matricula]."'),'".$_POST[idciudadreg]."');");
		$result = pg_query("INSERT INTO tbl_pbase (cod_reg, idpuerto) VALUES (lower('".$_POST[codregistro]."'),'".$_POST[pbid]."');");
		
		//Get last inserted record (to return to jTable)
		$lastvalue_query = pg_query("SELECT last_value as id FROM tbl_registro_id_seq");
		$lastvalue = pg_fetch_assoc($lastvalue_query);
		$result= pg_query("SELECT * from tbl_registro WHERE id='".$lastvalue['id']."'");
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
		$result = pg_query("UPDATE tbl_registro SET cod=lower('".$_POST["codregistro"]."'), fecha_sol='".$_POST["fecha_sol"]."', fecha_rec='".$_POST["fecha_rec"]."', fecha_reg='".$_POST["fecha_reg"]."', num_ofic=lower('".$_POST["num_ofic"]."'), fecha_ofic='".$_POST["fecha_ofic"]."', fecha_entrega='".$_POST["fecha_entrega"]."', matricula=lower('".$_POST["regmatricula"]."'), ciudad='".$_POST["idciudadreg"]."' WHERE id ='".$_POST["idregistro"]."';");
		$result = pg_query("UPDATE tbl_pbase SET idpuerto='".$_POST[pbid]."' WHERE cod_reg=lower('".$_POST[codregistro]."');");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Deleting a record (deleteAction)
		else if($_GET["action"] == "delete"){
			
		//Delete from database
		$result = pg_query("DELETE FROM tbl_registro WHERE id = " . $_POST["idregistro"] . ";");
		$result = pg_query("DELETE FROM tbl_pbase WHERE id = " . $_POST["codregistro"] . ";");
		#borrar la entrada a tbl_pbase

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

