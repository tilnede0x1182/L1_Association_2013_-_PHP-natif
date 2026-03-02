<?php
/**
 * Page de redirection vers inscription/connexion
 */
require_once __DIR__ . '/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "utils/PageRedirectionVerslInscription.php";

if (verifieConnection()) {
	header('Location: ' . $serveur . 'src/pages/Contenu/Projets/Liste.php');
	exit;
}

$titrePage = "Contenu privé";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?= $titrePage ?></title>
	<?= includeStylesheet() ?>
</head>
<body>

<?php include __DIR__ . '/templates/nav.php'; ?>

<div class="texte">
	<h2>Contenu privé</h2>
	<p>Pour voir cette page vous devez vous <a href="<?= $serveur ?>src/pages/Auth/Inscription.php">inscrire</a> ou, si c'est déjà fait, <a href="<?= $serveur ?>src/pages/Auth/Connexion.php">vous identifier</a>.</p>
</div>

<?php include __DIR__ . '/templates/footer.php'; ?>
</body>
</html>

