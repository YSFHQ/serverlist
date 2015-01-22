<?php
include("inc/ys_protocol.php");

function setElementValue($domObj, $elName, $value) {
	$elem = $domObj->getElementsByTagName($elName)->item(0);
	$elem->nodeValue = $value;
	$domObj->replaceChild($elem, $elem);
}

$doc = new DOMDocument();
$doc->load('servers.xml');
$doc->formatOutput = true;

$servers = $doc->getElementsByTagName("server");
foreach($servers as $server) {
	$ip = $server->getElementsByTagName("ip")->item(0)->nodeValue;
	$port = $server->getElementsByTagName("port")->item(0)->nodeValue;
	$vers = $server->getElementsByTagName("version")->item(0)->nodeValue;
	$ys = new YS_protocol(true);
	$ys->setVersion($vers);
	$state = $ys->YSconnect($ip, $port, 3);
	$vers = $ys->version;
	if ($state == "Online") {
		$server->getElementsByTagName("lastonline")->item(0)->nodeValue = time();
		if ($ys->getIsLaggy()) {
			setElementValue($server, "state", "Laggy");
		} else {
			$ys->packetDecode();
			//echo "<br>VERSION: ".$ys->version."<br>";
			$weathert = explode(":", $ys->weather);
			$weather = $server->getElementsByTagName("weather")->item(0);
			setElementValue($weather, "day", $weathert[0]);
			setElementValue($weather, "visib", $weathert[7]);
			
			$wind = $server->getElementsByTagName("wind")->item(0);
			setElementValue($wind, "x", $weathert[4]);
			setElementValue($wind, "y", $weathert[5]);
			setElementValue($wind, "z", $weathert[6]);
			
			$options = $server->getElementsByTagName("options")->item(0);
			setElementValue($options, "missile", $ys->missile);
			setElementValue($options, "weapon", $ys->weapon);
			setElementValue($options, "blackout", $weathert[1]);
			setElementValue($options, "coll", $weathert[2]);
			setElementValue($options, "landev", $weathert[3]);
			setElementValue($options, "radaralti", $ys->radar);
			setElementValue($options, "showuser", $ys->showUser);
			setElementValue($options, "f3view", $ys->extview);
			
			setElementValue($server, "map", $ys->map);
			$a = $ys->userlist;
			if (count($a) >= 0)
			{
				$server->removeChild($server->getElementsByTagName("players")->item(0));
				$players = $server->appendChild($doc->createElement("players"));
				$players->setAttribute("users", $ys->users);
				$players->setAttribute("flying", $ys->flying);
				foreach($a as $b) {
					if ($b[3]!="PHP bot") {
						$player = $players->appendChild($doc->createElement("player"));
						$player->setAttribute("state", $b[0]);
						$player->setAttribute("iff", $b[1]);
						$player->setAttribute("id", $b[2]);
						$player->setAttribute("username", $b[3]);
					}
				}
				
				
				//log2("<name>".$sf->serverName."</name> <ip>".$sf->ip."</ip> <port>".$sf->port."</port>    <users>".$sf->users."</users> <flying>".$sf->flying."</flying>","stats_");
				//$sf->setPopularity($delay);
				//log2($ip." set pop");
				$weather = $server->getElementsByTagName("weather")->item(0);
				setElementValue($weather, "day", $weathert[0]);
				setElementValue($weather, "visib", $weathert[7]);
				$wind = $server->getElementsByTagName("wind")->item(0);
				setElementValue($wind, "x", $weathert[4]);
				setElementValue($wind, "y", $weathert[5]);
				setElementValue($wind, "z", $weathert[6]);
				
				setElementValue($server, "status", "Online");
				//$sf->setOpenTime($delay);
				
				$options = $server->getElementsByTagName("options")->item(0);
				setElementValue($options, "radaralti", $ys->radar);
				setElementValue($options, "showuser", $ys->showUser);
				setElementValue($options, "f3view", $ys->extview);
				
				//$ys->YSdisconnect();
			}
			if ($ys->getIsLaggy())
			{
				setElementValue($server, "lastonline", time());
				setElementValue($server, "state", "Laggy2");
			}
		}
	} else {
		setElementValue($server, "status", $state);
		if ($state != "Offline") {
			$sf->setOpenTime($delay);
			setElementValue($server, "lastonline", time());
		} elseif ($state == "Offline") {
			$players = $server->getElementsByTagName("players")->item(0);
			$players->setAttribute("users", "0");
			$players->setAttribute("flying", "0");
			/*if ($sf->delOnExit == 1)
			{
				@unlink("servers/".$ip."_".$port.".txt");
				@unlink("servers/".$ip."_".$port.".txt.flock");
				journal ('<p> <img src="im/del_server.png" width="20" height="20" border="1"> '.date("d").' - The server '.$sf->serverName.' was deleted because it came offline.</p>');
			}*/
		}
	}
}
setElementValue($doc->getElementsByTagName("servers")->item(0), "timestamp", time());

file_put_contents('servers.xml', $doc->saveXML());

/*$conn_id = ftp_connect("ysfhq.com");
$login_result = ftp_login($conn_id, "erict15", "Ysfhq2011");
if (ftp_put($conn_id, "./serverlist/servers.xml", "servers.xml", FTP_ASCII)) echo "success";
else echo "failure uploading";
ftp_close($conn_id);
*/
//header('Content-type: text/xml');
//echo $doc->saveXML();
//header('Location: http://ysfhq.com/serverlist/servers.xml');
?>