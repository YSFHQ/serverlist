<?php
include("inc/serversf.php");
include("inc/func.php");

$timer3 = new Timer("get_info_" . $_GET["ip"]);
include("serverCheck.php");

echo '<html></head></head><body><a href="index.php">&lt;&lt;-- Back to the server list</a>
<br><br><font size="2">
<strong>IP adress:</strong> ' . $_GET["ip"] . '<br>
<strong>Port:</strong> ' . $_GET["port"] . '<br>';

if (!(isset($_GET["ip"])) || !(isset($_GET["port"])) || ($_GET["ip"] == "") || ($_GET["port"] == ""))
    die("Missing ip or port.");

$read = False;

$sf  = new Serversf();
$dir = opendir('servers/');
$ip  = gethostbyname($_GET["ip"]);

if (file_exists("servers/" . $ip . "_" . $_GET["port"] . ".txt")) {
    $sf->read($_GET["ip"], $_GET["port"]);
    $read = True;
    //echo "read";
    if ((time() - ($sf->timestamp) > 300))
        ys_params($_GET["ip"], $_GET["port"], 2, $sf);
}
while ($read_file = readdir($dir)) {
    if (($read_file != ".") && ($read_file != "..") && ($read_file != "bck") && (substr($read_file, -3) != "ock")) {
        $splitPos = strpos($read_file, "_");
        $fip      = substr($read_file, 0, $splitPos);
        $fport    = intval(substr($read_file, $splitPos + 1, -4));
        if (gethostbyname($fip) == $ip && $_GET["port"] == $fport) {
            $sf->read($fip, $fport);
            $read = True;
            //echo "read";
            if ((time() - ($sf->timestamp) > 300))
                ys_params($_GET["ip"], $_GET["port"], 2, $sf);
            break;
        }
    }
}

if (!($read)) {
    $sf->setDirectory("servers2/");
    if (file_exists("servers2/" . $ip . "_" . $_GET["port"] . ".txt")) {
        $sf->read($ip, $_GET["port"]);
        $read = True;
        //echo "read2";
        if ((time() - ($sf->timestamp) > 300))
            ys_params($ip, $_GET["port"], 2, $sf);
    }
    
    
    $dir = opendir('servers2/');
    while ($read_file = readdir($dir)) {
        $sf->setDirectory("servers2/");
        if (($read_file != ".") && ($read_file != "..") && ($read_file != "bck") && (substr($read_file, -3) != "ock")) {
            $splitPos = strpos($read_file, "_");
            $fip      = substr($read_file, 0, $splitPos);
            $fport    = intval(substr($read_file, $splitPos + 1, -4));
            if ((gethostbyname($fip) == gethostbyname($_GET["ip"])) && ($_GET["port"] == $fport)) {
                $sf->read($fip, $fport);
                $read = True;
                //echo "read2";
                if ((time() - ($sf->timestamp) > 300))
                    ys_params($_GET["ip"], $_GET["port"], 2, $sf);
                break;
            }
        }
    }
}



if (!($read)) {
    $sf->setDirectory("servers2/");
    $sf->setServerName("Unknown");
    $sf->setIp($ip);
    $sf->setPort($_GET["port"]);
    ys_params($ip, $_GET["port"], 2, $sf);
    $sf->write();
    
}

if ($read) {
    $version = $sf->version;
    $missile = $sf->missile;
    $weapon  = $sf->weapon;
    $map     = $sf->map;
    $a       = $sf->usera;
    $users   = $sf->users;
    $flying  = $sf->flying;
    $weather = explode(":", $sf->weather);
    $owner   = $sf->owner;
    $state   = $sf->isOnline;
    //echo "read";
    //print_r($a);
    
    
} else {
    
    
    
    $ys    = new YS_protocol(true); //true: Your host enables fsockopen()    false: Your host disabled it, but allows sockets
    //$ys->setDebug(true); // true: display the debug messages 
    $state = $ys->YSconnect($_GET["ip"], $_GET["port"], 3);
    if ($state == "Online") //3 -> timeout
        {
        $version = $ys->getVer();
        $missile = $ys->getMissile();
        $weapon  = $ys->getWeapon();
        $map     = $ys->getMap();
        $a       = $ys->getUserList();
        $users   = $a[count($a) - 2];
        $flying  = $a[count($a) - 1];
        $weather = split(":", $ys->getWeather());
        $owner   = $a[0][3];
        //$ys->YSdisconnect();
        
        
        
        
        
        print_r($a);
        echo "<br>flying: " . $flying . " users: " . $users;
        echo $ys->YSdisconnect() . "<br>";
        echo $weather;
        //return true;
    }
    
    
    
}



if ($state == "Online") {
    $daynight = ($weather[0] == 1) ? "day" : "night";
    $blackout = ($weather[1] == 1) ? "blackout_on" : "blackout_off";
    $coll     = ($weather[2] == 1) ? "collisions_on" : "collisions_off";
    $landev   = ($weather[3] == 1) ? "landev_on" : "landev_off";
    $missile  = ($missile == 1) ? "missiles_on" : "missiles_off";
    $weapon   = ($weapon == 1) ? "weapon_on" : "weapon_off";
    
    echo '<strong>Server state: </strong><span style="background-color: #00ff00; font-size: 10px; "><font color="#000000">Online</font></span>';
    echo '<font color="#003300">';
    echo '<br><strong>Owner:</strong> ' . $owner;
    echo '<br><strong>YS version:</strong> ' . $version;
    echo '<br><strong>Map:</strong> ' . $map;
    echo '</font><font color="#884400">';
    echo '<br><strong>Daynight:</strong> ' . ($weather[0] == 1 ? "Day" : "Night");
    echo '<br><strong>Visibility:</strong> ' . $weather[7] . "m";
    echo '<br><strong>Windx:</strong> ' . $weather[4] . "m/s";
    echo '<br><strong>Windy:</strong> ' . $weather[5] . "m/s";
    echo '<br><strong>Windz:</strong> ' . $weather[6] . "m/s";
    echo '</font><font color="#555555">';
    echo '<br><strong>Missiles:</strong> ' . ($missile == 1 ? "On" : "Off");
    echo '<br><strong>Weapons:</strong> ' . ($weapon == 1 ? "On" : "Off");
    echo '<br><strong>Blackout:</strong> ' . ($weather[1] == 1 ? "On" : "Off");
    echo '<br><strong>Collisions:</strong> ' . ($weather[2] == 1 ? "On" : "Off");
    echo '<br><strong>Land everywhere:</strong> ' . ($weather[3] == 1 ? "On" : "Off");
    echo '</font>';
    echo '<br><strong><font color="#000099">Users connected:</font></strong> ' . $users;
    echo '<br><strong><font color="#BB0000">Users Flying:</font></strong> ' . $flying;
    echo '<br><br><strong>PLayers: </strong>';
    echo '<table>
	<tr>
		<td><font size="2">ID</font></id>
			<td><font size="2">IFF</font></td>
			<td><font size="2">Username</font></td>
		</tr>';
    for ($i = 0; $i < count($a); $i++) {
        $color = ($a[$i][0] == 1 ? "BB0000" : "000099");
        if ($a[$i][3] != "PHP bot")
            echo '<tr>
			<td><font color="#' . $color . '" size= "2">' . $a[$i][2] . '</font></td>
			<td><font color="#' . $color . '" size="2">' . $a[$i][1] . '</font></td>
			<td><font color="#' . $color . '" size="2">' . $a[$i][3] . '</font></td>
		</tr>';
    }
    echo '</table>';
    echo "<br>";
    echo '<img src="players.php?flying=' . $flying . '&users=' . $users . '" title="Users: ' . $users . ' | flying: ' . $flying . '"></img>';
    echo "<br>";
    echo '<font size="2"><font color="#006666"><img src="im/' . $daynight . '.png" title="' . $daynight . '">';
    if ($daynight != "unknown") {
        echo '<img src="weather.php?visib=' . intval($weather[7]) . '&heading=' . atan2(intval($weather[4]), intval($weather[5])) . '" title="visibility: ' . intval($weather[7]) . 'm | wind direction: ' . round((rad2deg(atan2(intval($weather[4]), intval($weather[5]))) + 360) % 360, 0) . ' | wind speed: ' . round(sqrt(abs(intval($weather[4]) ^ 2) + abs(intval($weather[5]) ^ 2)), 0) . 'm/s | windx=' . intval($weather[4]) . ' | windy=' . $weather[5] . ' | windz=' . $weather[6] . '"></img>';
    }
    echo '</font></font> ';
    echo "<br>";
    echo '<font size="2"><img src="im/' . $blackout . '.png" title=' . $blackout . '><img src="im/' . $coll . '.png" title=' . $coll . '><img src="im/' . $landev . '.png" title=' . $landev . '><img src="im/' . $missile . '.png" title=' . $missile . '><img src="im/' . $weapon . '.png" title=' . $weapon . '></font> ';
} else {
    echo '<strong>Server state: </strong><span style="background-color: #ff0000; font-size: 10px; "><font color="#ffffff">' . $state . '</font></span><br>';
}
echo '</font>';
$timer3->stop();
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