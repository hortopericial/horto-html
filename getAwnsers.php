<?php
	include ("connect.php");
	$idS = $_POST['idQuestao'];
	
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT id_sintoma,sintoma, resposta, deficiencias_id_deficiencia,prox_quest FROM sintomas where id_quest_fk='$idS'";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$espec[] = array(
			'id_s' => $line['id_sintoma'],
			'sintoma' => $line['sintoma'],
			'resposta' => $line['resposta'],
			'id_deficiencia' => $line['deficiencias_id_deficiencia'],
			'prox' => $line['prox_quest']
		);	
	}
	echo json_encode($espec);
	mysql_free_result($result);
?>