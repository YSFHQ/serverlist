<html>
<head>
<title>Live Statistics</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<a href="index.php">&lt;&lt;-- Back to the server list</a>
<br>
<?php

include("inc/serversf.php");
$sf        = new Serversf();
$dir       = opendir('servers/');
$servers   = "";
$nb        = 0;
$max       = 1;
$maxPop    = 0.000000000000001;
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$sf->readf($read_file);
		if (intval($sf->openTime)>0)
			$popu = floatval($sf->popularity)/floatval($sf->openTime);
		else
			$popu = 0;
		$max    = max($max,intval($sf->openTime));
		$maxPop = max($maxPop,$popu);
		$servers[] =array('serverName' => $sf->serverName,
		                  'ip'         => $sf->ip, 
						  'openTime'   => intval($sf->openTime),
						  'pop'        => $popu
						  );
		$nb++;
	}
}

foreach ($servers as $key => $row) 
{
   $serverName[$key]  = $row['serverName'];
   $ip[$key]          = $row['ip'];
   $openTime[$key]   = $row['openTime'];
   $pop[$key]         = $row['pop'];
}
$servers2 = $servers;
array_multisort($openTime, SORT_DESC, $serverName, SORT_ASC, $servers);
?>
<strong><font size="5"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000066"></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000066"></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000066"></font>LIVE 
STATISTICS  -- New >> <a href="daily_stats.php">Day statistics</a></font></strong> 
<p>&nbsp; </p>
Older statistics:<br>
<?php
$dir       = opendir('oldStats/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!=".."))
	{
		echo "<a href='oldStats/".$read_file."'>".substr($read_file,0,-4)."</a> &nbsp;&nbsp;&nbsp;&nbsp;";
	}
}
?>
<br>
<br>

<div align="left"><font size="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000066">Open 
  time </font></font></div>
<p>&nbsp;</p><table>
	<tr><td>Name</td><td><strong><font size="2">IP</font></strong></td><td>Open Time</td></tr>
<?php
$i = 0;
while ($i < $nb)
{
	echo "<tr><td>".$servers[$i]["serverName"]."</td><td><strong><font size='2'>".$servers[$i]["ip"]."</font></strong></td><td><img src='im/bord.png' height='10' width='1'><img src='im/barre2.png' title='".convert_sec($servers[$i]["openTime"],true)."' width='".($servers[$i]["openTime"]/$max*400)."' height='10'><img src='im/bord.png' height='10' width='1'></td></tr>\r\n";
	$i++;
}


?>
</table>

<p align="left">&nbsp;</p>
<p align="left"><br>
  <font size="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000066">Average Number of users by hour.</font></font></p>
<table>
  <tr>
    <td>Name</td>
    <td><strong><font size="2">IP</font></strong></td>
    <td>Popularity</td>
  </tr>
  <?php

array_multisort($pop, SORT_DESC, $serverName, SORT_ASC, $servers2);
$i = 0;
while ($i < $nb)
{
	echo "<tr><td>".$servers2[$i]["serverName"]."</td><td><strong><font size='2'>".$servers2[$i]["ip"]."</font></strong></td><td><img src='im/bord.png' height='10' width='1'><img src='im/barrem.png' title='".($servers2[$i]["pop"])." users by hour' width='".($servers2[$i]["pop"]/$maxPop*400)."' height='10'><img src='im/bord.png' height='10' width='1'></td></tr>\r\n";
	$i++;
}

//array_multisort($pop, SORT_ASC, $serverName, SORT_ASC, $servers);
?>
</table>
<br>
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
