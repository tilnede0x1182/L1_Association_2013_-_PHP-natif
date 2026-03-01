<?php

function detectlId ($dd1) {

	include 'AdresseServeur.php';

	$f="";
	$l="";

	$length = strlen($dd1);

	for ($i=0; $i<$length; $i++){
		$f=substr($dd1,$i,14);

		if ($f=='[pseudo=&quot;'){
			$e=14;
			$h=$i+13;
			$j="";
			$g="";
			while (($g!='&quot;]') && ($h<($length-1))) {
				$h=$h+1;
				$e=$e+1;

				if (substr($dd1,$h,1)!='&') {
					$j=$j.substr($dd1,$h,1)."";
				}
	
				$g=substr($dd1,$h,7);
			}


			include 'ConnectionBaseDonnees.php';
	
			$connexion = mysqli_connect($server, $user, $motdepasse, $base);

			if (!$connexion) {
				echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {

					$requete = 'SELECT id FROM asso WHERE id="'.$j.'"';
					$resultat = mysqli_query($connexion, $requete);
		
					$ligne = mysqli_fetch_array($resultat);

					if ($ligne==false) $l=$l.$j; 
					//le membre n'existe pas ou plus.
					else $l=$l.'<a href="'.$serveur.'InformationMembre.php?idmembre='.$j.'">'.$j."</a>";
				}
			}

			$i=$i+$e+5;
		}

		else $l=$l.substr($dd1,$i,1)."";
	}

	return $l;
}

?>