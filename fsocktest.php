<?php

$fp = @fsockopen("ys.ysfhq.com", $_GET["port"], $errno, $errstr, 3);
if ($fp==false) 
{
	echo "Offline";
}
else
{
	echo "Online";
}
?>
