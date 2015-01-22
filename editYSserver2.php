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


setcookie("owner",   $_POST["owner"],   time()+31536000);
setcookie("website", $_POST["website"], time()+31536000);
setcookie("port",    $_POST["port"],    time()+31536000);
setcookie("name",    $_POST["name"],    time()+31536000);
setcookie("TS_port", $_POST["TS_port"], time()+31536000);
setcookie("lat",     $_POST["lat"],     time()+31536000);
setcookie("long",    $_POST["long"],    time()+31536000);

$country=get_lang();
$os=get_OS($_SERVER['HTTP_USER_AGENT']);

if (gethostbyname($_POST["ip"])!=$_SERVER['REMOTE_ADDR'])
{
	die("You are not allowed to edit a server which is not yours!");
}





if ( !file_exists("servers/".$_POST["ip"] ."_".$_POST["port"].".txt") )
{
	die( "You cannot edit a server which is not in the list");
}
else
{
		$sf = new Serversf();
		$sf->read($_POST["ip"],$_POST["port"]);
		$sf->setIp         ($_POST["ip"]);
		$sf->setPort       ($_POST["port"]);
		$sf->setServerName ($_POST["name"]);
		$sf->setCountry    ($_POST["country"]);
		$sf->setOs         ($os);
		$sf->setWebsite    ($_POST["website"]);
		$sf->setOwner      ($_POST["owner"]);
		$sf->setTS_ip      ($_POST["TS_ip"]);
		$sf->setTS_port    ($_POST["TS_port"]);
		$sf->setLat        ($_POST["lat"]);
		$sf->setLong       ($_POST["long"]);
		$sf->write();

}
@header('Refresh: 3; URL=index.php');
echo "<br><br>Redirecting...";


echo "
	<SCRIPT LANGUAGE='JavaScript'>
	<!--
	function redirect()
	{
	window.location='index.php'
	}
	window.setTimeout(redirect,2000);
	-->
		</SCRIPT>";
?>


