<?php
/**
 * Page de modification des informations du membre connecté
 */
require_once __DIR__ . '/../includes/init.php';

$_SESSION['pageCourante'] = $serveur . 'Membres/ModifierInformationMembre.php';

// Vérifier la connexion
if (!verifieConnection()) {
  header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
  exit;
}

// Récupérer les informations du membre connecté
$membre = getMembre($_SESSION['id']);
if (!$membre) {
  header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
  exit;
}

$anciennete = CalcAnciennete($membre["datedinscription"]);
$titrePage = "Modifier les informations du membre " . $_SESSION['id'];
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

<h1>Modifier les informations du membre <?= htmlspecialchars($_SESSION['id']) ?> :</h1>

<p class="texte"><a href="<?= $serveur ?>Membres/SupprimerMembre.php">Supprimer mon compte</a></p>

<table border="1">
  <tr>
    <th>Nom</th>
    <td><?= htmlspecialchars($membre['Nom']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=Nom">modifier</a></td>
  </tr>
  <tr>
    <th>Prénom</th>
    <td><?= htmlspecialchars($membre['Prenom']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=Prenom">modifier</a></td>
  </tr>
  <tr>
    <th>Identifiant</th>
    <td><?= htmlspecialchars($membre['id']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=id">modifier</a></td>
  </tr>
  <tr>
    <th>Adresse e-mail</th>
    <td><?= htmlspecialchars($membre['mail']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=mail">modifier</a></td>
  </tr>
  <tr>
    <th>Pays</th>
    <td><?= htmlspecialchars($membre['Pays']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=Pays">modifier</a></td>
  </tr>
  <tr>
    <th>Adresse (Code Postal)</th>
    <td><?= htmlspecialchars($membre['CodePostal']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=CodePostal">modifier</a></td>
  </tr>
  <tr>
    <th>Date de naissance</th>
    <td><?= convertDate($membre['DateNaissance']) ?></td>
    <td><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=DateNaissance">modifier</a></td>
  </tr>
</table>

<p class="texte"><a href="<?= $serveur ?>Membres/ModifierInfo.php?info=motdepasse">Modifier mon mot de passe</a></p>

<?php include __DIR__ . '/../templates/footer.php'; ?>
