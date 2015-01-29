<?php
$host = "mysql.2freehosting.com";
$bd = "u963389833_horto";
$user = "u963389833_horto";
$pw= "Jonas123";

$link = mysql_connect($host,$user,$pw) or die("Impossível ligar: " . mysql_error());
                mysql_select_db($bd) or die('Não foi possí­vel selecionar a base de dados');
?>
