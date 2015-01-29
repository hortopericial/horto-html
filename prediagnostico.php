<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	
	
	fquestion= "";
	Nquestion=0;
	resp_s="";
	i=0;
	flag=0;
	qSet =1; 
	resposta="";
	diafq=0;
	function change(data) // FUNÇÂO RESPONSAVEM POR CONTROLAR AS NOVAS PERGUNTAS DE PRE-DIAGNOSTICO //
	{
		//Pre - Diagnostico
		fquestion = Number(data[0].nextq);
		$("#intitle").css({ 'color': "#CCC" },2000);
		$("#warn").css({ 'color': "#CCC" },2000);
		Nquestion=Number(Nquestion) +1 ;
		resposta = data[0].respostas;
		flag = Number(data[0].flags);
		$("#nextButton").text("Validar >>");
		$("#pergunta").fadeOut(0);
		$("#pergunta").html("<div id='pergunta'> <b><u>Questão Pré-Diagnostico nº " + Nquestion + "</u></b><br/><br/>" + data[0].pergunta + "<p><label>Sim</label>" + "<input type='radio' name='resp' id='resp' value='1'>" + 		"</br></br><label>Não</label>"+ "<input type='radio' name='resp' id='resp' value='0'>" + " </div>");
		$("#pergunta").fadeIn(500);
	}
	
$(document).ready(function(){
	
	$("#layout_dia").hide();
	$("#layout").animate({ height: 400 , width: 700}, 1500);
	
	
	// ADICIONAR FUTURAMENTE O SQL PARA ESCOLHER O QUESTION SET 
	
	
	$.post("getFirstQuestion.php", // APANHA A PRIMEIRA PERGUNTA DO Question set
		{
			qSet:qSet
		},function(fq)
		{		
			res = JSON && JSON.parse(fq) || $.parseJSON(fq);
			fquestion = Number(res[0].prefq);
			diafq= Number(res[0].diafq);
			
			
		}
	);
		
	$("#nextButton").click(function(event){
		if (Nquestion ==0)
		{
			$.post("preperguntas.php",
				{
					fquestion:fquestion
				},function(data)
				{
					obj = JSON && JSON.parse(data) || $.parseJSON(data);
					change(obj);	
				}
			);		
		}
		else if ($("input:radio[name='resp']:checked").length == 0 && Nquestion !=0) 
		{
			
        	      //MSG IF NEEDED  para unchecked     
				  
        }
		else if ($("input:radio[name='resp']:checked").length != 0 && fquestion ==0 && value1 != flag)
		{
			$("#nextButton").text("Aguarde!!!");
			$("#layout").delay(2500).hide(1000).delay(3000); // ULTIMA DE PRE DIAGNOSTICO 
			$("#layout_dia").delay(3000).show(1000).animate({ height: 650 , width: 700}, 1500); 
		}
		else 
		{
			var value1 = $("input[name=resp]:checked").val();
			if(value1 == flag)
			{
				
				$("#pergunta").text(resposta);		
				$("#nextButton").hide(500);	
			}
			else
			{
				$.post("preperguntas.php",
				{
					fquestion:fquestion
				},function(data)
				{
					obj = JSON && JSON.parse(data) || $.parseJSON(data);
					change(obj);	
				});		
			}
		}
	});	
	
	$.post("getSpecie.php", 
	{ 
		qSet:qSet 
	}, function(data2)		
	{		
		obj2 = JSON && JSON.parse(data2) || $.parseJSON(data2);
		$.each(obj2, function(i , valor){
				$("#espec").append($('<option></option>').val(valor.id).html(valor.nomeComum));
			});
		
	});
	
	$("#espec").change(function() {
		$("#espec option[value='default']").remove();
  			id=$("#espec option:selected").val();
			$("#ncientivico").text(obj2[id-1].nomeCientifico);
			$("#imagemEspecie").html("<img src='"+ obj2[id-1].image+ "' style=' height:100%; widght:100%;border-radius: 15px; box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);)'>");
	});
	$("#imagemEspecie").click(function(event){
		
	});
	
});	   	
</script>


<style type="text/css">
select option{
	background:#FFF;
	color:#000;
}

select{
   	width: 170px;
    color: #333;
    font-size:14px;
    line-height:1.2em;
    margin: 0 0 10px;
    padding: 4px 0;
    border:1px solid #444;
    cursor: pointer;
    text-indent: 0.01px;
    text-overflow: "";
	background: #a9db80; /
	background: -moz-linear-gradient(top,  #a9db80 0%, #96c56f 100%); 
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a9db80), color-stop(100%,#96c56f));
	background: -webkit-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #a9db80 0%,#96c56f 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a9db80', endColorstr='#96c56f',GradientType=0 ); 
	-webkit-box-shadow: 3px 3px 5px  #444;
    -moz-box-shadow: 3px 3px 5px #444;
	box-shadow:3px 3px 4px 0px rgba(50, 50, 50, 0.65);
	
}
#layout {
    position:relative;
	height:0px;  
    width:0px;  
    background:#FFF;
    z-index:100; 
	top:10px;
	margin-top:0 px;
	margin-left:14px;
    border:2px solid #72aa00; 
    padding:2px;  
    font-size:15px;  
    -moz-box-shadow: 0 0 5px #030;
    -webkit-box-shadow: 0 0 5px #030;
    box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);
	border-radius:15px;	
}

#layout_dia {
  position:relative;
	height:0px;  
    width:0px;  
    background:#FFF;
    z-index:100; 
	top:10px;
	margin-top:0 px;
	margin-left:14px;
    border:2px solid #72aa00; 
    padding:2px;  
    font-size:15px;  
    -moz-box-shadow: 0 0 5px #030;
    -webkit-box-shadow: 0 0 5px #030;
    box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);
	border-radius:15px;	
}

.inFrame{
	height:400px;  
    width:700px;
	background:#72aa00;
	border-radius:13px;	
}

#intitle
{
	color:#FFF;
	font-family:Verdana, Geneva, sans-serif;
	font-size:22px;
	padding-left:20px;
	padding-top:10px;
	text-shadow: 2px 2px 2px #334729;
	text-decoration:underline;
}
#warn
{
	color:#FFF;
	font-family:Tahoma, Geneva, sans-serif;
	padding:20px;
	font-size:16px;
	text-shadow: 1px 1px 1px #334729;
	height:80px;
	:
}
#pergunta
{
	font-family:Tahoma, Geneva, sans-serif;
	color:#FFF;
	padding:20px;
	padding-top:0px;
	text-shadow: 1px 1px 1px #334729;
	width:330px;
	font-size:16px;
	width:450px;
}
#nextButton
{
	font-family:Tahoma, Geneva, sans-serif;
	color:#FFF;
	border:2px solid #72aa00;
	width:150px;
	height:30px;
	-moz-box-shadow: 0 0 5px #030;
    -webkit-box-shadow: 0 0 5px #030;
    box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);
	border-radius:10px;	
	border:2px solid #FFF;
	cursor:pointer;
	text-align:center;
	float:right;
	line-height: 30px;
	margin-right:30px;

}
#nextButton:hover
{
font-family:Tahoma, Geneva, sans-serif;
	color:#FFF;
	border:2px solid #72aa00;
	width:150px;
	height:30px;
	-moz-box-shadow: 0 0 5px #030;
    -webkit-box-shadow: 0 0 5px #030;

	border-radius:10px;	
	border:2px solid #FFF;
	cursor:pointer;
	text-align:center;
	float:right;
	line-height: 30px;
	margin-right:32px;
}
#buttonsBar{
	width:600px;
}
#resposta
{
	float:right;
	margin-top:10px;
}
#combo_exp
{
	float:left;
	color:#FFF;
	font-family:Verdana, Geneva, sans-serif;
	font-size:22px;
	margin-left:15px;
	margin-top:10px;
	padding-left:20px;
	padding-top:30px;
	text-shadow: 2px 2px 2px #334729;
	height:50px;
	width:300px;
}
#imagemEspecie
{
	float:right;
	height:250px;
	width::340px;
	min-height:250px;
	max-width:340px;
	min-width:340px;
	margin-right:20px;
	margin-top:20px;
		
}
#imagemEspecie img
{
	border:2px solid #FFF;
	 max-width: 100%;
    max-height: 100%;
}

</style>	
</head>

<body>



<div id="layout">
	<div id="frame_inside" class = "inFrame">
    	<div id="intitle">
    		Alertas pré-diagnóstico:
    	</div>
    	<div id="warn">
    		Não deve utilizar o órgão (folhas/caule) danificado por picadas de insetos, por geadas, entre outros para análise de sintoma. <br /> <br /><b><u>Órgãos a observar</u>:</b> Folhas.
    	</div>
    
    	<div id="pergunta" style="float:left">
     		Entende-se por folha nova, a folha na posição superior do caule ou exterior da copa e por folha velha, a folha que está na posição inferior do caule/ramo.
    	</div>
     	<div id="imagem">
    	<img src="images/alertafolhas.png" width="200" height="180" />
    	</div>
  		<div id="nextButton">
    		Começar >>
   	 	</div>
  	</div>
</div>  
 <div id="layout_dia" >
	<div id="frame_inside_2" class = "inFrame" style=" height:650px;">
    	<div id="combo_exp">
    		Especie:
            <select id="espec" >
             <option value="default">Escolha...</option>
			</select>
    	</div>
        <div id="imagemEspecie">
   
        </div>
        <label id="ncientivico" style="color:#FFF; font-size:10px; font-weight:bold;position:absolute;left:370px;top:260px; display:block"> </label>
	</div>
</div>   





</body>
</html>
