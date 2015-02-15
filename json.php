<?php
include("inc/serversf.php");
include("inc/func.php");
//$timer4 = new Timer("json_".$_GET["ip"]);
include("serverCheck.php");
$sf        = new Serversf();
$sf->read($_GET["ip"],$_GET["port"]);

if ($sf->isOnline == "Offline")
	$timeout = 2;
else
	$timeout = 3;

if  (time()-($sf->timestamp)>300)//300
	ys_params($_GET["ip"],$_GET["port"],$timeout,$sf,$sf->version);
	
// PROTECTION POUR SERVER QUI N EXISTE PAS -> non vide? //<<DA FUCK BRAH? I DON'T SPEAK NINTENDO!

$weathert = explode(":",$sf->weather);
$daynight = ($weathert[0]<=65536) ? "day" : "night"; //Was ...[0]==1, which is incorrect. YSF Lighting is 0-65536 == Day, 65537 > ... == Night. ;)
$blackout = ($weathert[1]==1) ? "blackout_on" : "blackout_off";
$coll     = ($weathert[2]==1) ? "collisions_on" : "collisions_off";
$landev   = ($weathert[3]==1) ? "landev_on" : "landev_off";
$missile  = ($sf->missile==1)  ? "missiles_on" : "missiles_off";	
$weapon   = ($sf->weapon==1)   ? "weapon_on" : "weapon_off";
			
			
$datas = array(
	'serverName' => $sf->serverName, 
	'ip'         => $sf->ip,
	'port'       => $sf->port,
	'owner'      => $sf->owner,
	'country'    => $sf->country,
	'long'       => $sf->long,
	'lat'        => $sf->lat,
	'os'         => $sf->os,
	'version'    => $sf->version,
	'isOnline'   => $sf->isOnline,
	'state'      => state($sf->isOnline),
	'map'        => '<a href="http://marcjeanmougin.free.fr/ys_servers/index.php?page=mapToLink.php&map='.str_replace("'",' ',$sf->map).'" target="_blank">'.$sf->map.'</a>',
	'optiones'   => options ($blackout, $coll, $landev, $missile, $weapon, $sf->radar, $sf->extview, $sf->showUser),
	'players'    => players ($sf->users,$sf->flying),
	'weather'    => weather ($daynight, $weathert),
	'timestamp'  => $sf->timestamp,
	'website'    => $sf->website,
	'TS_ip'      => $sf->TS_ip,
	'TS_port'    => $sf->TS_port,
	'clock'      => clock(time()-intval($sf->timestamp),$sf->openTime,$sf->openedLast)
);
//log2("Seeing ".$_GET["ip"],"Json");		
echo json_encode($datas);
//header("X-JSON: " . json_encode($datas));
//$timer4->stop();
?>
