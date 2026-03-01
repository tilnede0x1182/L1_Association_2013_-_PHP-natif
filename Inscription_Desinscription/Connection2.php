<?php

		$g=0;

		include '../Utilitaires/Navigation/AdresseServeur.php';
		include '../Utilitaires/Affichage/includeStylesheet.php';

		//if($_SERVER["HTTP_REFERER"] !== $serveur."Projet1/Accueil%20%281%29.php") {
		//	echo "	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
		//}
		
		//else 
		if(empty($_POST["id"]) || empty($_POST["motdepasse"])) {
		    	echo "<p>Entrez votre identifiant et votre mot de passe.</p>";
		}
		
		else if((!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"])) || (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["motdepasse"]))) {
			echo "<h1>Erreur</h1><h4>L'un des champs entrés contiens des caractères spéciaux ou accentués.</h4>";
		}
		
		else {
			$g=1;

		    	$_SESSION['id']=$_POST['id'];
		    	$_SESSION['motdepasse']=$_POST['motdepasse'];

			if (verifieConnection()) {
				echo '<h4>La connection s'."'".'est bien passée.</h4>';
				echo '<p><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Retour à la page d'."'".'accueil</a></p>';
			

				include '../Base_de_donnees/ConnectionBaseDonnees.php';

				$connexion = mysqli_connect($server, $user, $motdepasse, $base);

				if (!$connexion) {
					echo "Pas de connexion au serveur" ;
				}else {
					if (!$connexion) {
						echo "Pas d'accès à la base" ;
					}else {
	
						$date = date("dmY");
						//echo $date;
	
						$sql = 'UPDATE asso SET datedederniereconnection="'.$date.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
	
	
						$sql = 'UPDATE asso SET Connecte="1" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
					}
				}

			}

			else $g=0;
		}
	
		if ($g==0) {
			echo '    <div class="Accès membres">
		    <p>Accès membres : </p>
		
		    <form action="Connection1.php" method="POST">
			Identifiant : <input type="text" name="id"><br>
			Mot de passe : <input type="password" name="motdepasse"><br>
			<input type="submit" value="Se connecter"><br>
			<a href="'.$serveur.'Inscription_Desinscription/NouveauMembre3.php">S'."'inscrire</a>
		    </form>
		    </div>";

		if (!empty($_SESSION['pageCourante'])) echo '<p><a href="'.$_SESSION['pageCourante'].'">Retour</a></p>';

		echo '<p><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Aller à la page d'."'".'accueil</a></p>';

		}
?>