<?php session_start();
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
	include '../Fonctions/includeStylesheet2.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Association - Inscription (nouveau membre)</title>
<?php
	echo includeStylesheet2();
?>
  </head>

  <body>

<?php
	include '../Fonctions/GenereAleat.php';
	include '../Utilitaires/Navigation/AdresseServeur.php';

	function verifiedate (){
		if ((!empty($_POST['d1'])) && (!empty($_POST['d2'])) && (!empty($_POST['d3']))) {
			$d1=$_POST['d1'];
			$d2=$_POST['d2'];
			$d3=$_POST['d3'];
			$date=$d2.$d1.$d3;

			if ((is_numeric($d1)) && (is_numeric($d2)) && (is_numeric($d3))){
				if ($d1>31 || $d1<0 || $d2<0 || $d2>12)	{
					echo "La date n'est pas valide";
					return false;
				}

				if ($d2==4 || $d2==6 || $d2==9 || $d2==11){
					if ($d1>30) {
						echo "La date n'est pas valide";
						return false;
					}
				}

				if ($d2==2) {
					if ($d1>29) {
						echo "La date n'est pas valide";
						return false;
					}
				}
			}
			else {
				echo "La date n'est pas valide";
				return false;
				
			}
		}
		else if ((!empty($_POST['d1'])) || (!empty($_POST['d2'])) || (!empty($_POST['d3']))) {
			echo "La date n'est pas valide";
			return false;
		}

		return true;
	}

	if (!empty($_POST)) {
		$g=0;
		
		if($_SERVER["HTTP_REFERER"] !== $serveur."Inscription_Desinscription/NouveauMembre3.php") {
			echo "	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
		}
		
		else if(empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["id"]) || empty($_POST["mail"]) || empty($_POST["adresse"]) || empty($_POST["pays"])) {	
			echo "<p>Veuillez compléter tous les champs munis d'une étoile (*).</p>";
		}
		
		else if((!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"])) || (!preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["nom"])) || (!preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["prenom"]))  || (!preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["adresse"]))  || (!preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["pays"]))) {	
			echo "<h1>Erreur</h1><h4>L'un des champs entrés contiens des caractères spéciaux ou accentués.</h4>";

		}
		
		else if (!(is_numeric($_POST["adresse"]))){
			echo "<h4>Erreur : le code postal doit être composé de 5 chiffres.</h4>";
		}
		
		else if (!verifiedate ()) {
			echo "";
		}
		
		else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){  
			echo "L'adresse e-mail est incorrecte.";
		}
		
		else {
			//connection à mysql
			
			$motdepassealeat = genere_aleat(3);

			

			include '../Base_de_donnees/ConnectionBaseDonnees.php';
			
			$connexion = mysqli_connect($server, $user, $motdepasse, $base);
			if (!$connexion) {
				echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {
					if ((!empty($_POST['d1'])) && (!empty($_POST['d2'])) && (!empty($_POST['d3']))) {
						$d1=$_POST['d1'];
						$d2=$_POST['d2'];
						$d3=$_POST['d3'];
						$d0=0;
						if ($d1<10 && $d2<10){
							$date=$d0.$d1.$d0.$d2.$d3;
						}
						if ($d1<10 && $d2>9){
							$date=$d0.$d1.$d2.$d3;
						}
						if ($d1>9 && $d2<10){
							$date=$d1.$d0.$d2.$d3;
						}
						if ($d1>9 && $d2>9){
							$date=$d1.$d2.$d3;
						}
					}
					
					else $date=-11;//équivalent à une date non renseignée.
					//echo $date;
					
					$datedinscription = date("dmY");
					//echo $datedinscription;

					$requete= 'SELECT id FROM asso WHERE id="'.$_POST['id'].'"';
					$resultat = mysqli_query($connexion, $requete);
					$ligne = mysqli_fetch_array($resultat);
					
					if ($ligne!=false) {
						echo "<p>Trouvez un autre nom d'utilisateur (identifiant).</p>\n<p>Celui-ci est déjà utilisé.</p>";
					}
					
					else {
						$g=1;
						
						$datenaissance = $_POST['d2'].$_POST['d1'].$_POST['d3'];
						$sql = 'INSERT INTO asso (competence, Nom, Prenom,CodePostal,Pays,DateNaissance,mail,id,motdepasse,datedinscription,datedederniereconnection,datedudernierpost) VALUES ("Membre","'.$_POST["nom"].'","'.$_POST["prenom"].'","'.$_POST["adresse"].'","'.$_POST["pays"].'","'.$date.'","'.$_POST["mail"].'","'.$_POST["id"].'","'.md5($motdepassealeat).'","'.$datedinscription.'","-11","-11")';
						
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						
						echo "<p>Tout est correct.</p>";	
						echo "<p>Voici votre mot de passe : ".$motdepassealeat.".<br><br>Il servira à confirmer votre inscription.<br><br>Veuillez entrer ce mot de passe lors de vos prochaînes connections.<br><br>Cepandant, vous pourrez changer ce mot de passe dès votre première connection.</p>\n".'<p><br><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">'."Revenir à la page d'accueil</a></p>";
					}
				}
			}
			
			//fin de la requête mysql
		}
	}
	
	if (empty($_POST) || ($g==0)) {	
		
		if (empty($_POST)) echo "<h2>Inscription nouveau membre : </h2>\n";
		
	echo '<p>Veuillez compléter le formulaire ci-dessous et remplir tous les champs obligatoires (*) : </p>
	    	<form action="'.$serveur.'Inscription_Desinscription/NouveauMembre3.php" method="POST">
	    	  Nom : <input type="text" name="nom">(*)<br>
	    	  Prénom : <input type="text" name="prenom">(*)<br>
	    	  e-mail : <input type="adress" name="mail">(*)<br>
	    	  Pays : <input type="text" name="pays"> 
	    	  Adresse (Code postal) : <input type="text" name="adresse">(*)<br>
	    	  Date de naissance : <input type="text" name="d1" size="2">/<input type="text" name="d2" size="2">/<input type="text" name="d3" size="4"> (JJ/MM/AAAA) <br>
	    	  Identifiant : <input type="text" name="id">(*)<br>      
	    	  <input type="submit">
	    	</form>
		
		    <p><a href="'.$serveur.'Accueil/Accueil%20%281%29.php">Retour à la page d'."'".'accueil</a></p>';
		
    }
		
?>

  </body>
</html>
