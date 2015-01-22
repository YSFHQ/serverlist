<?php
//UNCOMMENT LINE 384 FOR 000WEBHOST
class YS_protocol
{
	//---------- VAR -------------
	var $buffer      = 0;
	var $prevbuffer  = 0;
	var $debug       = false;
	var $errstr      = "";
	var $fp          = false; //socket
	var $isfsockopen = false;
	var $maxRetry    = 3;
	var $retry       = 0;
	var $maxLook     = 5;
	var $info        = "";//to get the stream time-out info
	var $stop        = false;
	var $version     = 20110207; //YSFS version
	var $ip          = "";
	var $maxpackets  = 31;
	
	var $missile  = 0;
	var $weapon   = 0;
	var $showUser = 0;
	var $radar    = "";
	var $extview  = "";
	var $map      = "";
	var $weather  = "0:0:0:0:0:0:0:0";
	var $userlist = array();
	var $i_users  = 0;
	var $users    = -1; //to don't count phpBot
	var $flying   = 0;
	
	

	var $got_map      = false;
	var $got_radar    = false;
	var $got_weather  = false;
	var $got_userlist = false;
	
	
	function YS_protocol($fsockopen=false)
	{
		$this->isfsockopen=$fsockopen;
	}
	
	//---------- SET -------------
	
	function setDebug    ($deb)
	{
		$this->debug    = $deb;
	}
	function setMaxRetry ($nb)
	{
		$this->maxRetry = $nb;
	}
	function setVersion  ($ver)
	{
		$this->version  = $ver;
	}
	function setBuffer   ($buf)
	{
		$this->buffer   = $buf;
	}
	
	
	//---------- GET TYPE -------------
	
	function getIsLaggy()
	{
		return $this->stop;
	}
	
	function getString ($i=0)
	{
		$string = "";
		for ( $k=0 ; $k < strlen($this->buffer) ; $k++ )
		{
			$s = substr($this->buffer,$i+$k,1);
			if (ord($s) == 0)
				break;
			else
			{
				$s       = unpack("a", $s);
				$string .= $s[1];
			}
		}	
		return $string;
	}

	
	function getInt ($i=0)
	{
		$s = substr($this->buffer,$i,4);
		if (strlen($s) < 4)
		{
			$this->log3( "<b>Warning:</b> the byte array in getInt is too short");
			$this->stop=true;
			return 0;
		}
		else
		{	
			$i = unpack("I", $s);
			return $i[1];
		}
	}
	
	function getShort ($i=0)
	{
		$s = substr($this->buffer,$i,2);
		if (strlen($s) < 2)
		{
			$this->log3( "<b>Warning:</b> the byte array in getShort is too short");
			$this->stop=true;
			return 0;
		}
		else
		{	
			$i = unpack("S", $s);
			return $i[1];
		}
	}
	
	function getFloat ($i=0)
	{
		$s = substr($this->buffer,$i,4);
		if (strlen($s) < 4)
		{
			$this->log3( "<b>Warning:</b> the byte array in getFloat is too short");
			$this->stop=true;
			return 0;
		}
		else
		{	
			$i = unpack("f", $s);
			return $i[1];
		}
	}
	
	function ushortToBools ($u)
	{
		$bin = sprintf("%b", $u);
		//echo $bin."<br>";
		$a=array(0,0,0,0,0,0,0,0);
		$j=0;
		for($i=strlen($bin)-1; $i>=0;$i--)
		{
			$a[$j]=($bin[$i]==1 ? 1 : 0);
			$j++;
		}
		return $a;
	}
	
	//---------- GET FUNC -------------
	
	function packetDecode()
	{
		$i = 1;
		while (($this->fp)&&($i < $this->maxpackets)&&(!$this->stop))
		{
			if ( ($this->got_map)&&($this->got_weather)&&($this->got_userlist)&&($this->kind()!=37) || (($i>8)&&($this->buffer==$this->prevbuffer)) )
			{// we stop if we finished to read all the userlist or if we received twice the same packet
				if ($this->debug)
					echo "<b>STOP</b>";
				break; // we read everything we needed
			}
			if ($this->debug ==true)
				echo "<br><b>Looking at</b> ".$this->kind().", packet ".$i.".<br>";	
			$this->receive();
			$i++;
			switch ($this->kind())
			{
				case 4:
					$this->got_map=true;
					$this->getMap();
					break;
					
				case 29:
					$this->getVer();
					break;
					
				case 31:
					$this->getMissile();
					break;
				
				case 33:
					$this->got_weather = true;
					$this->getWeather();
					break;
					
				case 37:
					$this->got_userlist = true;
					$this->getUserList();
					break;
					
				case 39:
					$this->getWeapon();
					$this->YSsend (pack("I",33),4); //so that the server answers the weather packet
					$this->YSsend (pack("I",37),4);  //so that the server answers the user-list packet
					break;
					
				case 41:
					$this->getShowUsername();
					break;
					
				case 43:
					$this->getRadar();
					$this->got_radar = true;
					$this->YSsend($this->buffer);
					break;
					
				default:
					if ($this->debug)
						print "<br>nothing.<br>";
					break;

			}
			
		}
	}
	
	
	function getShowUsername()
	{
		if (!$this->stop)
		{
			$show = $this->getInt (4);
			if ($this->debug)
				echo "show ".$show;
			$this->showUser =  $show; //show username within $show, always = 1, never=2
		}

	}

	function getRadar()
	{
		if (!$this->stop)
		{
			$radar = $this->getString (8);
			if ($this->debug)
				echo "radar ".$radar;
			if (!$this->got_map)				
				$this->radar = $radar;
			else
				$this->extview = $radar;
		}

	}
	function getMap ()
	{
		if (!$this->stop)
		{
			$this->map = $this->getString (4);
		}

	}
	function getMissile ()
	{
		if (!$this->stop)
		{
			$this->missile =  $this->getInt (4);
		}
	}
	function getWeapon ()
	{
		if (!$this->stop)
		{
			$this->weapon =  $this->getInt (4);
		}

	}
	function getWeather ()
	{
		if (!$this->stop)
		{
			//$this->lookfor (33);
			$opt = $this->ushortToBools ($this->getShort(8));
			//print_r ($opt);
			$this->weather =  $this->getInt(4).":".$opt[2].":".$opt[4].":".$opt[6].":".$this->getFloat(12).":".$this->getFloat(20).":".$this->getFloat(16).":".$this->getFloat(24);
		}

	}
	function getUserList ()
	{
		if (!$this->stop)
		{
			
			$b[0] = $this->getShort  (4);//2= server //1 flying //not flying //3=server flying
			$b[1] = $this->getShort  (6);// iff
			$b[2] = $this->getInt    (8);// id
			$b[3] = $this->getString (16);// user
			$this->userlist[$this->i_users]= $b;
					
			if ($b[0] != 2)
			{
				$this->users  += 1;
				if ($b[0]==3)
					$b[0]=1;
				$this->flying += $b[0];
			}
			$this->i_users +=1;
			/*
			$a;
			$i      = 0;
			$flying = 0;
			$users  = 0;
			$flag   = 0;
			while ($this->fp)
			{
				$b;
				$this->receive();
				if ($this->kind() == 37)
				{
					$flag = 1;
					$b[0] = $this->getShort  (4);//2= server //1 flying //not flying //3=server flying
					$b[1] = $this->getShort  (6);// iff
					$b[2] = $this->getInt    (8);// id
					$b[3] = $this->getString (16);// user
					$a[$i]= $b;
					$i += 1;
					if ($b[0] != 2)
					{
						$users  += 1;
						if ($b[0]==3)
							$b[0]=1;
						$flying += $b[0];
					}
				}
				elseif ($flag == 1)
					break;
			}
			$a[$i]   = $users - 1;//-1 to don't count phpBot
			$a[$i+1] = $flying;
			$this->userlist = $a;*/
		}

	}
	function getVersion ()
	{
		return $this->getInt(4);
	}
	
	function getVer()
	{
		if (!$this->stop)
		{
			return $this->version;
		}
	}
	
	//---------- Is? -------------
	function kind ()
	{
		if (!$this->stop)
		{
			if ( strlen($this->buffer) >=4 )
			{
				$k = unpack("I",$this->buffer);
				return $k[1];
			}
			else
				return 0;
		}
		else
			return 0;
	}
	

	function isVersion    () { return ($this->kind() == 29 ? true : false); } 
	function isWeather    () { return ($this->kind() == 33 ? true : false); }  
	
	
	//---------- Debug -------------
	function log3 ($s,$file="errors")
	{
		/*date_default_timezone_set('UTC');
		$today=date("Y_m_d");
		$file.=$today;
		$f=fopen("log/".$file.".txt","a+");
		fwrite($f,date("r")." ".$this->ip."   ".$s."<br>\r\n");
		fclose($f);*/
	}

	function printBuffer()
	{
		echo time()." ".$this->ip."<br>";
		echo'<br><font face="Courier New, Courier, mono">';
		for ( $k=0 ; $k < strlen($this->buffer) ; $k++)
		{
			printf ("%02X\n", ord(substr($this->buffer,$k,1)));
			echo    " ";
		}
		echo "</font><br>";
	}
	
	function printBuffer2 ($buffer)
	{
		echo time()." ".$this->ip."<br>";
		echo'<br><font face="Courier New, Courier, mono">';
		for ($k=0;$k<strlen($buffer);$k++)
		{
			printf ("%02X\n", ord(substr($buffer,$k,1)));
			echo    " ";
		}
		echo "</font><br>";
	}
	
	function printString()
	{
		echo '<br><font face="Courier New, Courier, mono">';
		for ($k=0;$k<strlen($this->buffer);$k++)
		{
			printf ("%'.2s\n", substr($this->buffer,$k,1));
			echo    " ";
		}
		echo "</font><br>";
	}
	
	function printString2 ($buffer)
	{
		echo '<br><font face="Courier New, Courier, mono">';
		for ($k=0;$k<strlen($buffer);$k++)
		{
			printf ("%'.2s\n", substr($buffer,$k,1));
			echo    " ";
		}
		echo "</font><br>";
	}
	
	//---------- Primary functions -------------
	function YSdisconnect ()
	{
		if ($this->fp)
		{
			if ($this->isfsockopen)
				fclose($this->fp);
			else
				socket_close($this->fp);
		}
		if ($this->debug)
			echo "Disconnected<br>";
	}
	
	function YSsend($buffer, $size=0)
	{
		if ($size==0)
			$size=strlen($buffer);
		if ($this->debug ==true)
		{
			echo "<br>Send:<br> (size ".$size."";	
			$this->printBuffer2(pack("I",$size).$buffer);
			$this->printString2(pack("I",$size).$buffer);
		}
		if ($this->isfsockopen)
			fwrite($this->fp, pack("I",$size).$buffer);	
		else
			socket_write($this->fp, pack("I",$size).$buffer);
	}
	
	function receive()
	{
		if ( ($this->fp)&&(!$this->stop) )
		{
			if ($this->isfsockopen)
			{
				$buffer = @fgets($this->fp,5);// +1 -> PHP flaw??
				$this->info   = stream_get_meta_data($this->fp);
				if ($this->info['timed_out'])
				{
					$this->stop=true;
					//$this->log3 ("lag");
					if ($this->debug ==true)
					{
						echo "LAGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG ".time()."<br>";
					}
				}
			}
			else
				$buffer = @socket_read($this->fp,4);
				
			$size   = @unpack("I",$buffer);
			if ($this->debug ==true)
			{
				echo "size: ".$size;
			}
			if ($this->isfsockopen)
			{
				$this->prevbuffer = $this->buffer;
				$this->buffer = @fgets($this->fp,$size[1]+1);// +1
				$this->info   = stream_get_meta_data($this->fp);
				if ($this->info['timed_out'])
				{
					$this->stop=true;
					//$this->log3 ("lag2");
					if ($this->debug ==true)
					{
						echo "LAGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG2 ".time()."<br>";
					}
				}
			}
			else
				$this->buffer = @socket_read($this->fp,$size[1]);
				
			while ( strlen($this->buffer)<$size[1] )
			{
				if ($this->isfsockopen)
					$this->buffer .= @fgets($this->fp,$size[1]+1-strlen($this->buffer));
				else
					$this->buffer .= @socket_read($this->fp,$size[1]-strlen($this->buffer));
			}
			if ($this->debug)
			{
				echo "<br>Receive:<br>";
				$this->printBuffer ();
				$this->printString ();
			}
		}
		else
		{
			//$this->YSdisconnect ();
			$this->stop=true;
		}
	}
	
	
     function YSconnect($ip="127.0.0.1", $port=7915, $timeout=1)
     {
	 	$this->ip = $ip;
	 	$this->log3("connect: ".$ip.":".$port." version: ".$this->version, "pr_");
	 	if ($this->debug ==true)
			{
				echo "<br>connect: ".$ip.":".$port." version: ".$this->version."<br>";
			}
	 	if ($this->debug ==true)
			{
				echo "Start ".time()."<br>";
			}
		if ($this->retry > $this->maxRetry)
		{
			if ($this->debug ==true)
			{
				echo "New attempt ".time()."<br>";
			}
			return "Failed";//failed to connected after x attempts
		}
		$version=pack("I",intval($this->version));
		if ($this->isfsockopen)
			$this->fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
		else
			$this->fp = $this->msConnectSocket($ip, $port, $timeout);
		if ($this->fp==false) 
		{
			return "Offline";//offline
		} 
		elseif($this->fp) 
		{   
			if ($this->debug ==true)
			{
				echo $ip." login ".time()."<br>";
			}
			if ($this->isfsockopen)
				stream_set_timeout($this->fp, 2);//Maximum delay accepted
			$this->YSsend("\x01\x00\x00\x00PHP bot\00\00\00\x00\x00\x00\x00\x00\x00".$version,24);
			if ($this->debug ==true)
			{
				echo "login2 ".time()."<br>";
			}
			$this->receive();
			if ($this->debug ==true)
			{
				echo "login3 ".time()."<br>";
			}
			if ($this->isVersion ())
			{
				$oldversion    = $this->version;
				$this->version = $this->getVersion();
				if ($this->version!=$oldversion)
				{
					if ($this->debug==true)
						echo "Retry with version ".$this->version."<br>";
					$this->retry+=1;
					$this->YSconnect($ip,$port,$timeout);
				}
			}
			else
			{
				$this->receive();
				if ($this->debug ==true)
				{
					echo "login3_after_failed_attemp ".time()."<br>";
				}
				if ($this->isVersion ())
				{
					$oldversion    = $this->version;
					$this->version = $this->getVersion();
					if ($this->version!=$oldversion)
					{
						if ($this->debug==true)
							echo "Retry with version ".$this->version."<br>";
						$this->retry+=1;
						$this->YSconnect($ip,$port,$timeout);
					}
				}
				else
				{
					if ($this->debug ==true)
					{
						echo "expected sth else".time()."<br>";
					}
					return "Offline";
				}

			}
			if ($this->stop)
				return "Laggy";
			if ($this->buffer=="")
			{
				//Server locked
				$this->YSdisconnect();
				return "Locked";
			}
			return "Online";
		}
    }
	
	// To replace fsockopen()
	function msConnectSocket($remote, $port, $timeout = 1) {
        # this works whether $remote is a hostname or IP
        $ip = "";
        if( !preg_match('/^\d+\.\d+\.\d+\.\d+$/', $remote) ) {
            $ip =gethostbyname($remote);
            if ($ip == $remote) {
                $this->errstr = "Error Connecting Socket: Unknown host";
//				echo $errstr;
                return false;
            }
        } else $ip = $remote;

        if (!($_SOCK = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
            $this->errstr = "Error Creating Socket: ".socket_strerror(socket_last_error());
//			echo $errstr;
            return false;
        }

        socket_set_nonblock($_SOCK);//   DEPENDENT ON YOUR CONFIGURATION  UNCOMMENT WITH 000WEBHOST

        $error = NULL;
        $attempts = 0;
        $timeout *= 1000;  // adjust because we sleeping in 1 millisecond increments
        $connected= false;
        while (!($connected = @socket_connect($_SOCK, $remote, $port+0)) && $attempts++ < $timeout) {
            $error = socket_last_error();
            if ($error != SOCKET_EINPROGRESS && $error != SOCKET_EALREADY) {
                $this->errstr = "Error Connecting Socket: ".socket_strerror($error);
                socket_close($_SOCK);
//				echo $errstr;
                return false;
            }
            usleep(1000);
        }

        if (!$connected) {
            $this->errstr = "Error Connecting Socket: Connect Timed Out After $timeout seconds. ".socket_strerror(socket_last_error());
//			echo $errstr;
            socket_close($_SOCK);
            return false;
        }
       
        socket_set_block($_SOCK);
//		echo "connected";
        return $_SOCK;     
	}
} 

?>