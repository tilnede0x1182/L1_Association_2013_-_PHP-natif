<?php

$f="54654654864";

echo convertChiffre($f);

echo "<p>".$f."</p>";

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


?>