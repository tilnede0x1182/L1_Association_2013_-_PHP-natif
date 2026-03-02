<?php
/**
 * Formulaire de connexion (inclus dans d'autres pages)
 * Ce fichier est un snippet à inclure, pas une page complète
 */

// Vérifier que init.php a déjà été inclus
if (!function_exists('verifieConnection')) {
	require_once __DIR__ . '/../includes/init.php';
}

$erreurConnexion = "";
$afficherFormulaireConnexion = true;

// Traitement du formulaire
if (!empty($_POST["id"]) && !empty($_POST["motdepasse"])) {
	if (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"]) || !preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["motdepasse"])) {
		$erreurConnexion = "L'un des champs entrés contient des caractères spéciaux ou accentués.";
	} else {
		$_SESSION['id'] = $_POST['id'];
		$_SESSION['motdepasse'] = $_POST['motdepasse'];

		if (verifieConnection()) {
			connecterMembre($_SESSION['id'], $_SESSION['motdepasse']);
			$afficherFormulaireConnexion = false;
		}
	}
}

if ($afficherFormulaireConnexion):
?>
<div class="Accès membres">
	<p>Accès membres :</p>

	<?php if ($erreurConnexion): ?>
	<p class="erreur"><?= $erreurConnexion ?></p>
	<?php endif; ?>

	<form action="Connexion.php" method="POST">
		Identifiant : <input type="text" name="id"><br>
		Mot de passe : <input type="password" name="motdepasse"><br>
		<input type="submit" value="Se connecter"><br>
		<a href="<?= $serveur ?>Auth/Inscription.php">S'inscrire</a>
	</form>
</div>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<p><a href="<?= $_SESSION['pageCourante'] ?>">Retour</a></p>
<?php endif; ?>

<p><a href="<?= $serveur ?>Accueil/index.php">Aller à la page d'accueil</a></p>
<?php endif; ?>
