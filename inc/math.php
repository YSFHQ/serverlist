<?php

function sphToCart($v)
{
	// (r,phi,theta)
	// (r, lat NS, long We)
	$a[0] = $v[0] * cos($v[1]*pi()/180) * cos($v[2]*pi()/180);
	$a[1] = $v[0] * cos($v[1]*pi()/180) * sin($v[2]*pi()/180);
	$a[2] = $v[0] * sin($v[1]*pi()/180);
	return $a;
}

function scal($v1,$v2)
{
	return $v1[0]*$v2[0] + $v1[1]*$v2[1] + $v1[2]*$v2[2];
}

function norme($v)
{
	return sqrt(pow($v[0],2) + pow($v[1],2) + pow($v[2],2));
}

function geoDist($c1, $c2)
{
	$v1 = sphToCart(array(6360,$c1[0],$c1[1]));
	$v2 = sphToCart(array(6360,$c2[0],$c2[1]));
	return 6360*acos(scal($v1,$v2)/(norme($v1)*norme($v2)));
}
/*
$c1=array(41.9,12.483);
$c2=array(28.616,77.166);

echo geoDist($c1,$c2);
*/
?>