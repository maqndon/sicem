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
		$result = pg_query("SELECT COUNT(*) FROM tbl_arqueo;");
		$row = pg_fetch_array($result);
		$recordCount = $row['0'];

		//Get records from database
		$result = pg_query("SELECT tbl_arqueo.id as idarqueo, upper(tbl_arqueo.matricula) as arqmatricula, upper(tbl_arqueo.num) as num,tbl_arqueo.fecha_exp as fecha_arq,tbl_arqueo.tipo as idtipocomb,tbl_arqueo.capacidad as cap,tbl_arqueo.hp as hp,tbl_arqueo.eslora as eslora,tbl_arqueo.manga as manga,tbl_arqueo.puntal as puntal,tbl_arqueo.arq_bruto as bruto,tbl_arqueo.arq_neto as neto,initcap(tbl_tipo_combustible.tipo) as combustible FROM tbl_buques,tbl_arqueo,tbl_tipo_combustible WHERE tbl_arqueo.matricula=lower('".$_REQUEST["matricula"]."') AND tbl_buques.matricula=tbl_arqueo.matricula AND tbl_arqueo.tipo=tbl_tipo_combustible.id");
		 
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
		$result = pg_query("INSERT INTO tbl_arqueo (matricula, num, fecha_exp, capacidad, hp, eslora, manga, puntal, arq_bruto, arq_neto, tipo) VALUES (lower('".$_POST[arqmatricula]."'),lower('".$_POST[num]."'),'".$_POST[fecha_arq]."','".$_POST[cap]."','".$_POST[hp]."','".$_POST[eslora]."','".$_POST[manga]."','".$_POST[puntal]."','".$_POST[bruto]."', '".$_POST[neto]."','".$_POST[idtipocomb]."');");
		 
		//Get last inserted record (to return to jTable)
		$lastvalue_query = pg_query("SELECT last_value as id FROM tbl_arqueo_id_seq");
		$lastvalue = pg_fetch_assoc($lastvalue_query);
		$result= pg_query("SELECT * from tbl_arqueo WHERE id='".$lastvalue['id']."'");
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
		$result = pg_query("UPDATE tbl_arqueo SET matricula=lower('".$_POST["arqmatricula"]."'), num=lower('".$_POST["num"]."'), fecha_exp='".$_POST["fecha_arq"]."', capacidad='".$_POST["cap"]."', hp='".$_POST["hp"]."', eslora='".$_POST["eslora"]."', manga='".$_POST["manga"]."', puntal='".$_POST["puntal"]."', arq_bruto='".$_POST["bruto"]."', arq_neto='".$_POST["neto"]."', tipo='".$_POST["idtipocomb"]."' WHERE id ='".$_POST["idarqueo"]."';");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
		}
		
	//Deleting a record (deleteAction)
		else if($_GET["action"] == "delete"){
			
		//Delete from database
		$result = pg_query("DELETE FROM tbl_arqueo WHERE id = " . $_POST["idarqueo"] . ";");

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
