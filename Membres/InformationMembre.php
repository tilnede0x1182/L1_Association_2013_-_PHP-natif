<?php session_start();
	include '../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if ((!empty($_SESSION['pageCourante'])) && (substr($_SESSION['pageCourante'],0,(strlen($serveur)+21))!=$serveur."Membres/InformationMembre.php"))	$pagePrecedente = $_SESSION['pageCourante'];
	else $pagePrecedente = "";
	$_SESSION['pageCourante']=$serveur."Membres/InformationMembre.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
<?php
	include '../Utilitaires/Affichage/includeStylesheet.php';
	include '../Fonctions/CalcAnciennete4.php';
	include '../Utilitaires/Navigation/AdresseServeur.php';

	if (!empty($_GET['idmembre'])) $_SESSION['pageCourante']=$serveur."Membres/InformationMembre.php?idmembre=".$_GET['idmembre'];

	function convertDate ($dd1){
		if ($dd1!=0) {
			$d1=substr($dd1,0,2);
			$d2=substr($dd1,2,2);
			$d3=substr($dd1,4,4);
		
			$d="".$d1.'/'.$d2.'/'.$d3;
				
			return $d;
		}

		else return "Date non renseignée";	
	}

	include '../Base_de_donnees/ConnectionBaseDonnees.php';

	$connexion = mysqli_connect($server, $user, $motdepasse, $base);
	if (!$connexion) {
		echo "Pas de connexion au serveur" ;
	}else {
		if (!$connexion) {
			echo "Pas d'accès à la base" ;
		}else {
			$competence=0; //les droit de modifier les articles initialisé à 0 par défaut.

			if (!empty($_SESSION)){				
				$requete3 = 'SELECT competence FROM asso WHERE id="'.$_SESSION['id'].'"';
				$resultat3 = mysqli_query($connexion, $requete3);

				$ControleMembre = mysqli_fetch_array($resultat3);

				if ($ControleMembre!=false) {
					if (($ControleMembre['competence']=="President") || ($ControleMembre['competence']=="Secretaire") || ($ControleMembre['competence']=="Administrateur")) {
						$competence = 1;
					}
				}
			}

			if (isset($_GET['idmembre'])) $id = $_GET['idmembre'];
			else $id="";

			$competencedumembre = 0;

			if (!empty($id)){				
				$requete4 = 'SELECT competence FROM asso WHERE id="'.$id.'"';
				$resultat4 = mysqli_query($connexion, $requete4);

				$ControleceMembre = mysqli_fetch_array($resultat4);

				if ($ControleceMembre!=false) {
					if (($ControleceMembre['competence']=="President") || ($ControleceMembre['competence']=="Secretaire") || ($ControleceMembre['competence']=="Administrateur")) {
						$competencedumembre = 1;
					}
				}
			}

			$requete = 'SELECT * FROM asso WHERE id="'.$id.'"';
			$resultat = mysqli_query($connexion, $requete);

			$ligne = mysqli_fetch_array($resultat);

			$nom_du_membre=$ligne['id'];

			if (($ligne['datedudernierprojet']==-11) || ($ligne['datedudernierprojet']==0)) $datedudernierprojet = "Aucun projet à ce jour</td>\n";
			else $datedudernierprojet = convertDate($ligne['datedudernierprojet'])."  (".CalcAnciennete2($ligne['datedudernierprojet']).") </td>\n";

			if (($ligne['datedederniereconnection']==-11) || ($ligne['datedederniereconnection']==0))$datedederniereconnection = "Aucune connection</td>\n";
			else $datedederniereconnection = convertDate($ligne['datedederniereconnection'])."  (".CalcAnciennete2($ligne['datedederniereconnection']).") </td>\n";


			$connecte = "";

			if ($ligne['Connecte']==1) $connecte = "Oui";
			if ($ligne['Connecte']==0) $connecte = "Non";

			echo "    <title>Page d'information sur le membre ".$nom_du_membre.'</title>
    <meta charset="utf-8">
  </head>
  <body>'."\n";

			include '../Accueil/MenuAccueil.php';

			if (verifieConnection()) $connection=1;
			else $connection=0;

			echo "\n    <h1>Information sur le membre ".$nom_du_membre." : </h1>\n";
	    
			echo '      <table border="1">
			      <tr>
			        <th>Compétence</th>
			        <th>Identifiant</th>
			        <th>Date du dernier projet</th>'."\n";
			if (($competence==1) && ($competencedumembre==1)) echo '        <th>Liste des articles publiés par ce membre</th>';
			if ($connection==1) echo '       <th>Liste des projets</th>';
			echo '        <th>Connecté en ce moment</th>
			      </tr>';

			echo "\n	      <tr>\n";
				echo "<td>".$ligne['competence']."</td>\n";
				echo "<td>".$ligne['id']."</td>\n";
				echo "<td>".$datedudernierprojet.'</td>'."\n";
			if (($competence==1) && ($competencedumembre==1)) echo '<td><a href="'.$serveur.'Contenu/Posts/ListedesPosts.php?idmembre='.$id.'">Liste des articles publiés par ce membre</a></td>'."\n";
			if ($connection==1) echo '<td><a href="'.$serveur.'Contenu/Projets/ListedesProjet.php?idmembre='.$nom_du_membre.'">Liste des projets</a></td>'."\n";
				echo '<td>'.$connecte."\n";

		echo "\n".'                </tr>'."\n".'
	       	    </table>
	

			<p></p>

	     	        <table border="1">
			      <tr>
			        <th>Nombre de projets</th>'."\n";
			if (($competence==1) && ($competencedumembre==1)) echo '<th>Nombre d'."'".'articles publiés</th>'."\n";
			//if (($competence==1) && ($competencedumembre==1)) echo '<th>Nombre d'."'".'articles modifiés</th>'."\n";
			echo '        <th>Adresse e-mail</th>
			        <th>Date d'."'inscription</th>
			        <th>Ancienneté</th>
			        <th>Dernière connection</th>
			      </tr>";
	
		$anciennete = CalcAnciennete($ligne["datedinscription"]);
			
		echo "\n   <tr>\n";


				echo "<td>".$ligne['nombredeprojets']."</td>\n";
				if (($competence==1) && ($competencedumembre==1)) echo "<td>".$ligne['nombredeposts']."</td>\n";
				echo "<td>".$ligne['mail']."</td>\n";
				echo "<td>".convertDate($ligne["datedinscription"])."</td>\n";
				echo "<td>".$anciennete."</td>\n";
				echo "<td>".$datedederniereconnection;

				echo "      </tr>\n";

			echo '    </table>'."\n";

			if ($pagePrecedente!="") echo '<p class="texte"><a href="'.$pagePrecedente.'">Retour</a></p>'."\n";

		}
	}

	include '../Utilitaires/Affichage/footer.php';

?>


  </body>
</html>