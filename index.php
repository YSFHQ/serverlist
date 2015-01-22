<?php


@session_start();
$refresh   = 150+rand(-30, 30);
include("inc/math.php");


if (!isset($_GET["ajax"]))
{
	/* include("cronServers.php");
	if ($toupdate>1)
		$refresh = 1; */
//	@header('Refresh: '.$refresh.'; URL=index.php?ajax=no');
	echo "
		<SCRIPT LANGUAGE='JavaScript'>
		<!--
		function redirect()
		{
		window.location='index.php?ajax=yes'
		}
		window.setTimeout(redirect,0);
		-->
		</SCRIPT>";
	$echoJava = "";
}
else
{
	if ($_GET["ajax"]=="no")
	{
		include("cronServers.php");
		if ($toupdate>1)
			$refresh = 1;
		@header('Refresh: '.$refresh.'; URL=index.php?ajax=no');
		$echoJava = "<b><font color='#FF0000'>Warning: this page uses javascript to speed up its loading and reduce the bandwith.<br> Once you have enabled javascript, please, do not reload this page, but <a href='ysServerlist'>click here</a>.</font></b><br><br>";
	}
	else
	{
		include("inc/serversf.php");
		include("inc/func.php");
		@header('Refresh: 1200; URL=index.php?ajax=yes');
		$echoJava = "";
	}
	$timer5 = new Timer("ysServerlist");
}

		
if ( (isset($_COOKIE["long"])) && (isset($_COOKIE["lat"])) )
{
	$_SESSION['coord']  = array(floatval($_COOKIE["lat"]), floatval($_COOKIE["long"]));
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META NAME="description" CONTENT="Server list of YSFlight servers">
<META NAME="keywords" CONTENT="ys, ysfs, ysflight, yspilots, flight, simulator, server, list, YSPS, YSC, YSChat, aircraft, sim">
<META NAME="dc.keywords" CONTENT="ysflight, yspilots, flight, simulator">
<META NAME="subject" CONTENT="Website about the YSflight servers">
<META NAME="author" CONTENT="VincentWeb">
<META NAME="copyright" CONTENT="YS servers">
<META NAME="revisit-after" CONTENT="15 days">
<META NAME="identifier-url" CONTENT="http://">
<META NAME="reply-to" CONTENT="vincentweb984@hotmail.com">
<META NAME="publisher" CONTENT="Vincent Web">
<META NAME="date-creation-ddmmyyyy" CONTENT="12272008">
<META NAME="Robots" CONTENT="all">
<META NAME="Rating" CONTENT="General">
<META NAME="Category" CONTENT="Other (Server page)">
<META NAME="Page-topic" CONTENT="Other (Server page)">
<META NAME="Generator" CONTENT="Dreamweaver">
<META NAME="contactCity" CONTENT="Toulouse">
<META NAME="contactState" CONTENT="France">
<META NAME="Classification" CONTENT="Ysflight servers">
<META http-equiv="Content-Language" CONTENT="en">
<META http-equiv="Content-type" CONTENT="text/html;charset=iso-8859-1">
<META NAME="location" CONTENT="France, FRANCE">
<META NAME="expires" CONTENT="never">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Audience" CONTENT="General">
<link rel="alternate" type="application/rss+xml"
href= 'http://www.yspilots.com/shadowhunters/rssList.php'/>

<style> 
a:link {
	text-decoration: none;
	}
a:visited {
	text-decoration: none;
}
a:hover {

	color: #BB0000;

	
}
</style>


<title>YSFLIGHT Server List</title>

<?php

if (!isset($_GET["ajax"]))
{
//	@header('Refresh: '.$refresh.'; URL=index.php?ajax=no');
	echo '<meta http-equiv="refresh" content="1; url=index.php?ajax=no" />';
	echo "</head><body></body></html>";	
}
else
{


	if ((preg_match("/Nav/", getenv("HTTP_USER_AGENT"))) || (preg_match("/Gold/", getenv("HTTP_USER_AGENT"))) || 
	(preg_match("/X11/", getenv("HTTP_USER_AGENT"))) || (preg_match("/Mozilla/", getenv("HTTP_USER_AGENT"))) || 
	(preg_match("/Netscape/", getenv("HTTP_USER_AGENT"))) 
	AND (!preg_match("/MSIE/", getenv("HTTP_USER_AGENT"))) AND (!preg_match("/Konqueror/", getenv("HTTP_USER_AGENT")))) 
	  $navigateur = "Netscape"; 
	elseif (preg_match("/Opera/", getenv("HTTP_USER_AGENT"))) 
	  $navigateur = "Opera"; 
	elseif (preg_match("/MSIE/", getenv("HTTP_USER_AGENT"))) 
	  $navigateur = "MSIE"; 
	elseif (preg_match("/Lynx/", getenv("HTTP_USER_AGENT"))) 
	  $navigateur = "Lynx"; 
	elseif (preg_match("/WebTV/", getenv("HTTP_USER_AGENT"))) 
	  $navigateur = "WebTV"; 
	elseif (preg_match("/Konqueror/", getenv("HTTP_USER_AGENT"))) 
	  $navigateur = "Konqueror"; 
	elseif ((preg_match("/bot/", getenv("HTTP_USER_AGENT"))) || (preg_match("/Google/", getenv("HTTP_USER_AGENT"))) || 
	(preg_match("/Slurp/", getenv("HTTP_USER_AGENT"))) || (preg_match("/Scooter/", getenv("HTTP_USER_AGENT"))) || 
	(preg_match("/Spider/", getenv("HTTP_USER_AGENT"))) || (preg_match("/Infoseek/", getenv("HTTP_USER_AGENT")))) 
	  $navigateur = "Bot"; 
	else 
	  $navigateur = "Autre"; 

	if ((isset($_GET["ajax"])) && ($_GET["ajax"]=="yes") )
	{
?>

<script type="text/javascript">
<!--


servers = new Array();

function createXHR() 
{
    var request = false;
        try {
            request = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) {
            try {
                request = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (err3) {
		try {
			request = new XMLHttpRequest();
		}
		catch (err1) 
		{
			request = false;
		}
            }
        }
    return request;
}

function LireCookie(nom)
{
	var arg=nom+"=";
	var alen=arg.length;
	var clen=document.cookie.length;
	var i=0;
	while (i<clen)
	{
		var j=i+alen;
		if (document.cookie.substring(i, j)==arg) return getCookieVal(j);
			i=document.cookie.indexOf(" ",i)+1;
		if (i==0) break;
	}
	return null;
}

function EcrireCookie(nom, valeur)
{
	var argv=EcrireCookie.arguments;
	var argc=EcrireCookie.arguments.length;
	var expires=(argc > 2) ? argv[2] : null;
	var path=(argc > 3) ? argv[3] : null;
	var domain=(argc > 4) ? argv[4] : null;
	var secure=(argc > 5) ? argv[5] : false;
	document.cookie=nom+"="+escape(valeur)+
		((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
		((path==null) ? "" : ("; path="+path))+
		((domain==null) ? "" : ("; domain="+domain))+
		((secure==true) ? "; secure" : "");
}

function cache2(servers, cookie)
{
	//alert("Cache2");
	if ( (cookie=="none") && (document.getElementsByName("boffline")[0].checked == false) || (cookie=="no") )
	{
		EcrireCookie("offline", "no");
		for (var address in servers)
		{
			if ( (servers.hasOwnProperty(address)) && (document.getElementsByName(address)[0] != null) )
			{
				//alert("cache2:"+address+servers[address]);
				if  (servers[address] == "Offline")
					document.getElementsByName(address)[0].style.display='none';
				else
					document.getElementsByName(address)[0].style.display='';
			}
		}
		document.getElementsByName("boffline")[0].checked=false;
	}
	else
	{
		EcrireCookie("offline", "yes");
		for (var address in servers)
		{
			if ( (servers.hasOwnProperty(address)) && (document.getElementsByName(address)[0] != null) )
			{
				document.getElementsByName(address)[0].style.display='';
				//alert("cache2:"+address+servers[address]);
			}
		}
		document.getElementsByName("boffline")[0].checked=true;
	}
}

function refresh (ip,port,restart)
{
	if ( (ip!=undefined)&&(port!=undefined)&&(restart!=undefined) )
	{
		if (restart>300)
		{
			var xhr=createXHR();
			xhr.open("GET", 'json.php?ip='+ip+'&port='+port, true);
			xhr.onreadystatechange=function() 
			{
				if (xhr.readyState == 4) 
				{
					if (xhr.status != 404) 
					{
						var json=eval("(" + xhr.responseText + ")");
						
						document.getElementById(ip+':'+port+':state').innerHTML   = json.state;
						document.getElementById(ip+':'+port+':map').innerHTML     = json.map;
						document.getElementById(ip+':'+port+':players').innerHTML = json.players;
						document.getElementById(ip+':'+port+':weather').innerHTML = json.weather;
						document.getElementById(ip+':'+port+':options').innerHTML = json.optiones;
						document.getElementById(ip+':'+port+':clock').innerHTML   = json.clock;
						servers[ip+":"+port] = json.isOnline;
						
						cache2(servers,LireCookie('offline'));
						if (json.state == '<span style="background-color: #ffff00; font-size: 10px; "><font color="#000000"> Pending </font></span>')
						{
							if (restart != 302)
							{
								window.setTimeout(refresh, 2000+Math.floor(Math.random()*2000),ip,port,302);
							}
							else if (restart == 302)
							{
								window.setTimeout(refresh, 4000+Math.floor(Math.random()*4000),ip,port,303);
							}
							else if (restart == 303)
							{
								window.setTimeout(refresh, 6000+Math.floor(Math.random()*6000),ip,port,304);
							}
							else if (restart == 304)
							{
								window.setTimeout(refresh, 8000+Math.floor(Math.random()*8000),ip,port,305);
							}
							else
							{
								window.setTimeout(refresh, 300000+Math.floor(Math.random()*30001),ip,port,301);
							}
						}
						else
								window.setTimeout(refresh,300000+Math.floor(Math.random()*30001),ip,port,301);
					} 
					else
					{ 
						document.getElementById(ip+':'+port+':clock').innerHTML= '<img src="im/clockj.png" title="Error, resending the request to the server">';
						if (restart != 302)
							window.setTimeout(refresh, 4000,ip,port,302);
					}
				}
			}
			xhr.send(null);
		}
		else
		{
			window.setTimeout(refresh, 300000-restart*1000+Math.floor(Math.random()*30001),ip,port,301);
		}
	}
	
}


function getCookieVal(offset)
{
	var endstr=document.cookie.indexOf (";", offset);
	if (endstr==-1) endstr=document.cookie.length;
		return unescape(document.cookie.substring(offset, endstr));
}



function cache(servers, baliseId, cookie) 
{
  if (document.getElementById && document.getElementById(baliseId) != null) 
    {
		if ( (cookie=="none") && (document.getElementsByName("b"+baliseId)[0].checked == false) || (cookie=="no") )
		{
			<?php 
			if ($navigateur=="MSIE") echo "document.getElementById(baliseId).style.display='none';";
			?>
			document.getElementById(baliseId).style.visibility='collapse';
			EcrireCookie(baliseId, "no");
			document.getElementsByName("b"+baliseId)[0].checked=false;
		}
		else
		{
			<?php 
			if ($navigateur=="MSIE") echo "document.getElementById(baliseId).style.display='block';";
			?>
			document.getElementById(baliseId).style.visibility='visible';
			EcrireCookie(baliseId, "yes");
			document.getElementsByName("b"+baliseId)[0].checked=true;	
		}
		cache2(servers, LireCookie('offline'));
	}
}





function runAll(servers)
{
	cache(servers, 'map', LireCookie('map'));
	cache(servers, 'players', LireCookie('players'));
	cache(servers, 'options', LireCookie('options'));
	cache(servers, 'weather', LireCookie('weather'));
	//cache(servers, 'ts', LireCookie('ts'));
	cache2(servers, LireCookie('offline'));
}


//-->
</script>  
<?php } ?>
<link rel="icon" type="image/png" href="im/newcrow.png" />

</head>
<body bgcolor="#FFFFFF" link="#222244" vlink="#222244" alink="#222244"  leftmargin="5" topmargin="0" rightmargin="5">



<script src="inc/prototype-1.6.0.3.js" type="text/javascript"></script>
<?php echo $echoJava; ?> <font size="2"> <a href="addYSserver.php"> <img src="im/addserver.png" width="20" height="20" border="0"> 
Add</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="editServer.php"><img src="im/edit.png" border="0"> 
Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="mapServers.php"><img src="im/map.png" border="0"> 
Map</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="gadgets.php"><img src="im/desktop.gif" width="20" height="20" border="0"> 
Desktop</a></font><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="stats.php"><img src="im/stats.png" width="20" height="20" border="0"> 
Stats</a></font><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<a href="logRead.php"><img src="im/journal.png" width="20" height="20" border="0">Log</a></font>
<font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="help.php"><img src="im/unknown.png" width="20" height="20" border="0"> Help</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="blacklist.php"><img src="im/weapon_on.png" width="20" height="20" border="0"> Black list</a></font>
<font size="2"><br>
</font> 
<form name="formu">
  <font size="2"> <br>
  <input name="bmap" type="checkbox" value="" onClick="cache(servers, 'map','none')" >
  Map&nbsp;&nbsp; 
  <input name="bplayers" type="checkbox" value="" onClick="cache(servers,'players','none')" >
  Players&nbsp;&nbsp; 
  <input name="bweather" type="checkbox" value="" onClick="cache(servers,'weather','none')" >
  Weather&nbsp;&nbsp; 
  <input name="boptions" type="checkbox" value="" onClick="cache(servers,'options','none')">
  Options&nbsp;&nbsp;</font> <font size="2"> 
  <!-- <input name="bts" type="checkbox" value="" onClick="cache(servers,'ts','none')" >
  TS&nbsp;&nbsp;</font>  -->
  <font size="2" color="#FF0000"> <input name="boffline" type="checkbox" value="" onClick="cache2(servers, 'none')" >Offline&nbsp;&nbsp;</font> 
  &nbsp;&nbsp;&nbsp;&nbsp;<img src = "im/ys2.png"> <a href="http://forum.ysfhq.com/viewtopic.php?f=236&t=5425" target="_blank"><font size="2">About the YSFlight protocol.</font></a>
</form>



<table border="0" cellpadding="0" cellspacing="0" width="100%">
<colgroup>
	<col id="state">
	<col id="serverName">
	<col id="ip">
	<col id="map">
	<col id="players">
	<col id="weather">
	<col id="options">
	<!-- <col id="ts"> -->
	<col id="clock">
</colgroup>
  <tr> 
	<td><font size="2"><strong>State</strong></font></td>
	<td><font size="2"><strong>Server Name</strong></font></td>
	<td><font size="2"><strong>IP</strong>:port</font></td>
	<td><font size="2"><em>Map</em></font> </td>
	<td><font size="2">Players</font> </td>
	<td><font size="2"><font color="#006666">Weather</font></font> </td>
	<td><font size="2">Options</font> </td>
	<!-- <td><font size="2">TS</font> </td> -->
	<td><font size="2">&nbsp;</font> </td>
  </tr>
<?php

$sf        = new Serversf();
$dir       = opendir('servers/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!="..")&&($read_file!="bck")&&(substr($read_file,-3)!="ock"))
	{
		$sf->readf($read_file);
		//if (trim($sf->isOnline) != "Offline")
		//{
			//echo $read_file." ".$sf->country."<br>";
			$weathert = explode(":",$sf->weather);
			$daynight = ($weathert[0]==1) ? "day" : "night";
			$blackout = ($weathert[1]==1) ? "blackout_on" : "blackout_off";
			$coll     = ($weathert[2]==1) ? "collisions_on" : "collisions_off";
			$landev   = ($weathert[3]==1) ? "landev_on" : "landev_off";
			$missile  = ($sf->missile==1)  ? "missiles_on" : "missiles_off";	
  			$weapon   = ($sf->weapon==1)   ? "weapon_on" : "weapon_off";	
			$delay    = time()-intval($sf->timestamp);
			$tstate   = state($sf->isOnline);
			$players  = players ($sf->users,$sf->flying); 
			$weather  = weather ($daynight, $weathert);
			$options  = options ($blackout, $coll, $landev, $missile, $weapon, $sf->radar, $sf->extview, $sf->showUser);
			$clock    = clock($delay, $sf->openedLast, $sf->isOnline);

			echo '
			  
		  	  <tr name="'.$sf->ip.':'.$sf->port.'" '; ?>
			onMouseOver="this.style.backgroundColor='#DDDDDD';" onMouseOut="this.style.backgroundColor='#FFFFFF';"    
			<?php
			$stable = "";
			if ($sf->version==20080220)
				$stable = "stable";
			else if($sf->version==20110207)
				$stable = "stable2";
			echo'> 
			  <td><div id="'.$sf->ip.':'.$sf->port.':state">'.$tstate.'</div></td>
			  <td><a href="ysflight://'.$sf->ip/*.'?port='.$sf->port*/.'"><img src="im/ys2.png" border="0" width="16" height="16" title="click to connect this server"></img></a> <a href="get_info.php?ip='.$sf->ip.'&port='.$sf->port.'"><img src="im/server2'.$stable.'.png"  width="13" height="18" border="0" title="owner: '.$sf->owner.' | YS version: '.$sf->version.'"></img></a> '; //| OS: '.$sf->os.
			  echo ' ';  
			  if (isset($_SESSION['coord']))
			  {
			  		$dist = "unknown";
			  		if ( ($sf->lat !=0) && ($sf->long !=0) )
					{
						$c2 = array($sf->lat,$sf->long);
						$dist = round(geoDist($_SESSION['coord'],$c2),0)." Km";
					}
					//echo ' <img src="im/dist.png" title="Distance to the server: '.$dist.'"></img> ';		
			  }
			  else 
			  	$dist = "You must set your latitude/longitude to get the distance to the server.";
			  echo '<a href="mapServers.php?lat='.$sf->lat.'&long='.$sf->long.'"><img src="im/flags/'.(strpos($sf->country,"-")===false ? strtolower($sf->country) : strtolower(substr(strstr($sf->country,"-"),1))).'.gif" width="16" height="11" title="'.$sf->country.' - Distance to the server: '.$dist.'" border="0"></img></a> '; 
			  //(isset($sf->website)==true ? $sf->website : "")
			  echo '<strong><font size="3"><a href="'.$sf->website.'" target="_blank">'.str_replace('\\','',$sf->serverName).'</a></font></span></strong></td>
		      <td>';
			  echo '<font size="2"><strong>'.$sf->ip.'</strong>';
			if (intval($sf->port) != 7915)
			  	echo ':'.$sf->port;
			echo '</font></td>
		      <td><font size="2"><em><div id="'.$sf->ip.':'.$sf->port.':map"><a href="http://marcjeanmougin.free.fr/ys_servers/index.php?page=mapToLink.php&map='.str_replace("'",' ',$sf->map).'" target="_blank">'.$sf->map.'</a></div></em></font> </td>		
		      <td><div id="'.$sf->ip.':'.$sf->port.':players">'.$players.'</td>				
		      <td><div id="'.$sf->ip.':'.$sf->port.':weather">'.$weather.'</div></td>
		      <td><div id="'.$sf->ip.':'.$sf->port.':options">'.$options.'</td>';
			  //<td>'; if ($sf->TS_port!=0) {echo '<a href="ts.php?ip='.$sf->TS_ip.'&port='.$sf->TS_port.'&key='.md5($sf->TS_ip.":izadhiadheidh:".$sf->TS_port).'"><img src="im/ts_on.png" border=0></a>';} echo '</td>
			  echo '<td><div id="'.$sf->ip.':'.$sf->port.':clock">'.$clock.'</div></td>
			  </tr>';
			  if ( (isset($_GET["ajax"])) && ($_GET["ajax"]=="yes") )
				  echo '<script type="text/javascript">servers["'.$sf->ip.':'.$sf->port.'"] = "'.$sf->isOnline.'"; runAll(servers);refresh ("'.$sf->ip.'",'.$sf->port.','.$delay.');</script> ';
			
		//}
	}
}

?>
</table>
<br>
<iframe src="http://marcjeanmougin.free.fr/ys_servers/fps_servers.php" align="middle" width="100%" name="_online" height="100" scrolling="no" hspace="0" frameborder="0"></iframe> 
<br>
<fieldset>	  
  <legend><b><font color="#006666">Who is online (servers using <a href="http://www.yspilots.com/yspf/viewtopic.php?f=7&t=95" target="_blank">YSC</a> or <a href="http://www.yspilots.com/yspf/viewtopic.php?f=7&t=99" target="_blank">YSPS</a>)</font></b></legend>

<iframe src="players3.php" align="middle" width="100%" name="_online2" height="130" scrolling="yes" hspace="0" frameborder="0"></iframe>    

  <!--<iframe src="http://marcjeanmougin.free.fr/ys_servers/flying2.php" align="middle" width="100%" name="_online" height="120" scrolling="yes" hspace="0" frameborder="0"></iframe>-->

</fieldset>  
  
<br> 

<form action="coord.php" method="post">
  <fieldset>	  
  <legend><b><font color="#006666">Set your longitudes/latitudes to know your distance from the servers</font></b></legend>
  <font size="2"><strong>My coordinates</strong></font>: &nbsp;&nbsp;<font size="2">Latitude 
  <input name="lat" type="text" size="15" maxlength="30" value="<?php if (isset($_SESSION["coord"])) echo $_SESSION["coord"][0] ?>">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Longitude 
  <input name="long" type="text" size="15" maxlength="30" value="<?php if (isset($_SESSION["coord"])) echo $_SESSION["coord"][1] ?>">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="submit" name="Submit2" value="Change">
  
  <br>
  <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Get 
  your coordinates.</a><br>
  This will enable to see the distance between you and the server 
  by moving your mouse over the flags!</font><br>
  </fieldset>  
</form>

<?php include("ask_info.php"); ?>
<br>
Contact: <a href="http://forum.ysfhq.com/ucp.php?i=pm&mode=compose&u=88" target="_blank">Eric</a></font>

</body>
</html>
<?php } 

if (isset($_GET["ajax"]))
	$timer5->stop();
?>
