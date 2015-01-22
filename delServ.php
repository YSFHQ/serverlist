   <?php 
include("inc/func.php");
include("inc/serversf.php");
if ( (isset($_GET["ip"])) && (isset($_GET["port"])) ) 
{
	if ( gethostbyname($_SERVER['REMOTE_ADDR']) == gethostbyname($_GET["ip"]) )
	{
		$sf        = new Serversf();
		$sf->read($_GET["ip"],$_GET["port"]);
		if (unlink("servers/".$_GET["ip"]."_".$_GET["port"].".txt"))
		{
			@header('Refresh: 2; URL=index.php');
			unlink("servers/".$_GET["ip"]."_".$_GET["port"].".txt.flock");
			echo "Server deleted. Redirecting...";
			journal ('<p> <img src="im/del_server.png" width="20" height="20" border="1"> '.date("d").' - The server '.$sf->serverName.' was deleted</p>');
		}
		else
			die("Server not found");
	}
	else
		die ("It's not your server!");	
}
else 
	die("No server specified :(");

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
