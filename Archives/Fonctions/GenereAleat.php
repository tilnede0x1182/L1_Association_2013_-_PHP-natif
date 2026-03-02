<?php

	//J'ai juste chagé le nom, mais c'est la fonction "mdp_aleatoire.php".

	function genere_aleat($nb_cars) {
		if(is_numeric($nb_cars) && ($nb_cars > 0) && (! is_null($nb_cars))) {
			$mdp = '';
			$cars_ok = 'ADGHFDGsdfghjF011456789';
			for($i = 0; $i <= $nb_cars; $i++) {
				//on recupere le i eme indice de $cars_ok aleatoirement
				$nb_aleatoire = rand(0, strlen($cars_ok) - 1);
				//on concatene mdp avec le ieme caractère de $cars_ok pris aleatoirement
				$mdp .= $cars_ok[$nb_aleatoire];
			}
			return $mdp;
		}
	}

	//echo genere_aleat(3);
 
?>

