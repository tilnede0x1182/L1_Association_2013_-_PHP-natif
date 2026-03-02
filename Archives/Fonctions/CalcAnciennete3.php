<?php

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

function CalcAnciennete ($dd2){
	$d1 = date("d");
	$d2 = date("m");
	$d3 = date("Y");

	$dd1="".$d1.$d2.$d3;

	if ($dd1==$dd2) return ("Aujourd'hui.");

	if (!(convertChiffre(substr($dd1,4,4))-convertChiffre(substr($dd2,4,4))<0)) {
		if ((convertChiffre(substr($dd1,4,4))-convertChiffre(substr($dd2,4,4)))>0) {
			$a = (convertChiffre(substr($dd1,4,4))-convertChiffre(substr($dd2,4,4)));

			if ($a==1) return ("Il y a 1 an.");

			else return ("Il y a ".$a." ans.");
		}
	}

	else if (!(convertChiffre(substr($dd1,2,2))-convertChiffre(substr($dd2,2,2)))<0){

		if ((convertChiffre(substr($dd1,2,2))-convertChiffre(substr($dd2,2,2)))>0) {
			$b = (convertChiffre(substr($dd1,2,2))-convertChiffre(substr($dd2,2,2)));
			return ("Il y a ".$b." mois.");
		}
	}

	else if (!(convertChiffre(substr($dd1,0,2))-convertChiffre(substr($dd2,0,2)))<0) {
		if ((convertChiffre(substr($dd1,0,2))-convertChiffre(substr($dd2,0,2)))>=0) {
			$c = (convertChiffre(substr($dd1,0,2))-convertChiffre(substr($dd2,0,2)));

			if ($c==1) return ("Hier.");
	
			if ($c>1) return ("Il y a ".$c." jours.");
		}
	}
}

?>

