<?php
	include ("connect.php");
	$qset= $_POST['qSet'];
	
	$qSet =1;
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT id_especie,nome_comum,nome_cientifico,imagem FROM especies where questionset_id_qs='$qSet'";
	$result=mysql_query($query);
	while ($line = mysql_fetch_assoc($result)) 
	{
		$espec[] = array(
			'id' => $line['id_especie'],
			'nomeComum' => $line['nome_comum'],
			'nomeCientifico' => $line['nome_cientifico'],
			'image'=>$line['imagem']
		);	
	}
	echo json_encode($espec);
	mysql_free_result($result);
?>