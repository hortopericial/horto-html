

<?php

$cod_faro = "740869";
$conteudo_xml=file_get_contents("http://weather.yahooapis.com/forecastrss?w=".$cod_faro."&u=c");
$xml = new SimpleXMLElement($conteudo_xml);
$local = $xml->xpath("//channel/yweather:location");
$estado_tempo = $xml->xpath("//channel/yweather:wind");
$cond_tempo = $xml->xpath("//channel/item/yweather:condition");
$astron = $xml->xpath("//channel/yweather:astronomy");
$prev = $xml->xpath("//channel/item/yweather:forecast");
$aprev=$prev[1]->attributes();
$a_astron=$astron[0]->attributes();
$a_local = $local[0]->attributes();
$a_estado = $estado_tempo[0]->attributes();
$a_cond = $cond_tempo[0]->attributes();
$nas_sol=(string)$a_astron->sunrise;
$por_sol =(string)$a_astron->sunset;
$cidade = (string) $a_local->city;
$pais = (string) $a_local->country;
$reallfeel = (string) $a_estado->chill;
$velo_vento = (int) $a_estado->speed;
$graus = (int) $a_estado->direction;
$cond_img = (int) $a_cond-> code;
$temperatura = (int) $a_cond->temp;
$t=time();
$min=(int)$aprev->low;
$max=(int)$aprev->high;
$agora=(int) date("H",$t);
$nasce_sol= explode(":",$nas_sol);
$pordo_sol= explode(":",$por_sol);
$pordo_sol=(int)$pordo_sol[0];
$nasce_sol=(int)$nasce_sol[0];
if ($cond_img == 0) $imagem= ("/wimagens/tornado.png");
else if ($cond_img == 1) $imagem= ("/wimagens/tropical storm.png");
else if ($cond_img == 2) $imagem= ("/wimagens/hurricane.png");
else if ($cond_img == 3) $imagem= ("/wimagens/severe thunderstorms.png");
else if ($cond_img == 4 && $nas_sol<$agora && $por_sol>$agora) {$imagem= ("/wimagens/thunderstorms.png"); $mensagem= ("Chuva com trovoadas");}
else if ($cond_img == 4 && $nas_sol>=$agora && $por_sol<=$agora) {$imagem=("/wimagens/Night/Thunderstorms.png"); $mensagem= ("Chuva com trovoadas");}
else if ($cond_img == 5) $imagem= ("/wimagens/mixed rain and snow.png");
else if ($cond_img == 6) $imagem= ("/wimagens/mixed rain and sleet.png");
else if ($cond_img == 7) $imagem= ("/wimagens/mixed snow and sleet.png");
else if ($cond_img == 8) $imagem= ("/wimagens/Freezing Drizzle.png");
else if ($cond_img == 9) $imagem= ("/wimagens/Drizzle.png");
else if ($cond_img == 10) $imagem= ("/wimagens/Freezing rain.png");
else if ($cond_img == 11) {$imagem= ("/wimagens/Showers.png");$mensagem=("Aguaceiros");}
else if ($cond_img == 12) {$imagem= ("/wimagens/Showers.png");$mensagem=("Aguaceiros");}
else if ($cond_img == 13) $imagem= ("/wimagens/Snow flurries.png");
else if ($cond_img == 14) $imagem= ("/wimagens/light snow showers.png");
else if ($cond_img == 15) $imagem= ("/wimagens/blowing snow.png");
else if ($cond_img == 16) $imagem= ("/wimagens/snow.png");
else if ($cond_img == 17) $imagem= ("/wimagens/hail.png");
else if ($cond_img == 18) $imagem= ("/wimagens/Sleet.png");
else if ($cond_img == 19) $imagem= ("/wimagens/dust.png");
else if ($cond_img == 20 && $nas_sol<$agora && $por_sol>$agora) $imagem= ("/wimagens/foggy.png");
else if ($cond_img == 20 && $nas_sol>=$agora && $por_sol<=$agora) $imagem=("/wimagens/Night/foggy.png");
else if ($cond_img == 21&& $nas_sol<$agora && $por_sol>$agora) $imagem= ("/wimagens/Haze.png");
else if ($cond_img == 21&& $nas_sol>=$agora && $por_sol<=$agora) $imagem= ("/wimagens/Night/Haze.png");
else if ($cond_img == 22) $imagem= ("/wimagens/Smoke.png");
else if ($cond_img == 23) $imagem= ("/wimagens/blustery.png");
else if ($cond_img == 24) $imagem= ("/wimagens/Windy.png");
else if ($cond_img == 25) {$imagem= ("/wimagens/cold.png"); $mensagem= ("Ta um frio de rachar");}
else if ($cond_img == 26) {$imagem= ("/wimagens/Cloudy.png"); $mensagem= ("Ceu nublado");}
else if ($cond_img == 27) {$imagem= ("/wimagens/Night/Mostly Cloudy.png");$mensagem=("Céu Muito Nublado");}
else if ($cond_img == 28) {$imagem= ("/wimagens/Mostly Cloudy.png");$mensagem=("Céu Muito Nublado");}
else if ($cond_img == 29) {$imagem= ("/wimagens/Night/Partly cloudy.png");$mensagem=("Céu Praticamente Limpo");}
else if ($cond_img == 30) {$imagem= ("/wimagens/Partly cloudy.png");$mensagem=("Céu Praticamente Limpo");}
else if ($cond_img == 31) {$imagem= ("/wimagens/Night/clear.png");$mensagem=("Céu Limpo");}
else if ($cond_img == 32){ $imagem= ("/wimagens/Sunny.png"); $mensagem=("Céu Limpo");}
else if ($cond_img == 33 ){$imagem= ("/wimagens/Night/fair.png"); $mensagem=("Céu Praticamente Limpo");}
else if ($cond_img == 34 ) {$imagem= ("/wimagens/fair.png");  $mensagem=("Céu Praticamente Limpo");}
else if ($cond_img == 35) $imagem= ("/wimagens/mixed rain and hail.png");
else if ($cond_img == 36) $imagem= ("/wimagens/hot.png");
else if ($cond_img == 37 && $nas_sol<$agora && $por_sol>$agora) $imagem= ("/wimagens/isolated thunderstorms.png");
else if ($cond_img == 37 && $nas_sol>=$agora && $por_sol<=$agora) $imagem= ("/wimagens/Night/isolated Thunderstorms.png");
else if ($cond_img == 38) $imagem= ("/wimagens/Scattered thunderstorms.png");
else if ($cond_img == 39) $imagem= ("/wimagens/Scattered thunderstorms.png");
else if ($cond_img == 40) $imagem= ("/wimagens/Scattered Showers.png");
else if ($cond_img == 41) $imagem= ("/wimagens/heavy snow.png");
else if ($cond_img == 42) $imagem= ("/wimagens/scattered snow showers.png");
else if ($cond_img == 43) $imagem= ("/wimagens/heavy snow.png");
else if ($cond_img == 44) $imagem= ("/wimagens/Partly cloudy.png");
else if ($cond_img == 45) $imagem= ("/wimagens/thundershowers.png");
else if ($cond_img == 46) $imagem= ("/wimagens/Snow showers.png");
else if ($cond_img == 47) $imagem= ("/wimagens/isolated thundershowers.png");
else if ($cond_img == 3200) $imagem= ("/wimagens/default_weather_icon.png");
//echo $cond_img;
if ($velo_vento!=0)
	{
    if($graus >= 0 && $graus <= 11.25) $direcao = 'Norte';
    else if($graus > 348.76 && $graus <= 360) $direcao = 'Norte';
    else if($graus > 11.25 && $graus <= 33.75) $direcao = 'Nor-Nordeste';
    else if($graus > 33.75 && $graus <= 56.25) $direcao = 'Nordeste';
    else if($graus > 56.25 && $graus <= 78.75) $direcao = 'Es-Nordeste';
    else if($graus > 78.75 && $graus <= 101.25) $direcao = 'Este';
    else if($graus > 101.25 && $graus <= 123.75) $direcao = 'Es-Sudeste';
    elseif($graus > 123.75 && $graus <= 146.25) $direcao = 'Sudeste';
    else if($graus > 146.25 && $graus <= 168.75) $direcao = 'Su-Sudeste';
    else if($graus > 168.75 && $graus <= 191.25) $direcao = 'Sul';
    else if($graus > 191.25 && $graus <= 213.75) $direcao = 'Su-Sudoeste';
    else if($graus > 213.75 && $graus <= 236.25) $direcao = 'Sudoeste';
    else if($graus > 236.25 && $graus <= 258.75) $direcao = 'Oes-Sudoeste';
    else if($graus > 258.75 && $graus <= 281.25) $direcao = 'Oeste';
    else if($graus > 281.25 && $graus <= 303.75) $direcao = 'Oes-Noroeste';
    else if($graus > 303.75 && $graus <= 326.25) $direcao = 'Noroeste';
    else if($graus > 326.25 && $graus <= 348.75) $direcao = 'Nor-Nordeste';
	}
else
{
	$direcao ="";
}
//echo $cond_img;

?>