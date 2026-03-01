<?php
	session_start();

	if (empty($_SESSION['style'])) $_SESSION['style']=1;

	$ok = 0;

	include 'VerifieConnection.php';
	include 'Fonctions/includeStylesheet.php';
	include 'Fonctions/AdresseServeur.php';
		$g=0;

		//if($_SERVER["HTTP_REFERER"] !== $serveur."Accueil%20%281%29.php") {
		//	echo "	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
		//}
		
		//else 
		if(empty($_POST["id"]) || empty($_POST["motdepasse"])) {
		    	echo "<h4>Veuillez compléter tous les champs demandés.</h4>";
		}
		
		else if((!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"])) || (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["motdepasse"]))) {
			echo "<h1>Erreur</h1><h4>L'un des champs entrés contiens des caractères spéciaux ou accentués.</h4>";
		}
		
		else {
			$g=1;

		    	$_SESSION['id']=$_POST['id'];
		    	$_SESSION['motdepasse']=md5($_POST['motdepasse']);

			if (verifieConnection()) {
				echo '<h4>La connection s'."'".'est bien passée.</h4>';
				echo '<p><a href="'.$serveur.'Accueil%20%281%29.php">Retour à la page d'."'".'accueil</a></p>';

				include 'Fonctions/ConnectionBaseDonnees.php';

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

						if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
						else header('Location: '.$serveur.'Accueil%20%281%29.php');

					}
				}

			}

			else {
				$g=0;
				echo '<p>Identifiant ou mot de passe incorrect(s).</p>';
			}
		}
	
		if ($g==0) {
		    	echo "<h3>Entrez votre identifiant et votre mot de passe.</h3>";
			echo '    <div class="Accès membres">
		    <p>Accès membres : </p>
		
		    <form action="Connection1.php" method="POST">
			<label for="id">Identifiant : </label>
			<input type="text" name="id" id="id"><br>
			<label for="motdepasse">Mot de passe : </label>
			<input type="password" name="motdepasse" id="motdepasse"><br>
			<input type="submit" value="Se connecter"><br>
			<a href="'.$serveur.'NouveauMembre3.php">S'."'inscrire</a>
		    </form>
		    </div>";

		if (!empty($_SESSION['pageCourante'])) echo '<p><a href="'.$_SESSION['pageCourante'].'">Retour</a></p>';

     		echo '<p><a href="'.$serveur.'Accueil%20%281%29.php">Aller à la page d'."'".'accueil</a></p>';

		}	
?>