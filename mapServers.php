<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example</title>
   
<?php
@session_start();
include("inc/serversf.php");

echo '
	 <script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key=AIzaSyDKf0etDDpk0jStsehtRX3TSQaK8pU98mY&sensor=true"
            type="text/javascript"></script>		
    <script type="text/javascript">

    function initialize() 
	{
      if (GBrowserIsCompatible()) 
	  {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(34.85, 135.6167), 2);
        map.setUIToDefault();
		
		var baseIcon = new GIcon(G_DEFAULT_ICON);
		baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
		baseIcon.iconSize = new GSize(25, 34);
		baseIcon.shadowSize = new GSize(37, 34);
		baseIcon.iconAnchor = new GPoint(9, 34);
		baseIcon.infoWindowAnchor = new GPoint(9, 2);

		function createMarker(point,state,name,ip) 
		{
		  var icone = new GIcon(baseIcon);
		  
		  switch (state)
		  {
		  		case "Online":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/green-dot.png";
					break;
				case "Offline":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
					break;
				case "Failed":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/orange-dot.png";
					break;
				case "Locked":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/purple-dot.png";
					break;
				case "Laggy":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
					break;
				case "Laggy2":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
					break;
				case "Pending":
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
					break;
				case "YS":
					icone.image = "im/yspa.png";
					break;
				case "you":
					icone.image = "im/white.png";
					break;
				default:
					icone.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/orange-dot.png";
			}
			
		  markerOptions = { icon:icone };
		  var marker = new GMarker(point, markerOptions);
		
		  GEvent.addListener(marker, "click", function() {
			    marker.openInfoWindowHtml(name+"<br><b><font size=2>" + ip + "</font></b>");});
		  
		  return marker;
		}
		var point = new GLatLng(40.4439,-79.9562);
		var state = "YS";
		var name  = "Soji Yamakawa";
		var ip    = "YSFlight programmer";
  		map.addOverlay(createMarker(point, state, name, ip));
		

		';
if ( isset($_SESSION['coord']) )	
{
	$lat  = $_SESSION['coord'][0];
	$long = $_SESSION['coord'][1];
	echo 'map.addOverlay(createMarker(new GLatLng('.$lat.' ,'.$long.' ),"you","","You are here!"));
			';
	echo 'map.setCenter(new GLatLng('.$lat.', '.$long.'), 3);';
}
if ( (isset($_GET['long'])) && (isset($_GET['long'])) )
	echo 'map.setCenter(new GLatLng('.$_GET['lat'].', '.$_GET['long'].'), 4);';
$sf        = new Serversf();
$dir       = opendir('servers/');
$i=0;
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$sf->readf($read_file);
		if ( ($sf->lat !=0) && ($sf->long !=0) )
		{
			echo 'map.addOverlay(createMarker(new GLatLng('.$sf->lat.' ,'.$sf->long.' ),"'.$sf->isOnline.'","'.$sf->serverName.'","'.$sf->ip.'"));
			';
			$i++;
		}
	}
}
echo '}
    }

    </script>';
		
?>
	
      
  </head>
  <body onload="initialize()" onunload="GUnload()">
<a href="index.php">&lt;&lt;-- Back to the server list</a>
<br>
    <div id="map_canvas" style="width: 1000px; height: 600px"></div>
	<br><br>
	<b><font size = "2">Warning: the states (Online/Offline) of the servers below are not updated, come back to the <a href='index.php'>server list</a> to get the updated states of the servers. <br>Nevertheless, this list is sorted so that you see the closest servers (if you have set your latitudes and longitudes in the fields below).</font></b><br><br>
	<br><br>
	<form action="coord.php" method="post">
  <font size="2"><strong>My coordinates</strong></font>: &nbsp;&nbsp;<font size="2">Latitude 
  <input name="lat" type="text" size="15" maxlength="30" value="<?php if (isset($_SESSION["coord"])) echo $_SESSION["coord"][0] ?>">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Longitude 
  <input name="long" type="text" size="15" maxlength="30" value="<?php if (isset($_SESSION["coord"])) echo $_SESSION["coord"][1] ?>">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="submit" name="Submit2" value="Change">
  
  <br>
  <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Get 
  your coordinates.</a><br>
  This will enable to see the distance between you and the servers!</font><br><br>
</form>
<br>

<?php 
if ( !isset($_SESSION['coord']) )	
{
	$_SESSION['coord']=array(0,0);
}
	include("inc/math.php");
	$sf        = new Serversf();
	$servers   = "";
	$nb        = 0;
	$dir       = opendir('servers/');
	while ($read_file = readdir($dir)) 
	{
		if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
		{
			$sf->readf($read_file);
			$dist = 999999;
			if ( ($sf->lat !=0) && ($sf->long !=0) )
			{
				$c2 = array($sf->lat,$sf->long);
				$dist = round(geoDist($_SESSION['coord'],$c2),0);
			}
			$servers[] =array(
				'state'      => $sf->isOnline,
				'serverName' => $sf->serverName,
				'ip'         => $sf->ip, 
				'country'    => (strpos($sf->country,"-")===false ? strtolower($sf->country) : strtolower(substr(strstr($sf->country,"-"),1))),
				'diste'       => intval($dist),
				'openedLast' => time()-$sf->openedLast
				);
			$nb++;
		}
	}


foreach ($servers as $key => $row) 
{
   $state[$key]       = $row['state'];
   $serverName[$key]  = $row['serverName'];
   $ip[$key]          = $row['ip'];
   $country[$key]     = $row['country'];
   $diste[$key]       = $row['diste'];
   $openedLast[$key]  = $row['openedLast'];   
}
array_multisort($diste, SORT_ASC, $serverName, SORT_ASC, $servers);
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr> 
	<td><font size="2"><strong>State</strong></font></td>
     <td><font size="2"><strong>Server</strong></font></td>
	<td><font size="2"><strong>Country</strong></font></td>
	<td><font size="2"><strong>IP:port</strong></font></td>
	<td><font size="2"><strong>Distance</strong></font></td>
	<td><font size="2"><strong>Last open time</strong></font></td>
	</tr>

<?php

$i = 0;
while ($i < $nb)
{
	echo '<tr><td>'.state($servers[$i]["state"]).'</td><td><strong>'.$servers[$i]["serverName"].'</strong></td><td><img src="im/flags/'.$servers[$i]["country"].'.gif" title="'.$servers[$i]["country"].'"></img></td><td><font size="2"><strong>'.$servers[$i]["ip"].'</strong></font></td><td><font size="2">'.$servers[$i]["diste"].' Km</font></td><td>';
	if ($servers[$i]["state"] != "Online")
		echo '<font size="2"><em>Opened '.convert_sec($servers[$i]["openedLast"],true).' ago</em>'; 
	echo '</td></tr>';
	$i++;
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

