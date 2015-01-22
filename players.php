<?php
header("Content-type: image/png");
$im = imagecreatetruecolor(63, 10);

$users=$_GET["users"];
$flying=$_GET["flying"];

$black = imagecolorallocate ($im, 0, 0, 0);
$blue  = imagecolorallocate ($im, 20, 30, 240);
$white = imagecolorallocate ($im, 255, 255, 255);
$red= imagecolorallocate($im, 200, 10, 15);

imagefilledrectangle ($im, 1, 1, 62, 18, $white);
imagerectangle       ($im, 0, 0, 62, 9, $black);
imagefilledrectangle ($im, 1, 1, 1+min($users,20)*3, 8, $blue);
imagefilledrectangle ($im, 1, 1, 1+min($flying,20)*3, 8, $red);

imagepng($im);
imagedestroy($im);

?>