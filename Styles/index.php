<?php
	include '../Utilitaires/Navigation/AdresseServeur.php';

	echo '	<p>redirection vers la <a href="'.$serveur.'Accueil/index.php">page d'."'".'acceuil</a>...</p>'."\n";

	header('Location: '.$serveur.'Accueil/index.php'); 
?>