<?php
include ("connect.php");
$id_def = $_POST['idDef'];
$id_esp = $_POST['id'];
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT imagem_deficiencia FROM especies_has_deficiencias WHERE deficiencias_id_deficiencia = '$id_def' AND especies_id_especie = '$id_esp'";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$img[] = array(
			'img' => $line['imagem_deficiencia']			
		);	
	}
	echo json_encode($img);
	mysql_free_result($result);


?>