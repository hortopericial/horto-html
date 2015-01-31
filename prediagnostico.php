<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	
//Variaveis
	var fquestion= ""; // primeira questao
	var Nquestion=0;	// numero da questao do pré diagnostico 
	var resp_s="";		
	var flag=0;
	var qSet =1; 	// indica o question set
	var resposta="";
	var diafq=1;	// Primeira pergunta do Question set
	var npergunta=1;
	var idQuestao=0;
	var Questao="";
	
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
		$("#pergunta").html("<div id='pergunta'> <b><u>Questão Pré-Diagnostico nº " + Nquestion + "</u></b><br/><br/>" + data[0].pergunta + "<p><label>Sim</label>" + "<input type='radio' name='respa' id='respa' value='1'>" + 		"</br></br><label>Não</label>"+ "<input type='radio' name='respa' id='respa' value='0'>" + " </div>");
		$("#pergunta").fadeIn(500);
	}
	
function getNewQuestion()
{
	$.ajax(
	{
     	url: "getQuestions.php",
        type: 'POST',
		data:{qSet:qSet,diafq:diafq},
        async:false,
        success: function (q) 
		{
            qtons = JSON && JSON.parse(q) || $.parseJSON(q);	
			idQuestao = qtons[0].id_q;
			$("#perguntas_layer").append('<div id="qst'+npergunta+'"class="quest">'+qtons[0].questao+'<select class = "respostas" id="combo'+npergunta+'" style=" width:250px; margin-top:10px"><option value="default">Escolha...</option></select></div>');	
			$.each(qtons, function(i , valor)
			{
				$("#combo"+npergunta).append($('<option></option>').val(valor.id_s).html(valor.sintoma));
			}); 	
			$(".respostas#combo"+npergunta).change(function() 
			{                      							
				$(".respostas#combo"+npergunta).attr('disabled',true);	
				$.each(qtons, function(i , valor)
				{
					id_sintoma=$(".respostas#combo"+npergunta+ " option:selected").val();
					if (valor.id_s == id_sintoma)
					{
						if(valor.proximaQuestao == null)
						{
							$("#restart").hide();
							idDef= valor.deficiencia;
							$.post('getImage.php',
							{ 
								idDef:idDef,
								id:id
							}, function(d)		
							{
								img = JSON && JSON.parse(d) || $.parseJSON(d);
								$("#imagemDoenca").html("<img src='"+ img[0].img+ "' style=' height:100%; widght:100%;border-radius: 15px; box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);)'>");
								$("#perguntas_layer").append('<div id ="resp">' + valor.resposta +'</div>');	
							})
						}
						else if(valor.proximaQuestao == '0')
						{
							$("#restart").hide();
							$("#perguntas_layer").append('<div id ="resp">' + valor.resposta +'</div>');
						}
						else
						{
							diafq = valor.proximaQuestao;
							npergunta++;
							getNewQuestion();
							return false;	
						}
					}			
				}); 											
			});  											
  	 	}
	});
}
	

$(document).ready(function(){
	
	$("#layout_dia").hide();
	$("#restart").hide();
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
		else if ($("input:radio[name='respa']:checked").length == 0 && Nquestion !=0) 
		{
			
        	      //MSG IF NEEDED  para unchecked     
				  
        }
		else if ($("input:radio[name='respa']:checked").length != 0 && fquestion ==0 && value1 != flag)
		{
			$("#nextButton").text("Aguarde!!!");
			$("#layout").delay(2500).hide(1000).delay(3000); // ULTIMA DE PRE DIAGNOSTICO 
			$("#layout_dia").delay(3000).show(1000).animate({ height: 650 , width: 700}, 1500); 
			//$("#layout_dia").show();
		}
		else 
		{
			var value1 = $("input[name=respa]:checked").val();
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
	//COMEÇA AQUI
	

	$("#espec").change(function() {
		
		$("#espec option[value='default']").remove();
		
  		id=$("#espec option:selected").val();
		$("#imagemEspecie").html("<img src='"+ obj2[id-1].image+ "' style=' height:100%; widght:100%;border-radius: 15px; box-shadow:9px 9px 16px 0px rgba(50, 50, 50, 0.65);)'>");
		$("#imagemEspecie").show();
		$("#ncientivico").text(obj2[id-1].nomeCientifico);
		$("#restart").show();
		$("#ncientivico").show();
		$("#espec").attr('disabled',true);	
		getNewQuestion();
		
	});
	$("#restart").click(function(event){
		fquestion= ""; // primeira questao
		Nquestion=0;	// numero da questao do pré diagnostico 
		resp_s="";		
		flag=0;
		$("#espec").attr('disabled',false);	
		$("#espec").append(new Option("Escolha...","default"));
		$("#espec").val("default");
		$("#imagemEspecie").hide();
		$("#ncientivico").hide();
		resposta="";
		diafq=1;	// Primeira pergunta do Question set
		idQuestao=0;
	 	Questao="";
		while(npergunta >=0)
		{
			$("#qst"+String(npergunta)).fadeOut(1000).remove();
		npergunta=npergunta-1;
		}
		npergunta =1;
	});
	
	
	
	
	
});	   	
</script>

<style type="text/css">

select option{
	background:#FFF;
	color:#000;
}
#resp{
	background:#666;
	position:absolute;
	margin-left:30px;
	margin-top:40px;
	padding:15px;
	width:235px;
	color:#FFF;
	text-shadow: 2px 2px 2px #334729;
	font-size:18px;
	border-style:solid;
	bottom:65px;
	border-radius:10px;
	-webkit-box-shadow: 3px 3px 5px  #444;
    -moz-box-shadow: 3px 3px 5px #444;
	box-shadow:3px 3px 4px 0px rgba(50, 50, 50, 0.65);
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

#intitle{
	color:#FFF;
	font-family:Verdana, Geneva, sans-serif;
	font-size:22px;
	padding-left:20px;
	padding-top:10px;
	text-shadow: 2px 2px 2px #334729;
	text-decoration:underline;
}
#warn{
	color:#FFF;
	font-family:Tahoma, Geneva, sans-serif;
	padding:20px;
	font-size:16px;
	text-shadow: 1px 1px 1px #334729;
	height:80px;
	
}
#pergunta{
	font-family:Tahoma, Geneva, sans-serif;
	color:#FFF;
	padding:20px;
	padding-top:0px;
	text-shadow: 1px 1px 1px #334729;
	width:430px;
	font-size:16px;
	
}
#nextButton{
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
#nextButton:hover{
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
#resposta{
	float:right;
	margin-top:10px;
}
.quest{
	float:left;
	color:#FFF;
	font-family:Verdana, Geneva, sans-serif;
	font-size:15px;
	margin-left:10px;
	margin-top:18px;
	padding-left:20px;
	padding-top:0px;
	text-shadow: 2px 2px 2px #334729;
	width:290px;
}
#imagemEspecie{
	float:right;
	height:250px;
	width::340px;
	min-height:250px;
	max-width:340px;
	min-width:340px;
	margin-right:20px;
	margin-top:20px;
	cursor:pointer;
	
}
#imagemEspecie img{
	border:2px solid #FFF;
	max-width: 100%;
    max-height: 100%;
}

#imagemDoenca{
	position:relative;
	float:right;
	height:250px;
	width::340px;
	min-height:250px;
	max-width:340px;
	min-width:340px;
	margin-right:20px;
	margin-top:60px;
	cursor:pointer;
		
}
#imagemDoenca img{
	border:2px solid #FFF;
	max-width: 100%;
    max-height: 100%;
}
#perguntas_layer{
	float:left;
	width:340px;
	border-style:none;
	
}
#restart{
	color:#FFF;
	position: absolute;
	bottom: 15px;
	right: 15px;
	cursor:pointer;
	box-shadow:3px 3px 4px 0px rgba(50, 50, 50, 0.65);
	text-shadow: 2px 2px 2px #334729;
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
	text-align:center;
	padding-bottom:14px;
	line-height: 10px;
	margin-right:15px;
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
		<div id ="perguntas_layer">
       		<div id="combo_exp" class="quest" style="font-size:22px;">
    			Especie:
          		<select id="espec" >
            		<option value="default">Escolha...</option>
				</select>
    		</div>
        </div>
        <div>
			<div id="imagemEspecie"></div>
        	<div id="imagemDoenca"></div>
       	</div>
   	  		<label id="ncientivico" style="color:#FFF; font-size:10px; font-weight:bold;position:absolute;left:350px;top:275px; display:block"> </label>
		<div id="restart">
    		<img src="images/power_restart.png" width="25px" height="25px" style="margin-top:10px"/> Reiniciar Teste
   		</div>
    </div>
</div>





</body>
</html>
