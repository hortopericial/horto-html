<?php
	include ("connect.php");
	$qSet= $_POST['qSet'];
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT pre_diagnostico_perguntaid, Questionarios_id_quest from questionset where id_qs='$qSet'";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$espec[] = array(
		'prefq' => $line['pre_diagnostico_perguntaid'],
		'diafq' => $line['Questionarios_id_quest']
		);
	}
	echo json_encode($espec);
	mysql_free_result($result);

	
?>