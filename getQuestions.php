<?php
	include ("connect.php");
	$qset = $_POST['qSet'];
	$idQ = $_POST['diafq'];
	
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT qs.id_quest,qs.questao, s.id_sintoma,s.sintoma,s.resposta,s.prox_quest,s.deficiencias_id_deficiencia "
	." FROM questionarios as qs"
	." inner join sintomas as s"
	." ON s.id_quest_fk = qs.id_quest and s.id_quest_fk ='$idQ' and qs.id_qs_fk = $qset";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$espec[] = array(
			'id_q' => $line['id_quest'],
			'questao' => $line['questao'],
			'id_s' => $line['id_sintoma'],
			'sintoma' => $line['sintoma'],			
			'resposta' => $line['resposta'],
			'proximaQuestao' => $line['prox_quest'],
			'deficiencia' => $line['deficiencias_id_deficiencia']					
		);	
	}
	echo json_encode($espec);
	mysql_free_result($result);


?>