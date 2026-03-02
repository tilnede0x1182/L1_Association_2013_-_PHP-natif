<?php
/**
 * Modifie le style (couleur) et redirige vers la page précédente
 */
require_once __DIR__ . '/includes/init.php';

// Récupérer le style demandé
$style = isset($_GET['couleur']) ? $_GET['couleur'] : "1";

// Mettre à jour la session
if ($style == "1" || $style == "2") {
	$_SESSION['style'] = $style;
}

// Rediriger vers la page précédente ou l'accueil
if (!empty($_SESSION['pageCourante'])) {
	header('Location: ' . $_SESSION['pageCourante']);
} else {
	header('Location: ' . $serveur . 'src/pages/Accueil/index.php');
}
exit;
