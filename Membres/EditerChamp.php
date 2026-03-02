<?php
/**
 * Modification d'une information du membre connecté
 */
require_once __DIR__ . '/../includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
  header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
  exit;
}

/**
 * Vérifie la validité d'une date
 * @return bool
 */
function verifierDateInfo() {
  if (!empty($_POST['d1']) && !empty($_POST['d2']) && !empty($_POST['d3'])) {
    $jour = $_POST['d1'];
    $mois = $_POST['d2'];
    $annee = $_POST['d3'];

    if (!is_numeric($jour) || !is_numeric($mois) || !is_numeric($annee)) {
      return false;
    }

    if ($jour > 31 || $jour < 1 || $mois < 1 || $mois > 12) {
      return false;
    }

    // Mois de 30 jours
    if (in_array($mois, array(4, 6, 9, 11)) && $jour > 30) {
      return false;
    }

    // Février
    if ($mois == 2 && $jour > 29) {
      return false;
    }
  } elseif (!empty($_POST['d1']) || !empty($_POST['d2']) || !empty($_POST['d3'])) {
    return false;
  }

  return true;
}

// Récupérer le champ à modifier
$infomembre = isset($_GET['info']) ? $_GET['info'] : '';

// Liste des champs valides
$champsValides = array('motdepasse', 'mail', 'id', 'Nom', 'Prenom', 'CodePostal', 'DateNaissance', 'Pays');
if (!in_array($infomembre, $champsValides)) {
  header("Location: " . $serveur . "Membres/ModifierInformationMembre.php");
  exit;
}

// Labels pour chaque champ
$labels = array(
  'motdepasse' => 'votre nouveau mot de passe',
  'mail' => 'votre nouvelle adresse e-mail',
  'id' => 'votre nouvel identifiant',
  'Nom' => 'votre nom',
  'Prenom' => 'votre prénom',
  'CodePostal' => 'votre adresse (code postal)',
  'DateNaissance' => 'votre date de naissance',
  'Pays' => 'le pays où vous habitez'
);
$linfo = $labels[$infomembre];

$erreur = "";
$succes = false;

// Traitement du formulaire
if (!empty($_POST)) {
  $valide = true;

  if ($infomembre == "motdepasse") {
    // Vérification mot de passe
    if (empty($_POST["motdepasseactuel"]) || empty($_POST["motdepasse1"]) || empty($_POST["motdepasse"])) {
      $erreur = "Veuillez remplir tous les champs.";
      $valide = false;
    } elseif ($_POST["motdepasse1"] != $_POST["motdepasse"]) {
      $erreur = "Les deux mots de passe ne correspondent pas.";
      $valide = false;
    } elseif (md5($_POST["motdepasseactuel"]) != $_SESSION['motdepasse']) {
      $erreur = "Mot de passe actuel incorrect.";
      $valide = false;
    } elseif (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["motdepasse"])) {
      $erreur = "Le mot de passe contient des caractères non autorisés.";
      $valide = false;
    }

    if ($valide) {
      updateMembre($_SESSION['id'], 'motdepasse', md5($_POST["motdepasse1"]));
      $_SESSION['motdepasse'] = md5($_POST["motdepasse1"]);
      header('Location: ' . $serveur . 'Accueil/Accueil%20%281%29.php');
      exit;
    }
  } elseif ($infomembre == "DateNaissance") {
    if (!verifierDateInfo()) {
      $erreur = "La date n'est pas valide.";
      $valide = false;
    }

    if ($valide) {
      $date = $_POST['d1'] . $_POST['d2'] . $_POST['d3'];
      if ($date == "") $date = "-11";
      updateMembre($_SESSION['id'], 'DateNaissance', $date);
      header('Location: ' . $serveur . 'Membres/ModifierInformationMembre.php');
      exit;
    }
  } elseif ($infomembre == "id") {
    if (empty($_POST['id'])) {
      $erreur = "Veuillez entrer un identifiant.";
      $valide = false;
    } elseif (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST['id'])) {
      $erreur = "L'identifiant contient des caractères non autorisés.";
      $valide = false;
    } elseif (membreExiste($_POST['id'])) {
      $erreur = "Cet identifiant est déjà pris. Veuillez en trouver un autre.";
      $valide = false;
    }

    if ($valide) {
      $ancienId = $_SESSION['id'];
      $nouvelId = $_POST['id'];

      // Mettre à jour toutes les tables
      $connexion = getConnexion();
      mysqli_query($connexion, 'UPDATE asso SET id="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE id="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE posts SET id="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE id="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE projets SET id="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE id="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE dataposts SET idmembre="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE idmembre="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE dataprojets SET idmembre="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE idmembre="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE dataposts SET idauteur="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE idauteur="' . mysqli_real_escape_string($connexion, $ancienId) . '"');
      mysqli_query($connexion, 'UPDATE dataprojets SET idauteur="' . mysqli_real_escape_string($connexion, $nouvelId) . '" WHERE idauteur="' . mysqli_real_escape_string($connexion, $ancienId) . '"');

      $_SESSION['id'] = $nouvelId;
      header('Location: ' . $serveur . 'Accueil/Accueil%20%281%29.php');
      exit;
    }
  } elseif ($infomembre == "CodePostal") {
    if (empty($_POST['CodePostal'])) {
      $erreur = "Veuillez entrer un code postal.";
      $valide = false;
    } elseif (!is_numeric($_POST['CodePostal'])) {
      $erreur = "Le code postal doit être composé de chiffres.";
      $valide = false;
    }

    if ($valide) {
      updateMembre($_SESSION['id'], $infomembre, $_POST[$infomembre]);
      header('Location: ' . $serveur . 'Membres/ModifierInformationMembre.php');
      exit;
    }
  } elseif ($infomembre == "mail") {
    if (empty($_POST['mail'])) {
      $erreur = "Veuillez entrer une adresse e-mail.";
      $valide = false;
    } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
      $erreur = "L'adresse e-mail est incorrecte.";
      $valide = false;
    }

    if ($valide) {
      updateMembre($_SESSION['id'], $infomembre, $_POST[$infomembre]);
      header('Location: ' . $serveur . 'Membres/ModifierInformationMembre.php');
      exit;
    }
  } else {
    // Nom, Prenom, Pays
    if (empty($_POST[$infomembre])) {
      $erreur = "Veuillez remplir le champ.";
      $valide = false;
    } elseif (!preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST[$infomembre])) {
      $erreur = "Le champ contient des caractères non autorisés.";
      $valide = false;
    }

    if ($valide) {
      updateMembre($_SESSION['id'], $infomembre, $_POST[$infomembre]);
      header('Location: ' . $serveur . 'Membres/ModifierInformationMembre.php');
      exit;
    }
  }
}

// Récupérer la valeur actuelle
$valeurActuelle = "";
$dateActuelle = "";
if ($infomembre != "motdepasse") {
  $membre = getMembre($_SESSION['id']);
  if ($membre) {
    $valeurActuelle = isset($membre[$infomembre]) ? $membre[$infomembre] : "";
    if ($infomembre == "DateNaissance" && $valeurActuelle != -11) {
      $dateActuelle = $valeurActuelle;
    }
  }
}

$type = ($infomembre == "motdepasse") ? "password" : "text";
$titrePage = "Modifier mes informations";
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

<h2 class="texte">Modifier <?= $linfo ?> :</h2>

<?php if ($erreur): ?>
<h4 class="texte erreur"><?= $erreur ?></h4>
<?php endif; ?>

<form class="texte" action="<?= $serveur ?>Membres/ModifierInfo.php?info=<?= $infomembre ?>" method="POST">

<?php if ($infomembre == "motdepasse"): ?>
  <label>Entrez votre mot de passe actuel : <input type="password" name="motdepasseactuel" autofocus></label><br><br>
  <label>Entrez <?= $linfo ?> : <input type="password" name="<?= $infomembre ?>"></label><br>
  <label>Confirmer votre mot de passe : <input type="password" name="<?= $infomembre ?>1"></label><br>

<?php elseif ($infomembre == "DateNaissance"): ?>
  Entrez votre date de naissance :
  <input type="text" name="d1" size="2" value="<?= substr($dateActuelle, 0, 2) ?>" autofocus>/
  <input type="text" name="d2" size="2" value="<?= substr($dateActuelle, 2, 2) ?>">/
  <input type="text" name="d3" size="4" value="<?= substr($dateActuelle, 4, 4) ?>"> (JJ/MM/AAAA)<br>

<?php else: ?>
  <label>Entrez <?= $linfo ?> : <input type="<?= $type ?>" name="<?= $infomembre ?>" value="<?= htmlspecialchars($valeurActuelle) ?>" autofocus></label><br>
<?php endif; ?>

  <input type="submit" value="Modifier">
</form>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<p class="texte"><a href="<?= $_SESSION['pageCourante'] ?>">Annuler</a></p>
<?php else: ?>
<p class="texte"><a href="<?= $serveur ?>Membres/ModifierInformationMembre.php">Retour à la page de modification de vos informations.</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
