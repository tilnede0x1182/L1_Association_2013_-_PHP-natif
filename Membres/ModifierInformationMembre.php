<?php session_start();
	include '../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
	$_SESSION['pageCourante']=$serveur.'Membres/ModifierInformationMembre.php';
	include '../Fonctions/includeStylesheet2.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
<?php
	echo includeStylesheet2();
?>
    <meta charset="utf-8">
<?php

	function verifieConnection2 (){
		if (($_SESSION['id']!=80) && ($_SESSION['motdepasse']!=80)) {

			include '../Base_de_donnees/ConnectionBaseDonnees.php';	
			
			$connexion = mysqli_connect($server, $user, $motdepasse, $base);
			if (!$connexion) {
				echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {
					
					$requete = 'SELECT id,motdepasse FROM asso WHERE id="'.$_SESSION['id'].'"';
					$resultat = mysqli_query($connexion, $requete);
					
					$ligne = mysqli_fetch_array($resultat);
					
					if ($ligne==false) return false;
					//le membre n'existe pas.
					
					if ($ligne['motdepasse']!=$_SESSION['motdepasse']) return false;
					else return true;
				}
			}
		}
	}

	if (verifieConnection2 ()) {

		include '../Fonctions/CalcAnciennete4.php';

		function convertDate ($dd1){
			if (($dd1!="0") && ($dd1!="-11")) {
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
		}
		else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}
			else {

				$id = $_SESSION['id'];

				$requete = 'SELECT * FROM asso WHERE id="'.$id.'"';
				$resultat = mysqli_query($connexion, $requete);

				$ligne = mysqli_fetch_array($resultat);

				$anciennete = CalcAnciennete($ligne["datedinscription"]);

				echo "    <title>Modifier les information du membre ".$id.'</title>
 </head>
 <body>';

				include '../Accueil/MenuAccueil.php';
				
				echo "\n    <h1>Modifier les informations du membre ".$id." : </h1>\n";

				echo '    <p class="texte"><a href="'.$serveur.'Membres/SupprimerMembre.php">Suprimer mon compte</a></p>';

				echo '      <table border="1">';

				echo "<tr><th>Nom</th><td>".$ligne['Nom']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=Nom">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Prénom</th><td>".$ligne['Prenom']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=Prenom">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Identifiant</th><td>".$ligne['id']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=id">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Adresse e-mail</th><td>".$ligne['mail']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=mail">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Pays</th><td>".$ligne['Pays']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=Pays">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Adresse (Code Postal)</th><td>".$ligne['CodePostal']."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=CodePostal">modifier</a></td>'."</tr>\n";
				echo "<tr><th>Date de naissance</th><td>".convertDate($ligne['DateNaissance'])."</td>".'<td><a href="'.$serveur.'Membres/ModifierInfo.php?info=DateNaissance">modifier</a></td>'."</tr>\n";

				echo "\n";

				echo '    </table>';

				echo '    <p class="texte"><a href="'.$serveur.'Membres/ModifierInfo.php?info=motdepasse">Modifier mon mot de passe</a></p>'."\n";

			}

		}

	}else {
		header("Location: ".$serveur."Accueil/Accueil%20%281%29.php");
		exit;
	}

	include '../Utilitaires/Affichage/footer.php';

?>
 </body>
</html>
