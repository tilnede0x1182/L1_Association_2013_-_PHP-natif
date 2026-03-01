<?php
	include 'Utilitaires/Navigation/AdresseServeur.php';

	echo '	<p>redirection vers la <a href="'.$serveur.'Accueil/Accueil (1).php">page d'."'".'acceuil</a>...</p>'."\n";
	echo "<p>$serveur</p>";

	header('Location: '.$serveur.'Accueil/Accueil%20(1).php');
?>