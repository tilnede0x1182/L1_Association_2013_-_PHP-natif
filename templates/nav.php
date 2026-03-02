<?php
/**
 * Template de navigation
 * Nécessite : $serveur, fonctions verifieConnection() et verifieConnectionMembre()
 */
$estConnecte = verifieConnection();
$estAdmin = $estConnecte ? verifieConnectionMembre() : false;
?>

<img class="principale" src="<?= $serveur ?>Ressources/Images/Fonds/untitl10.jpg" alt="Paris Diderot">
<div class="clear"></div>
<h1 class="titre">Bienvenue sur le site des Anciens de Paris 7</h1>

<nav id="menuAcceuil">
	<ul>
		<li><a href="<?= $serveur ?>Accueil/Accueil%20%281%29.php">Accueil</a></li>
		<li><a href="<?= $serveur ?>Accueil/Presentation.php">A propos</a></li>
		<li><a href="<?= $serveur ?>Accueil/Contact.php">Nous contacter</a></li>
		<li><a href="<?= $serveur ?>Utilitaires/Affichage/ModifierStyle.php?couleur=1"><img src="<?= $serveur ?>Ressources/Images/Styles/Orangebicolore4.jpg" title="Style : Coucher de soleil" alt="Style orangé"></a></li>
		<li><a href="<?= $serveur ?>Utilitaires/Affichage/ModifierStyle.php?couleur=2"><img src="<?= $serveur ?>Ressources/Images/Styles/vertbicolore2.jpg" title="Style : Rosée du matin" alt="Style vert clair"></a></li>

<?php if (!$estConnecte): ?>
		<li><a href="<?= $serveur ?>Utilitaires/Navigation/PageRedirectionVerslInscription.php">Projets</a></li>
	</ul>
</nav>

<div class="accesMembre">
	<p>Accès membres :</p>
	<form action="<?= $serveur ?>Inscription_Desinscription/Connection1.php" method="POST">
		<label>Identifiant : <input type="text" name="id"></label><br>
		<label>Mot de passe : <input type="password" name="motdepasse"></label><br>
		<input type="submit" value="Se connecter"><br>
		<a href="<?= $serveur ?>Inscription_Desinscription/NouveauMembre3.php">S'inscrire</a>
	</form>
</div>

<?php else: ?>
		<li><a href="<?= $serveur ?>Inscription_Desinscription/Deconnection.php">Se déconnecter</a></li>
		<li><a href="<?= $serveur ?>Membres/ModifierInformationMembre.php">Modifier mes informations</a></li>
		<li><a href="<?= $serveur ?>Membres/ListeDesMembres.php">Voir la liste des membres</a></li>
	</ul>
</nav>

<nav class="listeGauche">
	<ul>
		<li><a href="<?= $serveur ?>Contenu/Projets/NouveauProjet.php">Projets</a></li>
<?php if ($estAdmin): ?>
		<li><a href="<?= $serveur ?>Contenu/Posts/EcritureNouveauPost.php">Ecrire un nouvel article</a></li>
<?php endif; ?>
	</ul>
</nav>

<?php endif; ?>
