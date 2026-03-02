<?php
/**
 * Page de connexion (affichage des identifiants - debug)
 * Note: Cette page semble être une page de test/debug
 */
require_once __DIR__ . '/includes/init.php';

$titrePage = "Association - Connection (Membres)";
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

<?php if (isset($_POST['id'])): ?>
<p>
  Identifiant : <?= htmlspecialchars($_POST['id']) ?><br>
  Mot de passe : <?= htmlspecialchars($_POST['motdepasse']) ?>
</p>
<?php endif; ?>

<?php include __DIR__ . '/templates/footer.php'; ?>
