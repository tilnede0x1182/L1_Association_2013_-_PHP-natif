<?php
/**
 * Template de navigation
 * Nécessite : $serveur, fonctions verifieConnection() et verifieConnectionAdmin()
 */
$estConnecte = verifieConnection();
$estAdmin = $estConnecte ? verifieConnectionAdmin() : false;
?>

<img class="principale" src="<?= $serveur ?>assets/images/fonds/untitl10.jpg" alt="Paris Diderot">
<div class="clear"></div>
<h1 class="titre">Bienvenue sur le site des Anciens de Paris 7</h1>

<nav id="menuAcceuil">
	<ul>
		<li><a href="<?= $serveur ?>src/pages/Accueil/index.php">Accueil</a></li>
		<li><a href="<?= $serveur ?>src/pages/Accueil/Presentation.php">A propos</a></li>
		<li><a href="<?= $serveur ?>src/pages/Accueil/Contact.php">Nous contacter</a></li>
<?php if (!$estConnecte): ?>
		<li><a href="<?= $serveur ?>utils/ModifierStyle.php?couleur=1"><img src="<?= $serveur ?>assets/images/styles/Orangebicolore4.jpg" title="Style : Coucher de soleil" alt="Style orangé"></a></li>
		<li><a href="<?= $serveur ?>utils/ModifierStyle.php?couleur=2"><img src="<?= $serveur ?>assets/images/styles/vertbicolore2.jpg" title="Style : Rosée du matin" alt="Style vert clair"></a></li>
		<li><a href="<?= $serveur ?>utils/PageRedirectionVerslInscription.php">Projets</a></li>
	</ul>
</nav>

<?php if (strpos($_SERVER["SCRIPT_NAME"], "Auth/Connexion.php") === false): ?>
<div class="accesMembre">
	<p>Accès membres :</p>
	<form action="<?= $serveur ?>src/pages/Auth/Connexion.php" method="POST">
		<label>Identifiant : <input type="text" name="id"></label><br>
		<label>Mot de passe : <input type="password" name="motdepasse"></label><br>
		<input type="submit" value="Se connecter"><br>
		<a href="<?= $serveur ?>src/pages/Auth/Inscription.php">S'inscrire</a>
	</form>
</div>
<?php endif; ?>

<?php else: ?>
		<li><a href="<?= $serveur ?>src/pages/Membres/MonCompte.php">Modifier mes informations</a></li>
		<li><a href="<?= $serveur ?>src/pages/Membres/Liste.php">Voir la liste des membres</a></li>
		<li><a href="<?= $serveur ?>src/pages/Auth/Deconnexion.php">Se déconnecter</a></li>
		<li><a href="<?= $serveur ?>utils/ModifierStyle.php?couleur=1"><img src="<?= $serveur ?>assets/images/styles/Orangebicolore4.jpg" title="Style : Coucher de soleil" alt="Style orangé"></a></li>
		<li><a href="<?= $serveur ?>utils/ModifierStyle.php?couleur=2"><img src="<?= $serveur ?>assets/images/styles/vertbicolore2.jpg" title="Style : Rosée du matin" alt="Style vert clair"></a></li>
		<li style="margin-left: auto; padding: 8px 15px; background: linear-gradient(135deg, rgba(0,0,0,0.1), rgba(0,0,0,0.05)); border-radius: 20px; font-weight: 600; color: #555; font-size: 0.9em;">Connecté en tant que : <strong style="color: var(--couleur-fond); text-shadow: 1px 1px 2px rgba(0,0,0,0.3);"><?= htmlspecialchars($_SESSION['id']) ?></strong></li>
	</ul>
</nav>

<nav class="listeGauche">
	<ul>
		<li><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Projets</a></li>
		<li><a href="<?= $serveur ?>src/pages/Contenu/Projets/Participations.php">Demandes de participation</a></li>
<?php if ($estAdmin): ?>
		<li><a href="<?= $serveur ?>src/pages/Contenu/Articles/Creer.php">Ecrire un nouvel article</a></li>
<?php endif; ?>
	</ul>
</nav>

<?php endif; ?>
