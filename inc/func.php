<?php 

//include("inc/func2.php");
//no need, is in sqlconn2

function get_OS($user_agent)
{
	$oses = array (
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => '(Windows ME)|(Me)',
		'Windows 9x' => 'Win 9x',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'(SunOS)|(Sun)',
		'Linux'=>'(Linux)|(X11)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)|(Apple)|(Mac)',
		'QNX'=>'QNX',
		'Unix'=>'Unix',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);
	foreach($oses as $os=>$pattern)
	{
		if (eregi($pattern, $user_agent))
			return $os;
	}
	return 'Unknown';
}

function get_lang()
{
	$Langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
    return str_replace("en","us",strtolower(substr(chop($Langue[0]),0,2)));
}

function is_online($ip,$port,$timeout=2)
{
	return false;
	/*
	$fp = fsockopen($ip, $port, $errno, $errstr, $timeout);
	if ($fp==false)
	{
	   return false;
	}
	else
	{
	   return true;
	}*/
}

function ts_server_online($timeout=1)
{
	global $row;
	if ( isset($row["TS_on"]) )
	{
		$row["TS_port"]=intval($row["TS_port"]);
		if ( ($row["TS_ip"]!="") && ($row["TS_port"]!=0) )
			return (ys_server_online($row["TS_ip"],$row["TS_port"])? 1:0);
		else
			return 0;
	}
	else
		return 0;
}

function ys_server_online($ip,$port=7915,$timeout=2)
{
	$fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
	if ($fp==false)
	{
	   return false;
	}
	else
	{
	   return true;
	}
}

function die2 ($message,$url="ys_serverlist.php")
{
	echo $message."<br>The page will be refreshed within 5s<br><br>";
	log2($message);
	@header('Refresh: 5; URL='.$url);
	echo "
	<SCRIPT LANGUAGE='JavaScript'>
	<!--
	function redirect()
	{
	window.location='".$url."'
	}
	setTimeout('redirect()',5000);
	-->
	</SCRIPT>";
	exit();
}


// Generate a random character string
function rand_str($length = 8, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
    
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
    
    // Return the string
    return $string;
}

function log2 ($s,$file="errors")
{
	date_default_timezone_set('UTC');
	$today=date("Y_m_d");
	$file.=$today;
	//$f=fopen("log/".$file.".txt","a+");
	//fwrite($f,"<date>".date("H:i:s")."</date>   ".$s."    <br />\r\n");
	//fclose($f);
}

class Timer
{
	var $start_time = 0;
	var $randstr    = "";
	var $page       = "";
	
	function Timer($page)
	{
		/*$this->page=$page;
		$this->randstr = rand_str();
		log2("START ".$this->page." ".$this->randstr, "access");
		$this->start_time = microtime(true);*/
	}
	
	function stop()
	{
		/*log2("DELAY ".$this->page." ".$this->randstr." ".(microtime(true)-$this->start_time), "access");
		log2("END ".$this->page." ".$this->randstr, "access");*/
	}
}
	


function journal ($s)
{
	$f=fopen("journal/".date("Y")."_".date("m").".html","a+");
	fwrite($f,$s);
	fclose($f);
}



function flying($tmp=207,$nbflying=false,$rss=0)
{
	global $timestamp,$row;
	$flying=0;
	if ($nbflying == true)
	{
	  $req2 = mysql_query("select * from flight_takeoff where server='".toascii($row["name"])."'");
	  if ($req2)
		  $flying=mysql_num_rows($req2);
	}
	else
	{
		$aflying=split(":",$row["players"]);
		if (count($aflying) > 1)
		{
			$flying=$aflying[1];
			$row["players"]=$aflying[0];
		}
	}
	$tcolor="FFFFFF";
    if ( (time() - intval($row["timestamp"])) > $tmp)
	  	$tcolor="FF9900";
	$weathert = split(":",$row["weather"]);
	$daynight = ($weathert[0]==1) ? "day" : "night";
	$blackout = ($weathert[1]==1) ? "blackout_on" : "blackout_off";
	$coll     = ($weathert[2]==1) ? "collisions_on" : "collisions_off";
	$landev   = ($weathert[3]==1) ? "landev_on" : "landev_off";
	$ts_on    = (ts_server_online() ? "ts_on" : "ts_off");
	 
	if (!isset($weathert[8]))
	  	$missile="unknown";
	else
	  	$missile=($weathert[8]==1) ? "missiles_on" : "missiles_off";	
	if (!isset($weathert[9]))
	  	$weapon="unknown";
	else
	  	$weapon=($weathert[9]==1) ? "weapon_on" : "weapon_off";	
	if ($weathert[0]==5)
	  	$daynight="unknown";
	if ($weathert[1]==5)
	  	$blackout="unknown";
	if ($weathert[2]==5)
	  	$coll="unknown";
	if ($weathert[3]==5)
	  	$landev="unknown";
	
	
	
	if ($rss == 1)
	{
		echo '	
		<item>
	         <title>'.$row["name"].'</title>
			  <link>http://vins.comze.com/infoserver.php?name='.toascii($row["name"]).'</link>       
	        <description>'.$row["ip"];
			if (intval($row["port"]) != 7915)
		  		echo ':'.$row["port"];
			echo ' | map: '.$row["map"].' | 
			country: '.$row["country"].'
			</description>
			
	    </item>';
	}	
	else
	{
		echo '
	  	  <tr>
	  	  <td><img src="im/server2.png" title="onwer: '.$row["owner"].' | YS version: '.$row["version"].' | OS: '.$row["os"].'"></img> </img><img src="http://www.ip2location.com/images/country/'.(strlen($row["country"])==2 ? $row["country"] : substr(strstr($row["country"],"-"),1)).'.gif" title="'.$row["country"].'"></img> <strong><span style="background-color: #'.$tcolor.';"><font size="3"><a href="'.(isset($row["website"])==true ? $row["website"] : "").'">'.$row["name"].'</a></font></span></strong></td>
	      <td><font size="2"><strong>'.$row["ip"].'</strong>';
		if (intval($row["port"]) != 7915)
		  	echo ':'.$row["port"];
		echo '</font></td>
	      <td><font size="2"><em>'.$row["map"].'</em></font> </td>		
	      <td><img src="players.php?flying='.$flying.'&users='.$row["players"].'" title="Users: '.$row["players"].' | flying: '.$flying.'"></img></td>				
	      <td><font size="2"><font color="#006666"><img src="im/'.$daynight.'.png" title="'.$daynight.'">'; if ($daynight!="unknown") {echo'<img src="weather.php?visib='.intval($weathert[7]).'&heading='.atan2(intval($weathert[4]),intval($weathert[5])).'" title="visibility: '.intval($weathert[7]).'m | wind direction: '.round((rad2deg(atan2(intval($weathert[4]),intval($weathert[5])))+360)%360,0).' | wind speed: '.round(sqrt(abs(intval($weathert[4])^2)+abs(intval($weathert[5])^2)),0).'m/s | windx='.intval($weathert[4]).' | windy='.$weathert[5].' | windz='.$weathert[6].'"></img>';} echo'</font></font> </td>
	      <td><font size="2"><img src="im/'.$blackout.'.png" title='.$blackout.'><img src="im/'.$coll.'.png" title='.$coll.'><img src="im/'.$landev.'.png" title='.$landev.'><img src="im/'.$missile.'.png" title='.$missile.'><img src="im/'.$weapon.'.png" title='.$weapon.'></font> </td>
		  <td><img src="im/'.$ts_on.'.png" title="';
		  if ($ts_on=="ts_on")
		  	echo "TS server open on".$row["TS_ip"].":".$row["TS_port"];
		  else
		  	echo "TS server offline";
		  echo '"></td>
		  <td><img src="im/clock.png" title="information updated: '.convert_sec(time()-intval($row["timestamp"])).' ago"></td>
		  </tr>';
	}
}

function filter($s)
{
	return htmlentities($s);
}


?>