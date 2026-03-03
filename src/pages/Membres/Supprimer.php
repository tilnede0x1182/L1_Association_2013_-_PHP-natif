<?php
/**
 * Suppression du compte membre
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
  header("Location: " . $serveur . "src/pages/Accueil/index.php");
  exit;
}

// Vérifier si admin supprime un autre membre
$estAdmin = verifieConnectionAdmin();
$idMembreCible = isset($_GET['idmembre']) && $estAdmin ? $_GET['idmembre'] : $_SESSION['id'];
$estPropreSon = ($idMembreCible == $_SESSION['id']);

$idmembre = $idMembreCible;
$motdepasse = $estPropreSon ? $_SESSION['motdepasse'] : null;
$supprime = false;
$annule = false;

// Traitement du formulaire
if (!empty($_POST)) {
  if ($_POST['choix'] == 1) {
    if ($estPropreSon) {
      supprimerMembreAvecVerification($idmembre, $motdepasse);
      // Déconnecter le membre
      $_SESSION['id'] = 80;
      $_SESSION['motdepasse'] = 80;
    } else {
      // Admin supprime un autre membre
      supprimerMembre($idmembre);
    }
    $supprime = true;
  } else {
    // Annulation
    if (!empty($_SESSION['pageCourante'])) {
      header('Location: ' . $_SESSION['pageCourante']);
    } else {
      header('Location: ' . $serveur . 'src/pages/Accueil/index.php');
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

<?php include __DIR__ . '/../../../utils/templates/nav.php'; ?>

<div class="lien"><p><a href="<?= $serveur ?>src/pages/Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<?php if ($supprime): ?>
<?php if ($estPropreSon): ?>
<h4>Votre compte, ainsi que tous les projets que vous avez postés ont été supprimés.</h4>
<?php else: ?>
<h4>Le compte de <?= htmlspecialchars($idmembre) ?>, ainsi que tous ses projets ont été supprimés.</h4>
<?php endif; ?>
<p><a href="<?= $serveur ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a>.</p>

<?php elseif (empty($_POST)): ?>
<?php if ($estPropreSon): ?>
<h4 class="texte">Attention, vous êtes sur le point de supprimer votre compte.<br>
La suppression de votre compte entraînera la perte de tous vos projets.<br><br>
Souhaitez-vous réellement supprimer votre compte ?</h4>
<?php else: ?>
<h4 class="texte">Attention, vous êtes sur le point de supprimer le compte de <?= htmlspecialchars($idmembre) ?>.<br>
La suppression de ce compte entraînera la perte de tous ses projets.<br><br>
Souhaitez-vous réellement supprimer ce compte ?</h4>
<?php endif; ?>

<form action="" method="POST" class="form-inline">
  <input name="choix" value="1" type="hidden">
  <input type="submit" value="Oui">
</form>

<form action="" method="POST" class="form-inline">
  <input name="choix" value="0" type="hidden">
  <input type="submit" value="Annuler">
</form>
<?php endif; ?>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
