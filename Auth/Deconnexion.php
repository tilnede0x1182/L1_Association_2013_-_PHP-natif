<?php
/**
 * Déconnexion membre
 */
require_once __DIR__ . '/../includes/init.php';

if (verifieConnection()) {
	// Déconnecter le membre
	deconnecterMembre($_SESSION['id'], $_SESSION['motdepasse']);

	// Réinitialiser la session
	$_SESSION['id'] = 80;
	$_SESSION['motdepasse'] = 80;
}

// Redirection
if (!empty($_SESSION['pageCourante'])) {
	header('Location: ' . $_SESSION['pageCourante']);
} else {
	header('Location: ' . $serveur . 'Accueil/Accueil%20%281%29.php');
}
exit;
?>
