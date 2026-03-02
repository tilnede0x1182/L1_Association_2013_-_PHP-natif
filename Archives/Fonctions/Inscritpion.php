<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Association - Inscription (nouveau membre)</title>
<?php
	include '../Utilitaires/Affichage/includeStylesheet.php';
	include '../Utilitaires/Navigation/AdresseServeur.php';
?>
  </head>
  <body>
<?php

	if($_SERVER["HTTP_REFERER"] !== $serveur."Inscription_Desinscription/NouveauMembre3.php") {
	    echo "	<h1>Attention !</h1>\n	<h4>Le formulaire a été soumis par une source externe.</h4>";
	}
	
	else if(empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["id"]) || empty($_POST["mail"])) {	
	    echo "<p>Veuillez compléter tous les champs munis d'une étoile (*).</p>";
	}

	else if((!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"])) || (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["nom"])) || (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["prenom"]))) {
		echo "<h1>Erreur</h1><h4>L'un des champs entrés contiens des caractères spéciaux ou accentués.</h4>";

	}

	else if ((isset($_POST['datenaissance'])) && (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["datenaissance"]))) {
		echo "<h1>Erreur</h1><h4>L'un des champs entrés contiens des caractères spéciaux ou accentués.</h4>";
	}

	else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){  
   		echo "L'adresse e-mail est incorrecte.";
	}

	else echo "Ok. Félicitations, tout est bon !";
	
?>

  </body>
</html>
