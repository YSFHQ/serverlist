<?php
include("inc/ys_protocol.php");
//include("inc/queue.php");
//DEBUG ON!!!!! AND DELAY=1!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function ys_params ($ip, $port, $timeout=1, $sf, $ver=20110207)
{
  log2("start: ".$ip.":".$port." version: ".$sf->version,"access_");
  $timer1 = new Timer("serverCheck_".$ip);
  $sff = new Serversf();// is a back-up
  $delay = time() - ($sf->timestamp);  
  $sf->setIsOnline("Pending");
  $sf->setTimestamp(); // so that a second client doesn't send a query to the same server while the first is running its querry.
  $sf->write();
  /*if (can_go())
  {  
	  take_lock($ip.":".$port);
	  echo $ip.":".$port." true";  */
	  
	  $ys=new YS_protocol(true); //true: Your host enables fsockopen()    false: Your host disabled it, but allows sockets
	  //$ys->setDebug(true);//  true: display the debug messages 
	  $ys->setVersion($sf->version);
	  
	  //echo "VERSION ".$ys->version."<br>";
	  
	  $state = $ys->YSconnect($ip, $port, $timeout);
	  $sf->setVersion ($ys->version); 
	  log2("end: ".$ip.":".$port." state: ".$state." version: ".$ys->version,"access_");
	  if ($state == "Online")
	  {
		$sf->setOpenedLast();
		if ($ys->getIsLaggy())
		{
			$sf->setIsOnline("Laggy");
		}
		else
		{
			$ys->packetDecode();
			//echo "<br>VERSION: ".$ys->version."<br>";
			$sf->setMissile ($ys->missile);
			$sf->setWeapon  ($ys->weapon);
			$show = $ys->showUser;
			$radar = $ys->radar;
			$radar = $ys->extview;
			$sf->setMap     ($ys->map);
			$a = $ys->userlist;
			$sf->setUsera   ($a);
			if (count($a) >= 0)
			{
				$sf->users   = $ys->users; //($a[count($a)-2]);//
				$sf->flying  = $ys->flying; //($a[count($a)-1]);
				log2("<name>".$sf->serverName."</name> <ip>".$sf->ip."</ip> <port>".$sf->port."</port>    <users>".$sf->users."</users> <flying>".$sf->flying."</flying>","stats_");
				$sf->setPopularity($delay);
				//log2($ip." set pop");
				$sf->setWeather ($ys->weather);
				$sf->setIsOnline("Online");
				$sf->setOpenTime($delay);
				$sf->radar = $ys->radar;
				$sf->extview = $ys->extview;
				$sf->showUser = $ys->showUser;
				//$ys->YSdisconnect();
			}
			if ($ys->getIsLaggy())
			{
				$sff->readf($sf->fileName);
				$sf->setOpenedLast();
				$sff->setIsOnline("Laggy2");
			}
		}
	  }
	  else
	  {
		$sf->setIsOnline($state);
		if ($state != "Offline")
		{
			$sf->setOpenTime($delay);
			$sf->setOpenedLast();
		}
		elseif ($state == "Offline")
		{
			$sf->setFlying(0);
			$sf->setUsers(0);
			if ($sf->delOnExit == 1)
			{
				@unlink("servers/".$ip."_".$port.".txt");
				@unlink("servers/".$ip."_".$port.".txt.flock");
				journal ('<p> <img src="im/del_server.png" width="20" height="20" border="1"> '.date("d").' - The server '.$sf->serverName.' was deleted because it came offline.</p>');
			}
		}
	  }
	  $sf->setTimestamp();
	  if (($sf->delOnExit == 0)||($state != "Offline"))
		  $sf->write();
	  //release_lock();
  /*}
  else
  {  
	echo $ip.":".$port." false\n";
	$sw = new SafeWriter;
	$lock = $sw->readData("queue_lock.txt");
	echo $lock[0];
	echo "\n";
	echo $lock[0]=="";
	echo "\n";
  }*/
	$timer1->stop();
}

?>
