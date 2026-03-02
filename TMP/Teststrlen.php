<?php


echo "<p>".strlen("00")."</p>\n";

echo substr("01",0,1)."<br>";


if (substr("01",0,1)=="0") $d=1;
else $d=2;

echo $d."<p></p>";

$f=convertChiffre("01");

echo $f;

function convertChiffre ($dd1) {
	$c=0;
	$d=0;

	$length = strlen($dd1);

	if ($length==1) {

		if (substr($dd1,0,1)=="0") $d=0;
		if (substr($dd1,0,1)=="1") $d=1;
		if (substr($dd1,0,1)=="2") $d=2;
		if (substr($dd1,0,1)=="3") $d=3;
		if (substr($dd1,0,1)=="4") $d=4;
		if (substr($dd1,0,1)=="5") $d=5;
		if (substr($dd1,0,1)=="6") $d=6;
		if (substr($dd1,0,1)=="7") $d=7;
		if (substr($dd1,0,1)=="8") $d=8;
		if (substr($dd1,0,1)=="9") $d=9;

		return $d;
	}

	else {

		for ($i=0; $i<$length; $i++) {
			$d=0;

			if (substr($dd1,$i,1)=="0") $d=0;
			if (substr($dd1,$i,1)=="1") $d=1;
			if (substr($dd1,$i,1)=="2") $d=2;
			if (substr($dd1,$i,1)=="3") $d=3;
			if (substr($dd1,$i,1)=="4") $d=4;
			if (substr($dd1,$i,1)=="5") $d=5;
			if (substr($dd1,$i,1)=="6") $d=6;
			if (substr($dd1,$i,1)=="7") $d=7;
			if (substr($dd1,$i,1)=="8") $d=8;
			if (substr($dd1,$i,1)=="9") $d=9;

			$c=$c*10+$d;
		}

		return $c;
	}
}

 $dd2 = "100413";

 $dd3 = convertChiffre($dd2);

if (compareDates($dd3)) $ss='true';
else $ss='false';

echo "<p>compareDates($dd3) : ".$ss."</p>";

function compareDates ($dd2){
	$d1 = date("d");
	$d2 = date("m");
	$d3 = date("y");

	$dd1="".$d1.$d2.$d3;

	echo "<p>".$dd1."<br>".$dd2."</p>";

	echo "<p>".$d1.'/'.$d2.'/'.$d3."</p>";

	return ($dd1==$dd2);
}

echo convertChiffre('12');

$df=(""."10"=="10"."");

if ($df) $s1='true';
else $s1='false';

echo "<p>".'""."10"=="10"."" : '.$s1."</p>";


?>