<?php
	include '../Utilitaires/Navigation/AdresseServeur.php';

	echo '	<p>redirection vers la <a href="'.$serveur.'Accueil/Accueil%20%281%29.php">page d'."'".'acceuil</a>...</p>'."\n";

	header('Location: '.$serveur.'Accueil/Accueil%20%281%29.php'); 
?>