<?php
	function verifieConnectionMembre() {

		include 'Fonctions/ConnectionBaseDonnees.php';
	
		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {
	
				$requete = 'SELECT id,motdepasse,competence FROM asso WHERE id="'.$_SESSION['id'].'"';
				$resultat = mysqli_query($connexion, $requete);
	
				$ligne = mysqli_fetch_array($resultat);


				//echo "<p>id = ".$_SESSION['id']."\n<br>Mot de passe = ".$_SESSION['motdepasse']."</p>";
	
				if ($ligne==false) {
					//echo "<h4>L'utilisateur n'existe pas.</h4>";
					return false;
				}

				//echo "<p>id = ".$ligne['id']."\n<br>Mot de passe = ".$ligne['motdepasse']."</p>";

				if ($ligne['id']!=$_SESSION['id']) return false;
	
				if ($ligne['motdepasse']!=$_SESSION['motdepasse']) return false;

				//echo '$ligne['."'".'competence'."'".'] = '.$ligne['competence'];

				if (($ligne['competence']!="President") && ($ligne['competence']!="Secretaire") && ($ligne['competence']!="Administrateur")) return false;
	
				return true;			
			}
		}
	}

?>