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

	if ($dd2==0) return "Non renseignée";
	
	$a1=convertChiffre(substr($dd1,4,4))-convertChiffre(substr($dd2,4,4));
	$a2=convertChiffre(substr($dd1,2,2))-convertChiffre(substr($dd2,2,2));
	$a3=convertChiffre(substr($dd1,0,2))-convertChiffre(substr($dd2,0,2));

	if ($dd1==$dd2) return ("Inscrit aujourd'hui.");

	if ($a1>0) {
		if ($a1==1) return ("1 an");
		else return ("".$a1." ans");
	}
	
	else if ($a2>0){
		$b = $a2;
		return ("".$a2." mois");
	}

	else if ($a3>0) {
		if ($a3==1) return ("Inscrit hier");
		else return ("".$a3." jours");
	}
}

function CalcAnciennete2 ($dd2){
	$d1 = date("d");
	$d2 = date("m");
	$d3 = date("Y");

	$dd1="".$d1.$d2.$d3;

	if ($dd1==0) return "Non renseignée";
	
	$a1=convertChiffre(substr($dd1,4,4))-convertChiffre(substr($dd2,4,4));
	$a2=convertChiffre(substr($dd1,2,2))-convertChiffre(substr($dd2,2,2));
	$a3=convertChiffre(substr($dd1,0,2))-convertChiffre(substr($dd2,0,2));

	if ($dd1==$dd2) return ("Aujourd'hui");

	if ($a1>0) {
		if ($a1==1) return ("Il y a 1 an");
		else return ("Il y a ".$a1." ans");
	}
	
	else if ($a2>0){
		$b = $a2;
		return ("Il y a ".$a2." mois");
	}

	else if ($a3>0) {
		if ($a3==1) return ("Hier");
		else return ("Il y a ".$a3." jours");
	}
}


?>

