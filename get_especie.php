<?php
	include ("connect.php");
	mysql_query('SET CHARACTER SET utf8');
	$query = "SELECT especieId, nome_Especie,nome_Cientifico_Especie, foto_saudavel FROM especies Order by especieId";
	$result=mysql_query($query);

	while ($line = mysql_fetch_assoc($result)) 
	{
		$especies[] = array(
			'id' => $line['especieId'],
			'nome' => $line['nome_Especie'],
			'cientifico' => $line['nome_Cientifico_Especie'],
			'foto' => $line['foto_saudavel']
		);
		
	}
	echo json_encode($especies);
	mysql_free_result($result);

	mysql_close($link);
?>