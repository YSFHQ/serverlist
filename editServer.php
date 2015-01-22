<html>
<head>
<title>Edit</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<a href="index.php">&lt;&lt;-- Back to the server list</a>
<br>
Choose a server to modify<br>

<table width="713" cellpadding="5" cellspacing="5">
  <tr><td width="154">Name</td><td width="157"><strong><font color="#000066" size="2">IP:port</font></strong></td><td width="223">Action</td></tr>

<?php

include("inc/serversf.php");
$sf        = new Serversf();
$dir       = opendir('servers/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$splitPos = strpos($read_file,"_");
		$fip      = substr($read_file,0,$splitPos);
		$fport    = intval(substr($read_file,$splitPos+1,-4));
		$sf->readf($read_file);
		echo "<tr><td><font size='2'>".$sf->serverName."</font></td><td><font size='2' color=#000066><strong>".$fip."</strong>:".$sf->port."</font></td><td><font size='2'>";
		if (gethostbyname($fip) == gethostbyname($_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"]))
			echo "<a href='editYSserver.php?ip=".$sf->ip."&port=".$sf->port."'>Edit</a> | <a href='delServ.php?ip=".$sf->ip."&port=".$sf->port."'>Delete</a>";
		else
			echo "";
		echo "</font></td></tr>";
	}
}
?>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-8462049-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
