<?php

include("inc/func.php");
include("inc/serversf.php");

$timestamp=time();

$_POST["port"]    = intval($_POST["port"]);
$_POST["TS_port"] = intval($_POST["TS_port"]);
$_POST["owner"]   = filter($_POST["owner"]);
$_POST["name"]    = filter($_POST["name"]);
$_POST["website"] = filter($_POST["website"]);
$_POST["ip"]      = filter($_POST["ip"]);
$_POST["TS_ip"]   = filter($_POST["TS_ip"]);
$_POST["country"] = filter(substr($_POST["country"],0,-4));
$_POST["lat"]     = floatval($_POST["lat"]);
$_POST["long"]    = floatval($_POST["long"]);

if (strtolower(substr($_POST["website"], 0, 7)) != "http://")
	$_POST["website"] = "http://"+$_POST["website"];

setcookie("owner",   $_POST["owner"],   time()+31536000);
setcookie("website", $_POST["website"], time()+31536000);
setcookie("port",    $_POST["port"],    time()+31536000);
setcookie("name",    $_POST["name"],    time()+31536000);
setcookie("TS_port", $_POST["TS_port"], time()+31536000);
setcookie("lat",     $_POST["lat"],     time()+31536000);
setcookie("long",    $_POST["long"],    time()+31536000);

$country=get_lang();
$os=get_OS($_SERVER['HTTP_USER_AGENT']);

$by="";
if (gethostbyname($_POST["ip"])!=$_SERVER['REMOTE_ADDR'])
{
	$by = " added by an unknown user.";
	//die("You are not allowed to add a server which is not yours!");
}


if ($_POST["name"] =="")
	die("Sorry, the field 'Name' should not be empty.");

$dir       = opendir('servers/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$splitPos = strpos($read_file,"_");
		$fip      = substr($read_file,0,$splitPos);
		$fport    = intval(substr($read_file,$splitPos+1,-4));
		if ( (gethostbyname($fip) == gethostbyname($_POST["ip"])) && ($_POST["port"]==$fport) )
			die("Your server is already in the list");
	}
}

if ( file_exists("servers/".$_POST["ip"] ."_".$_POST["port"].".txt") )
{
	die( "Sorry, your server is already in the list");
}
else
{
	include("inc/ys_protocol.php");
	$ys=new YS_protocol(true);
	$ys->setDebug(false);
	$state = $ys->YSconnect($_POST["ip"], $_POST["port"], 3);
	if ($state == "Online")
	{
		$sf = new Serversf();
		//$ys->setVersion (20080220);
        $ys->packetDecode();
		$sf->setVersion ($ys->version);
		$sf->setMissile ($ys->missile);
		$sf->setWeapon  ($ys->weapon);
		$sf->setMap     ($ys->map);
		$a = $ys->getUserList();
		$sf->setUsers   ($a[count($a)-2]);
		$sf->setFlying  ($a[count($a)-1]);
		$sf->setWeather ($ys->weather);
		$sf->setIsOnline("Online");
		$sf->setIp         ($_POST["ip"]);
		$sf->setPort       ($_POST["port"]);
		$sf->setServerName ($_POST["name"]);
		$sf->setCountry    ($_POST["country"]);
		$sf->setOs         ($os);
		$sf->setWebsite    ($_POST["website"]);
		$sf->setOwner      ($_POST["owner"]);
		$sf->setTimestamp  ();
		$sf->setTS_ip      ($_POST["TS_ip"]);
		$sf->setTS_port    ($_POST["TS_port"]);
		$sf->setLat        ($_POST["lat"]);
		$sf->setLong       ($_POST["long"]);
		$sf->setOpenedLast();
		$sf->setDelOnExit  ((validateIpAddress($_POST["ip"])? 1 : 0)); // servers with ip addresses using numbers are automatically deleted when offline
		$sf->write();
		
		journal ('<p> <img src="im/new_server.png" width="20" height="20" border="1"> '.date("d").' - New 
  server: '.$_POST["name"].' '.$by.'</p>');
	}

	elseif ($state == "Locked")
	{
		echo "Your server is locked!";
	}
	elseif ($state == "Failed")
	{
		echo "I got troubles to connect your server, press F5.";
	}
	elseif ($state == "Offline")
	{
		echo "Your server is offline, I cannot add it to the list.";
	}
}
//@header('Refresh: 6; URL=index.php');
echo "<br><br><font color='#CC0000'><b>New rule:<br>";
$message = (validateIpAddress($_POST["ip"])? "Your server will be automatically deleted once offline. Use a dyndns or an other no-ip system if you want to keep your server in the list." : "Your server will be automatically deleted after 8 days of inactivity.");
echo $message;
echo "</b></font><br><br>Redirecting...";


echo "
	<SCRIPT LANGUAGE='JavaScript'>
	<!--
	function redirect()
	{
	window.location='index.php'
	}
	window.setTimeout(redirect,6000);
	-->
		</SCRIPT>";
?>

