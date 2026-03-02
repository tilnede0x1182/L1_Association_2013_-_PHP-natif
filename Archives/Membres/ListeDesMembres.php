<?php session_start();
	include '../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Membres/ListeDesMembres.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Liste des membres</title>
    <meta charset="utf-8" />
<?php
	include '../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>
  <body>


<?php

	include '../Fonctions/CalcAnciennete4.php';
	include '../Utilitaires/Dates/ConversionDate.php';
	include '../Utilitaires/Navigation/AdresseServeur.php';
	include '../Accueil/MenuAccueil.php';

	if (verifieConnection()) {


	include '../Base_de_donnees/ConnectionBaseDonnees.php';
	
	$connexion = mysqli_connect($server, $user, $motdepasse, $base);
	if (!$connexion) {
		echo "Pas de connexion au serveur" ;
	}else {
		if (!$connexion) {
			echo "Pas d'accès à la base" ;
		}else {

			$competence="";
			$id="";
			$datedudernierprojet="";
			$nombredeposts="";
			$nombredeprojets="";
			$datedederniereconnection="";
			$datedinscription="";
			$competence="";
			$croissant="";
			$decroissant="";

			if (isset($_POST['classement'])) {
				if ($_POST['classement']=="competence") $competence="selected";
				if ($_POST['classement']=="id") $id="selected";
				if ($_POST['classement']=="datedudernierprojet") $datedudernierprojet="selected";
				if ($_POST['classement']=="nombredeprojets") $nombredeprojets="selected";
				if ($_POST['classement']=="datedederniereconnection") $datedederniereconnection="selected";
				if ($_POST['classement']=="datedinscription") $datedinscription="selected";
				if ($_POST['classement']=="competence") $competence="selected";
			}
			else $id="selected";

			if (isset($_POST['ordre'])) {
				if ($_POST['ordre']=="ASC") $croissant="selected";
				if ($_POST['ordre']=="DESC") $decroissant="selected";
			}
			else $croissant="selected";

			echo '<nav class="ClassementResultats">
			<form action="'.$serveur.'Membres/ListeDesMembres.php" method="POST">
			<label>Trier par : <select name="classement">
			  <option '.$datedudernierprojet.' value="datedudernierpost">Date du dernier projet</option>
			  <option '.$datedinscription.' value="datedinscription">Date d'."'".'inscription</option>
			  <option '.$datedederniereconnection.' value="datedederniereconnection">Dernière connection</option>
			  <option '.$nombredeprojets.' value="nombredeprojets">Nombre de projets</option>
			  <option '.$id.' value="id">Identifiant</option>
			  <option '.$competence.' value="competence">Compétence</option>
			</select></label>
			<label> par ordre : <select name="ordre">
			  <option '.$decroissant.' value="DESC">Décroissant</option>
			  <option '.$croissant.' value="ASC">Croissant</option>
			</select></label>
			<input type="submit">
			</form>
			</nav>';

	
			if (!empty($_POST)) {
				if($_SERVER["HTTP_REFERER"] !== $serveur."Membres/ListeDesMembres.php") {
					echo 	"	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
					exit();
				}
			}
		
			if (empty($_POST['classement'])) $classement="id";
			else $classement = $_POST['classement'];

			if (empty($_POST['ordre'])) $ordre="ASC";
			else $ordre = $_POST['ordre'];

			//echo '$classement = '.$classement."\n".'$ordre = '.$ordre;		

			$requete = "SELECT * FROM asso  ORDER BY ".$classement." ".$ordre."" ;
			$resultat = mysqli_query($connexion, $requete);

			echo'    <table border="1">
			      <tr>
			        <th>Compétence</th>
			        <th>Identifiant</th>
			        <th>Date du dernier projet</th>
			        <th>Nombre de projets</th>
			        <th>Dernière connection</th>
			        <th>Date d'."'inscription</th>
			      </tr>";
			
			while (true){
				echo '   <tr>';
				$ligne = mysqli_fetch_array($resultat);

				if ($ligne==false) break;

				if (($ligne['datedudernierprojet']==-11) || ($ligne['datedudernierprojet']==0)) $datedudernierprojet = "Aucun projet à ce jour</td>\n";
				else $datedudernierprojet = convertDate($ligne['datedudernierprojet'])."  (".CalcAnciennete2($ligne['datedudernierprojet']).") </td>\n";

				if (($ligne['datedederniereconnection']==-11) || ($ligne['datedederniereconnection']==0))$datedederniereconnection = "Aucune connection</td>\n";
				else $datedederniereconnection = convertDate($ligne['datedederniereconnection'])."  (".CalcAnciennete2($ligne['datedederniereconnection']).") </td>\n";

				if (($ligne['datedinscription']==-11) || ($ligne['datedinscription']==0)) $datedinscription = convertDate($ligne['datedinscription']);
				else $datedinscription = convertDate($ligne['datedinscription'])."  (".CalcAnciennete2($ligne['datedinscription']).") </td>\n";

				echo "<td>".$ligne['competence']."</td>\n";
				echo "<td>".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a></td>\n";
				echo "<td>".$datedudernierprojet."";
				echo "<td>".$ligne['nombredeprojets']."</td>\n";
				echo "<td>".$datedederniereconnection;
				echo "<td>".$datedinscription."</td>\n";

				echo '      </tr>';
			}

			echo '    </table>'."\n";
		}
	}

	}

	else include '../Inscription_Desinscription/Connection2.php';

	include '../Utilitaires/Affichage/footer.php';

?>



  </body>
</html>