<?php session_start();
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Contenu/Projets/ListedesProjet.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;

	if (!empty($_GET['idmembre'])) $membre = $_GET['idmembre'];
	else $membre = "inconnu";

	$_SESSION['pageCourante']= $serveur."Contenu/Projets/ListedesProjet.php?idmembre=".$membre."";

	echo '<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>List des projets du membre '.$membre.' </title>
    <meta charset="utf-8" />'."\n";

	include '../../Utilitaires/Affichage/includeStylesheet.php';

	echo '  </head>
  <body>';

	include '../../Accueil/MenuAccueil.php';
	include '../../Utilitaires/Verification/detectlId.php';
	include '../../Utilitaires/Dates/ConversionDate.php';
	include '../../Utilitaires/Navigation/AdresseServeur.php';

	if (verifieConnection()){
	

			include '../../Base_de_donnees/ConnectionBaseDonnees.php';
	
			$connexion = mysqli_connect($server, $user, $motdepasse, $base);
			if (!$connexion) {
			echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {

					echo '<h1>Liste des projets du membre <a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$membre.'">'.$membre.'</a> : </h1>'."\n";

					
					$estAdmin = verifieConnectionAdmin();
					$estProprietaire = ($membre==$_SESSION['id']);

					echo '<table border="1">
	 <tr>';
					if ($estProprietaire || $estAdmin) echo '	  <th>Auteurs et dates de modification</th>';
					echo '	  <th>Contenu du projet</th>
	  <th>Date de publication</th>
	 </tr>';
	
					$requete = 'SELECT * FROM projets WHERE id="'.$membre.'" ORDER BY date DESC, heure DESC';
					$resultat = mysqli_query($connexion, $requete);

					$cmp=0;

					while (true) {
						$cmp=$cmp+1;

						$ligne = mysqli_fetch_array($resultat);

						if ($ligne==false){
							if ($cmp==1) {
								echo '<td colspan="3">Aucun projet à ce jour.</td>'."\n";
								echo '	</table>'."\n";
							}
							break;
						}else {
							//$objet = "";


							$idmembre = $ligne['id'];
							$idprojet = $ligne['idprojet'];

							echo '	 <tr>'."\n";

							// Afficher les modifications si proprietaire ou admin
							if ($estProprietaire || $estAdmin) {
								$reqModifs = 'SELECT idmembre, date FROM dataprojets WHERE idprojet="'.$idprojet.'" ORDER BY date DESC';
								$resModifs = mysqli_query($connexion, $reqModifs);
								echo '<td>';
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
								echo '</td>';
							}

							echo '	  <td><h4>'.$ligne['Objet'].' : </h4>'.nl2br(detectlId ($ligne['Texte']), false).'</td>'."\n";
							echo '	  <td>'.convertDate($ligne['date']).'</td>'."\n";

							echo '	 </tr>'."\n";
						}
					}

					echo '	</table>'."\n";
				}
			}
	}

	include '../../Utilitaires/Affichage/footer.php';
?>

  </body>
</html>