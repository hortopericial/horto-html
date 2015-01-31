<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Projecto Horto Pericial:.</title>
<script src="http://code.jquery.com/jquery-latest.min.js "></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="menufiles/mbcsmbpe09.css" type="text/css" />
<script type="text/javascript" src="menufiles/mbjsmbpe09.js"></script>
<?php
		include ("temp.php");
?>
</head>	
<style>
    body { font-size: 62.5%; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
	.ui-widget-overlay {
   	background: #030 url(images/ui-bg_flat_0_aaaaaa_40x100.png) 50% 50% repeat-x;
   	opacity: .40;
   	filter: Alpha(Opacity=40);
}
</style>


<script type="text/javascript">
$(function() {
	var dialog, form,
	emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
	name = $( "#name" ),
    email = $( "#email" ),
    password = $( "#password" )
	cpassword = $( "#c_password"),
    allFields = $( [] ).add( name ).add( email ).add( password ) .add( cpassword),
    tips = $( ".validateTips" );
    function updateTips( t ) {
   		tips
       	.text( t )
        .addClass( "ui-state-highlight" );
      	setTimeout(function() {
        	tips.removeClass( "ui-state-highlight", 1500 );
      	}, 500 );
    }
 
 	function checkLength( o, n, min, max ) {
    	if ( o.val().length > max || o.val().length < min ) {
        	o.addClass( "ui-state-error" );
        	updateTips( "O campo " + n + " deverá conter entre " +
          	min + " e " + max + " caracteres." );
        	return false;
      	} else {
        	return true;
      	}
    }
 
    function checkRegexp( o, regexp, n ) {
    	if ( !( regexp.test( o.val() ) ) ) {
        	o.addClass( "ui-state-error" );
        	updateTips( n );
        	return false;
      	} else {
        	return true;
      	}
    }
	
	function comparar (p1,p2,msg)
	{
		if( p1.val() != p2.val())
		{
			p2.addClass("ui-state-error");
			updateTips (msg);
			return false;
		}
		else{
			return true;
		}
	}
 
    function addUser() {
      	var valid = true;
      	allFields.removeClass( "ui-state-error" ); 
	    valid = valid && checkLength( name, "Nome", 5, 16 );
      	valid = valid && checkLength( email, "E-mail", 6, 40 );
      	valid = valid && checkLength( password, "Password", 5, 16 );
 	  	valid = valid && comparar (password,cpassword,"As passwords não incoincidem");	 
      	valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "O nome do utilizador deverá ter caracteres alfa-numéricos podendo ter espaços ou underscores" );
      	valid = valid && checkRegexp( email, emailRegex, "Formato de email inválido, xpto@dominio.com" );
      	valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password apenas deverá conter caracteres alfa-numéricos" );
	    if ( valid ) {
       	//Criar post para guardar e verificar dados
        	dialog.dialog( "close" );
      	}
      	return valid;
	}
 	dialog = $( "#dialog-form" ).dialog({
    	autoOpen: false,
      	height: 380,
      	width: 420,
	  	resizable: false,
      	modal: true,
      	buttons: {
        	"Registar": addUser,
        	Cancel: function() {
          		dialog.dialog( "close" );
        	}
		},
    	close: function() {
    		form[ 0 ].reset();
        	allFields.removeClass( "ui-state-error" );
      	}
    });
 	form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 	$( "#registar_log" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
});

function scrollToAnchor(id){
	$('html,body').animate({scrollTop: $("#"+id).offset().top}, 1400);
}

$(document).ready(function(){
	$("#centro_principal").load("home.php");
	$("#inicio").click(function(event)
	{
		$("#centro_principal").load("home.php");
		$("#titulo_centro").text("INICIO");
	});
	$("#diagnostico").click(function(event)
	{
		scrollToAnchor("centra");
		$("#centro_principal").load("prediagnostico.php");
		$("#titulo_centro").text("INICIO > DIAGNOSTICO");	
	});
	$("#acerca").click(function(event)
	{
		scrollToAnchor("centra"); // REMOVER //
		$("#centro_principal").load("pre_testes.php");
		$("#titulo_centro").text("INICIO > DIAGNOSTICO");
	});
	$( "#loggar" ).button().on( "click", function() {
   	 // CRIAR ALTERAÇOES DE LOGIN  
    });
});
		
</script>


<script>
function apagar(x) {
    document.getElementById(x).value = "";
}
</script>

<style type="text/css">

.global{
	position:center;
	display:block; 
	width:1025px; 
	margin:auto;
	margin-bottom:0px;
	margin-top:0px;
	background:url(images/back.jpg);
	padding:0px 20px 0px 20px;
}
.degrade {
	background: rgb(91,150,13); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(91,150,13,1) 0%, rgba(225,249,214,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(91,150,13,1)), color-stop(100%,rgba(225,249,214,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(91,150,13,1) 0%,rgba(225,249,214,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(91,150,13,1) 0%,rgba(225,249,214,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(91,150,13,1) 0%,rgba(225,249,214,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(91,150,13,1) 0%,rgba(225,249,214,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5b960d', endColorstr='#e1f9d6',GradientType=0 ); /* IE6-9 */
}
.sombra_texto
{
	text-shadow: 4px 4px 4px #999;
}
.lateral_titulo {
    font-family: Arial, Helvetica, sans-serif;	
	font-weight:bold;
	color: #234F6F;
	text-transform:uppercase;
	padding:5px;
	background-color:#7BBA07;
	text-align:left;
	font-size: 11px;
	border-radius:10px 10px 0px 0px; 
	border-width:1px; 
	padding: 5px 5px 5px 12px;
	text-shadow: 2px 2px 2px #334729;
	color:#FFF
}

</style>

<body background="images/bg.jpg"style="margin-top:0;margin-bottom:0px;">
<div name="globo" id="globo" class="global"> 
	<div id="conteudo" style="margin:0px;">
		<div id="banner" style="height: 197px; background-image:url(images/banner.jpg);  width: 1025px;"></div>
        <!-- INICIO DO MENU HORIZONTAL -->
        <div id="menu2" style=" height: 50px; width: 100%; background-image:url(images/menu.jpg); width: 1024px">
        	<div id="mbpe09ebul_wrapper" style="float:right;text-shadow: 2px 2px 2px #334729; margin-right:-1px ">
  				<ul id="mbpe09ebul_table" class="mbpe09ebul_menulist css_menu">
  					<li><div id ="inicio" class="buttonbg"><a class="button_1">Inicio</a></div></li>
 					<li><div id ="diagnostico" name ="diagnostico" class="buttonbg"><a>Diagnostico</a></div></li>
  					<li><div class="buttonbg"><a>Noticias</a></div></li>
  					<li><div class="buttonbg"><a>Contactos</a></div></li>
  					<li><div id="acerca" class="buttonbg"><a>Acerca</a></div></li>
  				</ul>
			</div>
 		</div><!-- FIM MENU HORIZONTAL-->
		<!-- INICIO MENU VERTICAL -->
		<div class="degrade" id="menu" style="height: 800px; width: 22%; float: left;"> 
		<!-- INICIO DIV LOGIN -->	
       		<div id="login" style=" ;text-shadow: 4px 4px 4px #999;color:#6c6c6c;font:12px Tahoma, Geneva, sans-serif;background-color:#f0fddf; margin:10px 10px 0px 10px;height: 160px;border-style:solid; border-radius:10px; border-width:0px ;border-color:#D5D6DA;box-shadow:  3px 3px 5px 2px rgba(55, 55, 55, 0.3); "> 
        		<div class="lateral_titulo" style="height: 15px; ">  Utilizador 
                	<div style=" float:right;width:110px;text-align:right; padding: 0px 10px 0px 0px"> 
                    	<a href="#" class="lateral_link" style="font:7px Tahoma, Geneva, sans-serif;">Recuperar Password</a>
               		</div>
                  
           		</div>  
       		  	<!-- PARA ALTERAR QUANDO TIVER O PHP --><a id="centra"><a/>
                <div style=" float:left; margin-left:15px;margin-top:12px">
             		<input name="login2" type="text" class="inputbox" id="login2" style=" width:170px" size="10" value="Username (login)"  onfocus="this.value=''" autocomplete="off">
				</div>
               
				 <div style=" float:left; margin-left:15px;margin-top:8px">
              		<input name="passwd" type="password" class="inputbox" id="passwd" style="width:170px;"  size="10" value="Password" onfocus="this.value=''" autocomplete="off">
 				</div>
                <div name="log_erro" id="log_erro" style="float: none; color: red; margin-left:24px ; vertical-align:text-bottom; font-size: 10px "></div>
                <div style=" float:left; margin-left:12px;margin-top:12px">
                	<input type="button" value="ENTRAR"name="loggar" id="loggar" style="width:70px; font:10px Tahoma, Geneva, sans-serif; margin:4px"/>
                </div>
              <div style=" float:left; margin-left:15px;margin-top:12px">
                	<input type="button" value="REGISTAR"name="registar_log" id="registar_log"  style=" width:80px; font:10px Tahoma, Geneva, sans-serif; margin:4px"/>
                    
                    <!-- PARA ALTERAR QUANDO TIVER O PHP -->
              </div>
                
            </div>
            <div name="meteo" id="meteo" style="width:100%; height:150px">
            
			<div style=" float:left;margin-top:0px; margin-left:20px;">
				<?php echo '<img style="width:150px;" src="'.$imagem.'">';?>
   			</div>	 
       	 	<div style=" float:left; margin-left:15px;margin-top:5px;font-family: Consolas;font-size:28px; color: #FFF;text-shadow: 1px 2px 12px #EEE;">
        		<?php echo $temperatura."&degC<font size='5'> - ".$cidade."</font> <p style='margin-top:0px;font-size:13px;'>" .$mensagem. "</p><p style='margin-top:-5px; font-size:13px;'>Vento: ".$velo_vento." Km/h - ".$direcao."</p><p style='margin-top:-4px;font-size:13px;'> Min: ".$min."&degC - Max: ".$max."&degC</p>"; ?>
        	</div>
            </div>
            
            
		</div><!--FIM DIV LOGIN -->  	
        
        
		<div class="degrade"  style="  height: 800px; width: 100%;">
    	
        	<div id="central" style=" height: 775px ;float:left ; width:770px;  color:#6c6c6c;font:12px Tahoma, Geneva, sans-serif;background-color:#F6F3F6 ;margin:10px 10px 10px 10px; border-radius:10px; border-width:0px;border-color:#D5D6DA; box-shadow: 3px 3px 5px 2px rgba(55, 55, 55, 0.3); background-image:url(images/backg.jpg) "> 
				<div class="lateral_titulo" name="titulo_centro" id="titulo_centro" style=" ">
    				INICIO <!-- ESCREVER COM PHP DE ONDE VENHO E PARA ONDE VOU -->
                   		
                            <div  name="nome_log" id="nome_log"style="float:right; margin-left:15px; margin-right:15px; font:10px Tahoma, Geneva, sans-serif;" >
                            
                            </div>
                            <div name="log_off" id="log_off"style="float:right; margin-right:15px; font:11px bold Tahoma, Geneva, sans-serif;">
                           
                            </div>
                  		
              </div>
                            
                            <div id="centro_principal" name="centro_principal" style="margin:15px; float:left; width: 740px; height: 718px; "></div>
			</div>
		</div>
		<div id="rodape" style=" border-top-style:solid; border-top-width:thin; border-top-color:#999 ;background:linear-gradient(to bottom, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%);clear:both;text-align:center;font: 12px Tahoma, Geneva, sans-serif;color:#444;height: 20px;padding:10px 5px 1px 10px ;text-shadow: 4px 4px 4px #999">2014 - Projecto Horto Pericial. Todos os Direitos Reservados. Realizado por: Artur Carranquinha; Bruno Mestre; Nelson Fernandes </div>
	</div>
</div>

<div id="dialog-form" title="Registo de Novo Utilizador" style="overflow:hidden">
  <p class="validateTips">Todos os campos são necessários.</p>
 
  <form>
    <fieldset>
      <label for="name">Nome</label>
      <input type="text" name="name" id="name" value="Nome Completo" onfocus="apagar(this.id)" class="text ui-widget-content ui-corner-all">
      <label for="email">Email (Login)</label>
      <input type="text" name="email" id="email" value="E-mail" onfocus="apagar(this.id)" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" onfocus="apagar(this.id)" class="text ui-widget-content ui-corner-all">
 	 <label for="password">Confirmar Password</label>
      <input type="password" name="c_password" id="c_password" value="yyyyyyy" onfocus="apagar(this.id)" class="text ui-widget-content ui-corner-all">
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit"  tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
 


</body>
</html>
