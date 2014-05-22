<?php

$host='localhost';
$dbname='bd_sicem';
$usuario='marcel';
$pass='P@ssw0rd';
$db = pg_Connect("host=$host dbname=$dbname user=$usuario password=$pass") or die ("No se pudo hacer la conexi&oacute;n con la base de datos");
?>
