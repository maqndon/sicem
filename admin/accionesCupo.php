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
		$result = pg_query("SELECT COUNT(*) FROM tbl_cupo;");
		$row = pg_fetch_array($result);
		$recordCount = $row['0'];

		//Get records from database
		$result = pg_query("SELECT tbl_cupo.id as idcupo, upper(tbl_cupo.cod_reg) as codreg, tbl_cupo.dias_faena as faena,tbl_cupo.horas_serv as horas,tbl_cupo.sol_lts as sol_lts,tbl_cupo.sol_cupo as sol_cupo, tbl_cupo.cupo_anual as cupo_anual, tbl_cupo.formula as formula, upper(tbl_registro.matricula) as cupomatricula FROM tbl_cupo, tbl_registro WHERE tbl_cupo.cod_reg=tbl_registro.cod AND tbl_registro.matricula=lower('".$_REQUEST["matricula"]."')");
		 
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
			
		# is_null, isset, empty

		//Insert record into database
		//$result = pg_query("INSERT INTO tbl_cupo (cod_reg, dias_faena, horas_serv, sol_lts, sol_cupo, cupo_anual, formula) VALUES (lower('".$_REQUEST[codreg]."'),'".$_POST[faena]."','".$_POST[horas]."','".$_POST[sol_lts]."','".$_POST[sol_cupo]."','".$_POST[cupo_anual]."','".$_POST[formula]."');");
		$result = pg_query("INSERT INTO tbl_cupo (cod_reg, dias_faena, horas_serv, sol_lts, sol_cupo, cupo_anual, formula) SELECT cod, ".$_POST[faena]." as faena, ".$_POST[horas]." as horas, ".$_POST[sol_lts]." as sol_lts, ".$_POST[sol_cupo]." as sol_cupo, ".$_POST[formula]." as formula, ".$_POST[cupo_anual]." as cupo_anual FROM tbl_registro WHERE tbl_registro.matricula=lower('".$_REQUEST["matricula"]."');");

		//Get last inserted record (to return to jTable)
		$lastvalue_query = pg_query("SELECT last_value as id FROM tbl_cupo_id_seq");
		$lastvalue = pg_fetch_assoc($lastvalue_query);
		$result= pg_query("SELECT * from tbl_cupo WHERE id='".$lastvalue['id']."'");
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
		$result = pg_query("UPDATE tbl_cupo SET dias_faena='".$_POST["faena"]."', horas_serv='".$_POST["horas"]."', sol_lts='".$_POST["sol_lts"]."', sol_cupo='".$_POST["sol_cupo"]."', cupo_anual='".$_POST["cupo_anual"]."', formula='".$_POST["formula"]."' WHERE id ='".$_POST["idcupo"]."';");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Deleting a record (deleteAction)
		else if($_GET["action"] == "delete"){
			
		//Delete from database
		$result = pg_query("DELETE FROM tbl_cupo WHERE id = " . $_POST["idcupo"] . ";");

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
