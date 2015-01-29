<?php
	include ("connect.php");
	
	$nPergunta= $_POST['fquestion'];
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT pergunta,resposta,flag,pre_diagnostico_id_pergunta FROM pre_diagnostico WHERE id_pergunta='$nPergunta'";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$prediag[] = array(
			'pergunta' => $line['pergunta'],
			'respostas' => $line['resposta'],
			'flags' => $line['flag'],
			'nextq'=>$line['pre_diagnostico_id_pergunta']
		);	
	}
	echo json_encode($prediag);
	mysql_free_result($result);

	mysql_close($link);
?>