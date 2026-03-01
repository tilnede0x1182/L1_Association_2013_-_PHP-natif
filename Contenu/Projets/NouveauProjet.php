<?php session_start();
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Contenu/Projets/NouveauProjet.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Nouveau Projet</title>
<?php
	include '../../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>

  <body>

<?php
	include '../../Accueil/MenuAccueil.php';
	include '../../Utilitaires/Verification/detectlId.php';
	include '../../Utilitaires/Dates/ConversionDate.php';
	include '../../Utilitaires/Navigation/AdresseServeur.php';

	if (verifieConnection()){

		echo "\n".'    <div class="lien"><p><a href="'.$serveur.'Contenu/Projets/CreationNouveauProjet.php">Nouveau projet</a></p></div>'."\n\n";


		include '../../Base_de_donnees/ConnectionBaseDonnees.php';
		
		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {

				$estAdmin = verifieConnectionMembre();

				$requete = 'SELECT * FROM projets ORDER by date DESC, heure DESC';
				$resultat = mysqli_query($connexion, $requete);

				echo '    <table border="1">
				<tr>
					<th>Auteurs et dates de modification</th>
					<th>Derniers projets</th>
					<th>Date de publication</th>
				</tr>';

				$tmp=0;

				while (true) {
					$tmp=$tmp+1;
					$ligne = mysqli_fetch_array($resultat);

					if (($ligne==false) || ($tmp>15)) break;

					$idmembre = $ligne['id'];
					$idprojet = $ligne['idprojet'];
					
					echo "\n<tr>";
					
					$estProprietaire = ($idmembre == $_SESSION['id']);
					echo "<td>".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a>";
					// Afficher les modifications si admin ou proprietaire
					if ($estAdmin || $estProprietaire) {
						$reqModifs = 'SELECT idmembre, date FROM dataprojets WHERE idprojet="'.$idprojet.'" ORDER BY date DESC';
						$resModifs = mysqli_query($connexion, $reqModifs);
						echo '<br><br>';
						$nbModifs = 0;
						while ($modif = mysqli_fetch_array($resModifs)) {
							$nbModifs++;
							if ($nbModifs <= 3) {
								echo '<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$modif['idmembre'].'">'.$modif['idmembre'].'</a> ('.convertDate($modif['date']).')<br>';
							}
						}
						if ($nbModifs == 0) echo 'Aucune modification';
						elseif ($nbModifs > 5) echo '<a href="'.$serveur.'Contenu/Projets/ListeAuteursProjets.php?idprojet='.$idprojet.'">Afficher la liste</a>';
						elseif ($nbModifs > 3) echo '... et '.($nbModifs - 3).' autres';
					}
					echo "</td>\n";
					echo "<td><h4>".$ligne['Objet']." : <br></h4>".nl2br(detectlId ($ligne['Texte']), false)."</td>\n";
					echo "<td>".substr($ligne["date"],0,2)."/".substr($ligne["date"],2,2)."/".substr($ligne["date"],4,4)."</td>\n";
					
					echo "      </tr>\n";
				}

				echo '    </table>';
				
			}

		}

		echo'    <p><div class="lien"><a href="'.$serveur.'Contenu/Projets/CreationNouveauProjet.php">Nouveau projet</a></p></div>    
		</body>';

	}

	include '../../Utilitaires/Affichage/footer.php';

?>

</html>
