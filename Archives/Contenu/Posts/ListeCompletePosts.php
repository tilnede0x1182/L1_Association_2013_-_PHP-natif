<?php session_start();
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Contenu/Posts/ListeCompletePosts.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Liste complète des articles</title>
<?php
	include '../../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>

  <body>

<?php

	$un=1;

	include '../../Accueil/MenuAccueil.php';
	include '../../Utilitaires/Verification/detectlId.php';
	include '../../Utilitaires/Dates/ConversionDate.php';
	include '../../Utilitaires/Navigation/AdresseServeur.php';

	include '../../Base_de_donnees/ConnectionBaseDonnees.php';
	
	$connexion = mysqli_connect($server, $user, $motdepasse, $base);
	if (!$connexion) {
		echo "Pas de connexion au serveur" ;
	}else {
		if (!$connexion) {
			echo "Pas d'accès à la base" ;
		}else {

			$requete1 = 'SELECT Post, Objet, date, idpost, id FROM posts ORDER BY date DESC, heure DESC';
			$resultat1 = mysqli_query($connexion, $requete1);

			include '../../Utilitaires/Verification/VerifieCompetence.php';
			
			//if ($competence==1) {

			$requete5 = 'SELECT * FROM posts ORDER by date DESC';
			$resultat5 = mysqli_query($connexion, $requete5);

			echo '    <table border="1">
			      <tr>
			        <th>Auteur</th>
			        <th>Titre de l'."'".' article</th>
			        <th>Dates de publication et de dernière modification</th>
			      </tr>';

			$tmp=0;

			while (true) {
				$tmp=$tmp+1;
				$ligne = mysqli_fetch_array($resultat5);

				if (($ligne==false) || ($tmp>199)) break;

				if (!empty($ligne['Objet'])) $titrearticle = $ligne['Objet'];
				else $titrearticle = "";

				$idpost = $ligne['idpost'];

				$requete2 = 'SELECT date FROM dataposts WHERE idpost="'.$idpost.'" ORDER BY date DESC';
				$resultat2 = mysqli_query($connexion, $requete2);

				$dataposts = mysqli_fetch_array($resultat2);

				if ($dataposts!=false) $affdataposts = ", dernière modification : ".convertDate($dataposts['date']);
				else $affdataposts="";
	
				echo "\n<tr>";	
					echo "<td>".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a></td>\n";
					echo '<th><a href="'.$serveur.'Contenu/Posts/AfficheArticle.php?idpost='.$idpost.'">'.$titrearticle."</a></th>\n";
					if ($competence==1) echo "<td>Publication : ".convertDate($ligne['date']).$affdataposts."</td>\n";
					else echo "<td>Publication : ".convertDate($ligne['date'])."</td>\n";	
					echo "      </tr>\n";
			}

			echo '    </table>'."\n";

			echo '	 <p><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Retour à la page d'."'".'acceuil</a></p>';
		
		}
	}

	include '../../Utilitaires/Affichage/footer.php';
?>

  </body>
</html>
