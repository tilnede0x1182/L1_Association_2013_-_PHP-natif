<?php session_start();
	include 'Fonctions/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."ListedesPosts.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;

	if (!empty($_GET['idmembre'])) $membre = $_GET['idmembre'];
	else $membre = "inconnu";

	$_SESSION['pageCourante']=$serveur."ListedesPosts.php?idmembre=".$membre."";

	echo '<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>List des articles publiés par le membre '.$membre.' </title>
    <meta charset="utf-8" />'."\n";

	include 'Fonctions/includeStylesheet.php';

  echo '</head>
  <body>';

	include 'MenuAccueil.php';
	include 'Fonctions/detectlId.php';
	include 'Fonctions/ConversionDate.php';
	include 'Fonctions/AdresseServeur.php';

	if (verifieConnection()){
	

			include 'Fonctions/ConnectionBaseDonnees.php';
	
			$connexion = mysqli_connect($server, $user, $motdepasse, $base);
			if (!$connexion) {
			echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {

					echo '<h1>Liste des articles publiés par le membre <a href="'.$serveur.'InformationMembre.php?idmembre='.$membre.'">'.$membre.'</a> : </h1>'."\n";

					echo '<table border="1">
	 <tr>
	  <th>Contenu de l'."'".'article actuel</th>
	  <th>Date de publication</th>
	  <th>Modifiaction</th>
	 </tr>';
	
					$requete = 'SELECT * FROM posts WHERE id="'.$membre.'" ORDER BY date DESC, heure DESC';
					$resultat = mysqli_query($connexion, $requete);

					$cmp=0;

					while (true) {
						$cmp=$cmp+1;

						$ligne = mysqli_fetch_array($resultat);

						if ($ligne==false){
							if ($cmp==1) {
								echo '<td colspan="3">Aucun article publié à ce jour.</td>'."\n";
								echo '	</table>'."\n";
							}
							break;
						}else {
							//$objet = "";

							$idpost = $ligne['idpost'];

							echo '	 <tr>'."\n";
	
							echo '	  <td><h4><a href="'.$serveur.'AfficheArticle.php?idpost='.$idpost.'">'.$ligne['Objet'].'</a></h4>'.nl2br(detectlId ($ligne['Post']), false).'</td>'."\n";
							echo '	  <td>'.convertDate($ligne['date']).'</td>'."\n";
							echo '	  <td><div class="lien"><a href="'.$serveur.'ModifierArticle.php?idarticle='.$idpost.'">modifier</a></div><br><br><br>'."\n".'<div class="lien"><a href="'.$serveur.'SupprimerArticle.php?idpost='.$idpost.'"">supprimer</a></div></td>';
							echo '	 </tr>'."\n";
						}
					}

					echo '	</table>'."\n";
				}
			}
	}

?>

  </body>
</html>