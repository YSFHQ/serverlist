<?php
include ("inc/func2.php");
class Serversf
{
	var $directory  = "servers/" ;
	var $fileName   = "";
	var $serverName = "Unnamed";
	var $ip         = "127.0.0.2";
	var $port       = 7915;
	var $owner      = "Unknown";
	var $country    = "unknown";
	var $coord      = "0:0";
	var $os         = "Unknown";
	var $version    =  20110207;
	var $isOnline   = "Unknown";
	var $map        = "Unknown";
	var $missile    = "Unknown";
	var $weapon     = "Unknown";
	var $users      = 0;
	var $flying     = 0;
	var $weather    = "0:0:0:0:0:0:0:0:0";
	var $timestamp  = 0;
	var $openTime   = 0;
	var $website    = "";
	var $TS_ip      = "";
	var $TS_port    = 0;
	var $delay      = 0;
	var $long       = 0;
	var $lat        = 0;
	var $popularity = 0;
	var $openedLast = 0;
	var $delOnExit  = 0;
	var $usera      = array();
	var $radar      = "";
	var $extview    = "";
	var $showUser   = 0;
	
	function Serversf()
	{
		//$this->timestamp = time();
	}
	
	function setDirectory($s)
	{
		$this->directory = $s;
	}
	
	function setServerName($s)
	{
		$this->serverName = $s;
	}
	
	function setIp($s)
	{
		$this->ip = $s;
	}
	
	function setPort($s)
	{
		$this->port = $s;
	}
	
	function setOwner($s)
	{
		$this->owner = $s;
	}
	
	function setCountry($s)
	{
		$this->country = $s;
	}
	
	function setCoord($s)
	{
		$this->coord = $s;
	}
	
	function setOs($s)
	{
		$this->os = $s;
	}
	
	function setVersion($s)
	{
		$this->version = $s;
	}
	
	function setIsOnline($s)
	{
		$this->isOnline = $s;
	}
	
	function setMap($s)
	{
		$this->map = $s;
	}
	
	function setMissile($s)
	{
		$this->missile = $s;
	}
	
	function setWeapon($s)
	{
		$this->weapon = $s;
	}
	
	function setUsers($s)
	{
		$this->users = $s;
	}
	
	function setFlying($s)
	{
		$this->flying = $s;
	}
	
	function setWeather($s)
	{
		$this->weather = $s;
	}
	
	function setTimestamp()
	{
		$this->timestamp=time();
	}
	
	function setOldTimestamp()
	{
		$this->timestamp=time()-600;
	}
	
	function setOpenTime($delay)
	{
		$this->openTime += $delay;
	}
	
	
	function setWebsite($s)
	{
		$this->website = $s;
	}
	
	function setTS_ip($s)
	{
		$this->TS_ip = $s;
	}
	
	function setTS_port($s)
	{
		$this->TS_port = $s;
	}
	
	function setLat($s)
	{
		$this->lat = $s;
	}
	
	function setLong($s)
	{
		$this->long = $s;
	}
	
	function setPopularity($delay)
	{
		$this->popularity += $this->flying * $delay;
	}
	
	function setOpenedLast()
	{
		$this->openedLast = time();
	}
	
	function setDelOnExit($s)
	{
		$this->delOnExit = $s;
	}
	
	function setUsera($a)
	{
		$this->usera = $a;
	}
	
	function reset()
	{
		$this->popularity=0;
		$this->openTime=0;
	}
	
	function log3 ($s,$file="errors")
	{
		date_default_timezone_set('UTC');
		$today=date("Y_m_d");
		$file.=$today;
		$f=fopen("log/".$file.".txt","a+");
		fwrite($f,date("r")." ".$this->ip."   ".$s."<br>\r\n");
		fclose($f);
	}
	
	function readf($file)
	{
		if ( (!isset($file)) || ($file=="") )
			$file = $this->fileName;
		$writer=new SafeWriter;
		$d = $writer->readData($this->directory.$file);
		$d  = file($this->directory.$file);
		$this->fileName = $file;
		$splitPos = strpos($file,"_");
		$this->ip   = substr($file,0,$splitPos);
		$this->port = intval(substr($file,$splitPos+1,-4));
		$this->getInfo($d);
	}
	
	
	function read($ip,$port)
	{
		$writer=new SafeWriter;
		$d = $writer->readData($this->directory.$ip."_".$port.".txt");
		//$d=file($this->directory.$ip."_".$port.".txt");
		$this->getInfo($d);
		$this->ip = $ip;
		$this->port=$port;
	}
	
	function getInfo ($d)
	{
		$w                = explode(":",$d[8]);
		$u                = explode(":",$d[9]);
		$this->serverName = stripslashes(str_replace("\r","",str_replace("\n","",$d[0])));
		//$this->ip         = str_replace("\n","",$ip); 
		//$this->port       = str_replace("\n","",$port);
		$this->owner      = stripslashes(str_replace("\r","",str_replace("\n","",$d[1])));
		$this->country    = str_replace("\r","",str_replace("\n","",$d[2]));
		$this->coord      = str_replace("\r","",str_replace("\n","",$d[3]));
		$c                = explode(":",$this->coord);
		if (count($c) >= 2)
		{
			$this->lat        = floatval($c[0]);
			$this->long       = floatval($c[1]);
		}
		$this->os         = str_replace("\r","",str_replace("\n","",$d[4]));
		$this->version    = str_replace("\n","",$d[5]);
		$this->isOnline   = str_replace("\r","",str_replace("\n","",$d[6]));
		$this->map        = str_replace("\n","",$d[7]);
		if (count($w) >= 2)
		{
			$this->missile    = intval(str_replace("\n","",$w[0]));
			$this->weapon     = intval(str_replace("\n","",$w[1]));
		}
		if (count($u) >= 2)
		{
			$this->users      = intval(str_replace("\n","",$u[0]));
			$this->flying     = intval(str_replace("\n","",$u[1]));
		}
		$this->weather    = str_replace("\n","",$d[10]);
		$this->timestamp  = intval(str_replace("\n","",$d[11]));
		$this->openTime   = intval(str_replace("\n","",$d[12]));
		$this->website    = str_replace("\r","",str_replace("\n","",$d[13]));
		$this->TS_ip      = str_replace("\r","",str_replace("\n","",$d[14]));
		$this->TS_port    = intval(str_replace("\r","",str_replace("\n","",$d[15])));
		$this->popularity = floatval(str_replace("\r","",str_replace("\n","",$d[16])));
		$this->openedLast = intval(str_replace("\r","",str_replace("\n","",$d[17])));
		$this->delOnExit  = intval(str_replace("\r","",str_replace("\n","",$d[18])));
		$a1 = explode("--|--",$d[19]);
		//echo "<br>";echo $this->serverName;echo "<br>";
		$this->usera = array();
		$i = 0;
		$j = 0;
		while ($i<count($a1)-1)
		{
			//echo $a1[$i]."<br>";
			$b = explode("(|)",$a1[$i]);
			if ( (substr($b[3], 0, 7) != "PHP bot") && (substr($b[3], 0, 14) != "Console Server") && (substr($b[3], 0, 6) != "ysChat") && (substr($b[3], 0, 3) != "REC") )
			{
				$this->usera[$j] = explode("(|)",$a1[$i]);
				$j++;
			}	
			$i++;
			//echo print_r($this->usera[$i]);
			/*$a = split("(|)",$a[$i]);
			$this->usera[$i][0] = $a[0];
			$this->usera[$i][1] = $a[1];
			$this->usera[$i][2] = $a[2];
			$this->usera[$i][3] = $a[3];*/
		}
		$this->radar  = str_replace("\r","",str_replace("\n","",$d[20]));
		$this->extview  = str_replace("\r","",str_replace("\n","",$d[21]));
		$this->showUser  = intval(str_replace("\r","",str_replace("\n","",$d[22])));
		//$this->usera[0]="huh";
		//echo $d[19];
		//echo "<br>";print_r($this->usera);echo "<br>";
		//print_r($a1);echo "<br>";
	}
	
	function write()
	{
		$this->serverName = preg_replace("/[^\x9\xA\xD\x20-\x7F]/", "", $this->serverName);
		//$f = fopen($this->directory.$this->ip."_".$this->port.".txt","w+");
		if (($this->serverName == "") || ($this->ip == "127.0.0.2") )
		{
			$this->log3("No name for ".$this->ip);//echo "write3".$this->serverName;
		}
		else
		{
			$put=$this->serverName
			 ."\n".$this->owner
			 ."\n".$this->country
			 ."\n".$this->lat.":".$this->long
			 ."\n".$this->os
			 ."\n".$this->version
			 ."\n".$this->isOnline
			 ."\n".$this->map
			 ."\n".$this->missile.":".$this->weapon
			 ."\n".$this->users.":".$this->flying
			 ."\n".$this->weather
			 ."\n".$this->timestamp
			 ."\n".$this->openTime
			 ."\n".$this->website
			 ."\n".$this->TS_ip
			 ."\n".$this->TS_port
			 ."\n".$this->popularity
			 ."\n".$this->openedLast
			 ."\n".$this->delOnExit."\n";
			for ($i=0 ; $i < count($this->usera) ; $i++)
			{
				$put=$put.$this->usera[$i][0]."(|)".$this->usera[$i][1]."(|)".$this->usera[$i][2]."(|)".$this->usera[$i][3]."--|--";
			}
			$put.="\n".$this->radar
			."\n".$this->extview
			."\n".$this->showUser;
			$writer=new SafeWriter;
			if (!($writer->writeData($this->directory.$this->ip."_".$this->port.".txt","w+",$put)))
				echo "Failed to write";
		}
//		fwrite($f,$put);
	//	fclose($f);
	}
  	
}
?>
