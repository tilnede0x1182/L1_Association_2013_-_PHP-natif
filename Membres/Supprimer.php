<?php
/**
 * Suppression du compte membre
 */
require_once __DIR__ . '/../includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
  header("Location: " . $serveur . "Accueil/index.php");
  exit;
}

$idmembre = $_SESSION['id'];
$motdepasse = $_SESSION['motdepasse'];
$supprime = false;
$annule = false;

// Traitement du formulaire
if (!empty($_POST)) {
  if ($_POST['choix'] == 1) {
    supprimerMembreAvecVerification($idmembre, $motdepasse);
    $supprime = true;
    // Déconnecter le membre
    $_SESSION['id'] = 80;
    $_SESSION['motdepasse'] = 80;
  } else {
    // Annulation
    if (!empty($_SESSION['pageCourante'])) {
      header('Location: ' . $_SESSION['pageCourante']);
    } else {
      header('Location: ' . $serveur . 'Accueil/index.php');
    }
    exit;
  }
}

$titrePage = "Suppression d'un membre";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $titrePage ?></title>
  <?= includeStylesheet() ?>
</head>
<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="lien"><p><a href="<?= $serveur ?>Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<?php if ($supprime): ?>
<h4>Votre compte, ainsi que tous les projets que vous avez postés ont été supprimés.</h4>
<p><a href="<?= $serveur ?>Accueil/index.php">Retour à la page d'accueil</a>.</p>

<?php elseif (empty($_POST)): ?>
<h4>Attention, vous êtes sur le point de supprimer votre compte.<br>
La suppression de votre compte entraînera la perte de tous vos projets.<br><br>
Souhaitez-vous réellement supprimer votre compte ?</h4>

<form action="" method="POST" style="display: inline;">
  <input name="choix" value="1" type="hidden">
  <input type="submit" value="Oui">
</form>

<form action="" method="POST" style="display: inline;">
  <input name="choix" value="0" type="hidden">
  <input type="submit" value="Annuler">
</form>
<?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
