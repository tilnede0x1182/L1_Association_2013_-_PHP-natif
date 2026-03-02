<?php session_start();
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if ((!empty($_SESSION['pageCourante'])) && (substr($_SESSION['pageCourante'],0,50)!=$serveur."Contenu/Projets/ListeAuteursProjets.php")) $pageprecedente = $_SESSION['pageCourante'];
	else $pageprecedente = "";
	$_SESSION['pageCourante']=$serveur."Contenu/Projets/ListeAuteursProjets.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Liste des auteurs d'un projet</title>
    <meta charset="utf-8" />
<?php
	include '../../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>
  <body>

<?php
	include '../../Fonctions/CalcAnciennete4.php';
	include '../../Utilitaires/Dates/ConversionDate.php';
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	include '../../Accueil/MenuAccueil.php';

	if (verifieConnection()) {

		include '../../Base_de_donnees/ConnectionBaseDonnees.php';

		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {

				include '../../Utilitaires/Verification/VerifieCompetence.php';

				if (!empty($_GET['idprojet'])) $idprojet = $_GET['idprojet'];
				else $idprojet = "";

				// Vérifier si l'utilisateur a le droit de voir cette page
				$reqProjet = 'SELECT id FROM projets WHERE idprojet="'.$idprojet.'"';
				$resProjet = mysqli_query($connexion, $reqProjet);
				$projetInfo = mysqli_fetch_array($resProjet);

				$estProprietaire = ($projetInfo && $projetInfo['id'] == $_SESSION['id']);
				$estAdmin = ($competence == 1);

				if ($estProprietaire || $estAdmin) {

					$_SESSION['pageCourante']=$serveur."Contenu/Projets/ListeAuteursProjets.php?idprojet=".$idprojet;

					echo '	 <table border="1">
	 <tr>
	  <th>Liste des auteurs du projet</th>
	  <th>Date de modification</th>
	 </tr>
	 <tr>'."\n";

					$requete = 'SELECT idmembre,date FROM dataprojets WHERE idprojet="'.$idprojet.'" ORDER BY date DESC, heure DESC';
					$resultat = mysqli_query($connexion, $requete);

					$cmp=0;

					while (true) {
						$cmp = $cmp+1;

						$ligne = mysqli_fetch_array($resultat);

						if ($ligne==false){
							if ($cmp==1){
								echo '	 <tr>'."\n".'	  <td colspan="2">Aucune modification depuis la publication du projet</td>'."\n".'	 </tr>'."\n";
								echo '</table>'."\n";
								break;
							}
							else break;
						}

						$idmembre = $ligne['idmembre'];
						$date = $ligne['date'];

						echo '	 </tr>'."\n";
						echo '	  <td><a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$idmembre.'">'.$idmembre.'</a></td>'."\n";
						echo '	  <td>'.convertDate($date).'</td>'."\n";
						echo '	 </tr>'."\n";
					}

					echo '	</table>'."\n";

					echo "<p>";

					if ($pageprecedente!="") echo '<a href="'.$pageprecedente.'">Retour</a><br>'."\n";

					else echo '<a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Retour à la page d'."'".'acceuil</a>'."\n";

					echo "</p>";

				} else {
					echo '<p>Vous n\'avez pas accès à cette page.</p>';
					echo '<p><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Retour à la page d\'accueil</a></p>';
				}
			}
		}
	}

	include '../../Utilitaires/Affichage/footer.php';

?>
