

<?php
	include ("connect.php");
	
	$mail = $_POST['m'];
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT count(email) from utilizadores where email='$mail'";
	$result=mysql_query($query);
	echo mysql_result($result,0);
	
	
	mysql_free_result($result);
	mysql_close($link); 
?>
	