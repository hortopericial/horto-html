<?php
	include ("connect.php");
	$name = $_POST['n'];
	$password = $_POST['p'];
	$email = $_POST ['e'];
	$query = "INSERT INTO utilizadores (nome_util, password, email) VALUES ('$name','$password','$email')"; 
   	mysql_query($query);
	mysql_close($link); 

?>