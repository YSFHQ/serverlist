<?php
error_reporting(E_ALL ^ E_NOTICE);
class SafeWriter
{
	
	function readData($path)
	{
		$fp = @fopen($path.".flock", "w+");
		//on lock un autre fichier car si on lock en mode w+, on efface le fichier avant de savoir si on peut y accÃ©der!
		$retries = 0;
		$max_retries = 10;

		if (!$fp) {
		  // failure
		  return false;
		}

		// keep trying to get a lock as long as possible
		do {
			if ($retries > 0) 
			{
			 usleep(rand(1, 1000));
			}
			$retries += 1;
		} while (!flock($fp, LOCK_EX) and $retries <= $max_retries);

		// couldn't get the lock, give up
		if ($retries == $max_retries) 
		{
		  // failure
		  return false;
		}
		
		$f = file($path);
		// release the lock
		flock($fp, LOCK_UN);
		
		return $f;
	}    
	function writeData($path, $mode, $data)
	{
        $fp = @fopen($path.".flock", $mode);
		//on lock un autre fichier car si on lock en mode w+, on efface le fichier avant de savoir si on peut y accéder!
        $retries = 0;
        $max_retries = 10;

        if (!$fp) {
            // failure
            return false;
        }

        // keep trying to get a lock as long as possible
        do {
            if ($retries > 0) {
                usleep(rand(1, 1000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) and $retries <= $max_retries);

        // couldn't get the lock, give up
        if ($retries == $max_retries) {
            // failure
            return false;
        }

        // got the lock, write the data
		$fp2 = fopen($path, $mode);
        fwrite($fp2, "$data\n");
		fclose($fp2);
        // release the lock
        flock($fp, LOCK_UN);
        fclose($fp);
        // success
        return true;
	}
} 


function toascii($text) 
{
  $text = str_replace(" ","_",$text);
  return  eregi_replace("[^a-zA-Z0-9_()]", "",$text);
}

function convert_sec ($time,$day=false) 
{
	if ($time<60)
		$output=round($time,1)."s";
	else
	{
		$output = '';
		if ($day)
			$tab = array ('d' => '86400', 'h' => '3600', 'min' => '60');
		else
			$tab = array ('h' => '3600', 'min' => '60');
	
		foreach ($tab as $key => $value) 
		{
			$compteur = 0;
			while ($time > ($value-1)) 
			{
				$time = $time - $value;
				$compteur++;
			}
			if ($compteur != 0) 
			{
				$output .= $compteur.' '.$key;
				if ($value != 1) 
					$output .= ' ';
			}
		}
	}
	return $output;
}

function organize_array($array,$var,$var2)
{
	if (@array_key_exists($var, $array))
	{
		$array[$var]+=intval($var2);
	}
	else
	{
		$array[$var] = intval($var2);
	}
}

function org2_array($array)
{
	$a2[]="";
	foreach ($array as $key => $val) 
	{
		$a2[$val]=$key;
	}
	krsort($a2);
	unset($a2[0]);
	return $a2;
}

function top5d($array)
{
	if (count($array)!=0)
	{
		$a2[]="";
		foreach ($array as $key => $val) 
		{
			$a2[$val]=$key;
		}
		krsort($a2);
		unset($a2[0]);
		
		$rank=1;
		echo "<table style='text-align: left; width: 100%;' border='0' cellpadding='1' cellspacing='1'><tbody>\n";
		foreach ($a2 as $key => $val) {
			if ($val!="0")
				print "<tr><td><font size='2'>".$rank."</font></td><td bgcolor='#DDDDDD'><font size='2'>".$val."</font></td><td bgcolor='#EEEEEE'><font size='2'>".convert_sec($key)."</font><td></tr>\n";
			$rank++;
			if ($rank==6)
				break;
		}
	echo "</tbody></table>\n";
	}
}

function top5($array)
{
	if (count($array)!=0)
	{
		$a2[]="";
		foreach ($array as $key => $val) 
		{
			$a2[$val]=$key;
		}
		krsort($a2);
		unset($a2[0]);
		echo "<table style='text-align: left; width: 100%;' border='0' cellpadding='1' cellspacing='1'><tbody>\n";
		$rank=1;
		foreach ($a2 as $key => $val) {
			if ($val!="0")
				print "<tr><td><font size='2'>".$rank."</font></td><td bgcolor='#DDDDDD'><font size='2'>".$val."</font></td><td bgcolor='#EEEEEE'><font size='2'>".$key."</font><td></tr>\n";
			$rank++;
			if ($rank==6)
				break;
		}
	echo "</tbody></table>\n";
	}
}

function del_duration($user,$time)
{
	$req=mysql_query("DELETE FROM `flight_noduration` where  user='".$user."' and time='".$time."'") or die('Erreur SQL5 !<br>'.$req.'<br>');
	$req=mysql_query("OPTIMIZE TABLE `flight_noduration`");  
}

function state($s)
{
	switch ($s)
			{
				case "Online":
				$tstate = '<span style="background-color: #00ff00; font-size: 10px; "><font color="#000000"> Online </font></span>';
				break;
				
				case "Offline":
				$tstate = '<span style="background-color: #ff0000; font-size: 10px; "><font color="#ffffff"> Offline </font></span>';
				break;
				
				case "Failed":
				$tstate = '<span style="background-color: #FF9900; font-size: 10px; "><font color="#000000"> Failed </font></span>';
				break;
				
				case "Locked":
				$tstate = '<span style="background-color: #ff00ff; font-size: 10px; "><font color="#ffffff"> Locked </font></span>';
				break;
				
				case "Laggy":
				$tstate = '<span style="background-color: #0000ff; font-size: 10px; "><font color="#ffffff"> Laggy </font></span>';
				break;
				
				case "Laggy2":
				$tstate = '<span style="background-color: #000099; font-size: 10px; "><font color="#ffffff"> Laggy </font></span>';
				break;
				
				case "Pending":
				$tstate = '<span style="background-color: #ffff00; font-size: 10px; "><font color="#000000"> Pending </font></span>';
				break;
				
				default:
				$tstate = '<span style="background-color: #FF9900; font-size: 10px; "><font color="#000000"> Failed </font></span>';
			}
	return $tstate;
}

function clock($delay, $openedLast, $state)
{
	if ($state == "Offline")
		return '<img src="im/clock'.($delay > 305 ? "r" : "").'.png" width="20" height="20" title="information updated: '.convert_sec($delay).' ago | Was opened the last time '.convert_sec(time()-$openedLast,true).' ago ">';
	else
		return '<img src="im/clock'.($delay > 305 ? "r" : "").'.png" width="20" height="20" title="information updated: '.convert_sec($delay).' ago">';
}

function players ($users,$flying)
{
	$users = min($users,20);
	$flying = min($flying,20);
	$title = 'Users: '.$users.' | flying: '.$flying;
	return '<img style="width: 1px; height: 10px;" alt="players" title="'.$title.'" src="im/border.png"><img style="width: '.(max(0,$users-$flying)*3).'px; height: 10px;" alt="players" title="'.$title.'" src="im/barre_bleue.png"><img style="width: '.($flying*3).'px; height: 10px;" alt="players" title="'.$title.'" src="im/barre_rouge.png"><img style="width: '.(max(0,61-$users*3)).'px; height: 10px;" alt="players" title="'.$title.'" src="im/barreblanche.png"><img style="width: 1px; height: 10px;" alt="players" title="'.$title.'" src="im/border.png">';

//return '<img src="players.php?flying='.$flying.'&users='.$users.'" title="Users: '.$users.' | flying: '.$flying.'"></img></div>';
}

function weather ($daynight, $weathert)
{
	return '<img src="im/'.$daynight.'.png" width="20" height="20" title="'.$daynight.'"><img src="weather.php?visib='.intval($weathert[7]).'&heading='.atan2(intval($weathert[4]),intval($weathert[5])).'" width="40" height="20" title="visibility: '.intval($weathert[7]).'m | wind direction: '.round((rad2deg(atan2(intval($weathert[4]),intval($weathert[5])))+360)%360,0).' | wind speed: '.round(sqrt( pow($weathert[4],2) + pow($weathert[5],2) ),0).'m/s | windx='.intval($weathert[4]).' | windy='.intval($weathert[5]).' | windz='.intval($weathert[6]).'"></img>';
}

function options ($blackout, $coll, $landev, $missile, $weapon, $radar, $extview, $showUser)
{
	//echo $radar." - ".$extview." - ".$showUser."<br>";
	$f3 = "f3_on";
	if ($extview == "NOEXAIRVW TRUE")
		$f3 = "f3_off";
	
	if ($showUser == 1)
		$show = "always show player names";
	elseif ($showUser == 2)
		$show = "never show player names";
	else
		$show = "show player names within ".$showUser."m";
	return '<img src="im/'.$blackout.'.png" width="20" height="20" title='.$blackout.'><img src="im/'.$coll.'.png" width="20" height="20" title='.$coll.'><img src="im/'.$landev.'.png" width="20" height="20" title='.$landev.'><img src="im/'.$missile.'.png" width="20" height="20" title='.$missile.'><img src="im/'.$weapon.'.png" width="20" height="20" title='.$weapon.'><img src="im/radar.png" width="20" height="20" title="'.$radar.' | '.$show.'"><img src="im/'.$f3.'.png" width="20" height="20" title="'.$extview.'">';
}

//function to validate ip address format in php by Roshan Bhattarai(http://roshanbh.com.np)
function validateIpAddress($ip_addr)
{
  //first of all the format of the ip address is matched
  if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip_addr))
  {
    //now all the intger values are separated
    $parts=explode(".",$ip_addr);
    //now we need to check each part can range from 0-255
    foreach($parts as $ip_parts)
    {
      if(intval($ip_parts)>255 || intval($ip_parts)<0)
      return false; //if number is not within range of 0-255
    }
    return true;
  }
  else
    return false; //if format of ip address doesn't matches
}

?>
