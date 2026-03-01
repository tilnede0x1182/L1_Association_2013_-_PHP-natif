<?php

			$competence=0; //les droit de modifier les articles initialisé à 0 par défaut.

			if (!empty($_SESSION)){				
				$requete3 = 'SELECT competence FROM asso WHERE id="'.$_SESSION['id'].'"';
				$resultat3 = mysqli_query($connexion, $requete3);

				$ControleMembre = mysqli_fetch_array($resultat3);

				if ($ControleMembre!=false) {
					if (($ControleMembre['competence']=="President") || ($ControleMembre['competence']=="Secretaire") || ($ControleMembre['competence']=="Administrateur")) {
						$competence=1;
					}
				}
			}

?>