<?php
header("Content-type: image/png");
$im = imagecreatetruecolor(40, 20);


$visib=$_GET["visib"];
$heading=$_GET["heading"]-1.570796;

$color=(20000-min(20000,$visib))*0.01274;

$black = imagecolorallocate ($im, 0, 0, 0);
$blue  = imagecolorallocate ($im, $color, $color, 255);
$white = imagecolorallocate ($im, 255, 255, 255);

imagefilledrectangle($im, 0, 0, 40, 20, $white);
imagefilledrectangle($im, 0, 0, 20, 20, $blue);

imageellipse($im,30,10,19,19,$black);
$ax=30+6*cos($heading);
$ay=10+6*sin($heading);
imageline($im,30,10,$ax,$ay,$black);
//imageline($im,30,10,30+(-8*cos($heading)),10+(-8*sin($heading)),$black);
//imageline($im,$ax,$ay,$ax+-2*cos(0.6+$heading),$ay+-2*sin(0.6+$heading),$black);
//imageline($im,$ax,$ay,$ax+-2*cos(-0.6+$heading),$ay+-2*sin(-0.6+$heading),$black);




imagepng($im);
imagedestroy($im);

?>