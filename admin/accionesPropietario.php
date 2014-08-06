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
		$result = pg_query("SELECT COUNT(*) AS RecordCount FROM tbl_propietarios, tbl_buques_pro_repre, tbl_buques WHERE tbl_buques.matricula=lower('".$_REQUEST["matricula"]."') AND tbl_buques_pro_repre.matricula=tbl_buques.matricula");
		$row = pg_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		//Get records from database
		$result = pg_query("SELECT tbl_propietarios.id as idpro, upper(tbl_propietarios.ced) as ced, initcap(tbl_propietarios.nombres) as nombres, initcap(tbl_propietarios.apellidos) as apellidos, tbl_propietarios.tel as tel, tbl_propietarios.cel as cel, tbl_propietarios.fax as fax, tbl_propietarios.email as email, initcap(tbl_propietarios.direccion) as direccion, tbl_propietarios.tipo as protipoid, tbl_buques.matricula as promatricula, upper(tbl_pro_resp.tipo) as protiponombre FROM tbl_pro_resp, tbl_propietarios, tbl_buques_pro_repre, tbl_buques WHERE tbl_buques.matricula=lower('".$_REQUEST["matricula"]."') AND tbl_buques_pro_repre.ced_pro=tbl_propietarios.ced AND tbl_buques_pro_repre.matricula=lower('".$_REQUEST["matricula"]."') AND tbl_pro_resp.id=tbl_propietarios.tipo");
		 
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
		$result = pg_query("INSERT INTO tbl_propietarios (ced, nombres, apellidos, tel, cel, fax, email, direccion, tipo) VALUES (lower('".$_POST[ced]."'),lower('".$_POST[nombres]."'),lower('".$_POST[apellidos]."'),'".$_POST[tel]."','".$_POST[cel]."','".$_POST[fax]."',lower('".$_POST[email]."'),lower('".$_REQUEST[direccion]."'),'".$_POST[protipoid]."');");
		$result = pg_query("INSERT INTO tbl_buques_pro_repre (matricula, ced_pro) VALUES (lower('".$_POST[promatricula]."'),'".$_POST[ced]."');");
		
		//Get last inserted record (to return to jTable)
		$lastvalue_query = pg_query("SELECT last_value as id FROM tbl_propietarios_id_seq");
		$lastvalue = pg_fetch_assoc($lastvalue_query);
		$result= pg_query("SELECT * from tbl_propietarios WHERE id='".$lastvalue['id']."'");
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
		$result = pg_query("UPDATE tbl_propietarios SET ced=lower('".$_POST["ced"]."'), nombres=lower('".$_POST["nombres"]."'), apellidos=lower('".$_POST["apellidos"]."'), tel='".$_POST["tel"]."', cel='".$_POST["cel"]."', fax='".$_POST["fax"]."', email=lower('".$_POST["email"]."'), direccion=lower('".$_POST["direccion"]."'), tipo='".$_POST["protipoid"]."' WHERE id ='".$_POST["idpro"]."';");
		$result = pg_query("UPDATE tbl_buques_pro_repre SET ced_pro='".$_POST[ced]."' WHERE matricula=lower('".$_POST[promatricula]."');");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Deleting a record (deleteAction)
		else if($_GET["action"] == "delete"){
			
		//Delete from database
		$result = pg_query("DELETE FROM tbl_propietarios WHERE id = " . $_POST["idpro"] . ";");
		$result = pg_query("DELETE FROM tbl_buques_pro_repre WHERE matricula = " . $_POST["promatricula"] . ";");
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

