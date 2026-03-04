<?php
	if (!defined('RACINE_PROJET')) {
		include __DIR__ . '/../Utilitaires/Navigation/AdresseServeur.php';
	}
	include RACINE_PROJET . 'Inscription_Desinscription/VerifieConnection.php';
	include RACINE_PROJET . 'Inscription_Desinscription/verifieConnectionAdmin.php';

    echo '    <img class="principale" src="'.$serveur.'Ressources/Images/Fonds/untitl10.jpg" alt="Paris Diderot">'."\n".'	<div class="clear"></div>'."\n";
    echo '    <h1 class="titre">Bienvenue sur le site des Anciens de Paris 7</h1>'."\n";

	if (verifieConnection()) $b=1;
	else $b=0;

	$bb=0;
	

		echo '    <nav id="menuAccueil"><ul><li><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Accueil</a></li>
    <li><a href="'.$serveur.'Accueil/Presentation.php">A propos</a></li>
    <li><a href="'.$serveur.'Accueil/Contact.php">Nous contacter</a></li>'."\n";

	echo '	 <li><a href="'.$serveur.'Utilitaires/Affichage/ModifierStyle.php?couleur=1"><img src="'.$serveur.'Ressources/Images/Styles/Orangebicolore4.jpg" title="Style : &quot;Coucher de soleil&quot;" alt="Style orangé"></a></li>'."\n";
	echo '	 <li><a href="'.$serveur.'Utilitaires/Affichage/ModifierStyle.php?couleur=2"><img src="'.$serveur.'Ressources/Images/Styles/vertbicolore2.jpg" title="Style : &quot;Rosée du matin&quot;" alt="Style vert clair"></a></li>'."\n";


	if ($b==0) {

		echo '    <li><a href="'.$serveur.'Utilitaires/Navigation/PageRedirectionVerslInscription.php">Projets</a></li>'."\n";
		echo '    </ul></nav>'."\n";

		echo '	 <div class="accesMembre">
	    <p>Accès membres : </p>

	    <form action="'.$serveur.'Inscription_Desinscription/Connection1.php" method="POST">
		<label>Identifiant : <input type="text" name="id"></label><br>
		<label>Mot de passe : <input type="password" name="motdepasse"></label><br>
		<input type="submit" value="Se connecter"><br>
		<a href="'.$serveur.'Inscription_Desinscription/NouveauMembre3.php">S'."'inscrire</a>
	    </form>
	    </div>";
	}
	else {
		echo '    <li><a href="'.$serveur.'Inscription_Desinscription/Deconnection.php">Se déconnecter</a></li>'."\n";
		echo '    <li><a href="'.$serveur.'Membres/ModifierInformationMembre.php">Modifier mes informations</a></li>'."\n";
		echo '    <li><a href="'.$serveur.'Membres/ListeDesMembres.php">Voir la liste des membres</a></li></ul></nav>'."\n";
		echo '    <ul><nav class="listeGauche"<li><a href="'.$serveur.'Contenu/Projets/NouveauProjet.php">Projets</a></li>';
		if (verifieConnectionAdmin())	echo "\n".'    <li><a href="'.$serveur.'Contenu/Posts/EcritureNouveauPost.php">Ecrire un nouvel article</a></ul></li>';
	}

	echo "\n";	


	//session_destroy();
?>