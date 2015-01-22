<?php 
@header('Refresh: 600; URL=players3.php');
?>
<html>
<head>
</head>
<body>
<?php
include("inc/func.php");
$timer2 = new Timer("players3");
include("inc/serversf.php");
include("serverCheck.php");

echo '<table>';



$sf        = new Serversf();
$dir       = opendir('servers/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$sf->readf($read_file);
		if  (time()-($sf->timestamp)>350)
			ys_params($sf->ip,$sf->port,2,$sf);
		if ($sf->isOnline != "Offline")
		{
			
			$a       = $sf->usera;
			if (count($a)>1)
			{
				echo '<td><a href="ysflight://'.$sf->ip.'"><font size="2"><strong title="'.$sf->ip.':'.$sf->port.'">'.$sf->serverName.'</strong></font></a></td><td>';
				for ($i=0 ; $i < count($a); $i++)
				{
					$color=($a[$i][0]==1? "BB0000" : "000099");
					echo '<font color="#'.$color.'" size="2">'.$a[$i][3].'</font>';
					echo ($i+1 < count($a) ? ', ' : '');
				}
				$a=array();
				echo "</td></tr>";
			}
		}
	}
}


echo '</table>';
$timer2->stop();
?>
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
