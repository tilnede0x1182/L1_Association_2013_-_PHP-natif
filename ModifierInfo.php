<?php session_start();
include 'Fonctions/includeStylesheet2.php';
if (empty($_SESSION['id'])) $_SESSION['id']=80;
if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr" >
<head>
	<title>Modifier mes informations</title>
	<meta charset="utf-8" />
<?php
	echo includeStylesheet2();
?>
</head>
<body>
<?php
include 'MenuAccueil.php';
include 'Fonctions/AdresseServeur.php';

function verifiedate (){
	if ((!empty($_POST['d1'])) && (!empty($_POST['d2'])) && (!empty($_POST['d3']))) {
		$d1=$_POST['d1'];
		$d2=$_POST['d2'];
		$d3=$_POST['d3'];
		$date=$d1.$d2.$d3;

		$dateInvalide = '<h4 class="texte">La date n'."'".'est pas valide</h4>';

		if ((is_numeric($d1)) && (is_numeric($d2)) && (is_numeric($d3))){
			if ($d1>31 || $d1<0 || $d2<0 || $d2>12)	{
				echo $dateInvalide;
				return false;
			}

			if ($d2==4 || $d2==6 || $d2==9 || $d2==11){
				if ($d1>30) {
					echo $dateInvalide;
					return false;
				}
			}

			if ($d2==2) {
				if ($d1>29) {
					echo $dateInvalide;
					return false;
				}
			}
		}
		else {
			echo $dateInvalide;
			return false;
			
		}
	}
	else if ((!empty($_POST['d1'])) 
			|| (!empty($_POST['d2'])) 
			|| (!empty($_POST['d3']))) {
		echo $dateInvalide;
		return false;
	}

	return true;
}

if (verifieConnection()) {
	$g=0;
	if (isset($_GET['info'])) $infomembre = $_GET['info'];
	else $infomembre=" ";

	//$_SESSION['pageCourante']=$serveur."ModifierInfo.php?info=".$infomembre;

	//echo '$infomembre'." = ".$infomembre."<br>\n";

	//if (isset($_POST[$infomembre])) echo "true";
	//else echo "false";

	if ($infomembre=="motdepasse") $linfo="votre nouveau mot de passe";
	if ($infomembre=="mail") $linfo="votre nouvelle adresse e-mail";
	if ($infomembre=="id") $linfo="votre nouvel identifiant";
	if ($infomembre=="Nom") $linfo="votre nom";
	if ($infomembre=="Prenom") $linfo="votre prénom";
	if ($infomembre=="CodePostal") $linfo="votre adresse (code postal)";
	if ($infomembre=="DateNaissance") $linfo="votre date de naisseance";
	if ($infomembre=="Pays") $linfo = "le pays où vous habitez";

	echo '<h2 class="texte">Modifier '.$linfo.' : </h2>'."\n";

	$type="text";

	if ($infomembre=="motdepasse") $type="password";

	if (($infomembre!="motdepasse") 
			&& ($infomembre!="mail") 
			&& ($infomembre!="id") 
			&& ($infomembre!="Nom") 
			&& ($infomembre!="Prenom") 
			&& ($infomembre!="CodePostal") 
			&& ($infomembre!="DateNaissance") 
			&& ($infomembre!="Pays")) {
		echo "\n<h3>Erreur.</a></h3>\n<h4>Veuiller quitter cette page</h4>\n"
		.'<p><a href=$serveur."ModifierInformationMembre.php">'
		.'Retour à la page de modification des informations</a></p>'
		."\n".'<p><a href=$serveur."Accueil%20%281%29.php">Aller à la page d'
		."'".'acceuil</a></p>'."\n";
		exit();
	}

	if (!empty($_POST)){
		$g=0;

		include 'Fonctions/ConnectionBaseDonnees.php';

		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}
			else {
				if($_SERVER["HTTP_REFERER"] !== $serveur
						."ModifierInfo.php?info=".$infomembre) {
					echo "	<h1>Attention</h1>
						<h4>Le formulaire est soumis depuis une "
					."source externe !</h4>";
					$g=0;
				}
				else
				$g=1;
				if ($infomembre=="motdepasse") {
					$requete2 = 'SELECT motdepasse FROM asso WHERE id="'
					.$_SESSION['id'].'"';
					$resultat2 = mysqli_query($connexion, $requete2);
					$ligne2 = mysqli_fetch_array($resultat2);

					if ($ligne2==false) {
						echo "<h4>Mot de passe incorrect.</h4>"; $g=0;
					}
					else if ($ligne2['motdepasse']!=$_SESSION['motdepasse']) {
						echo "<h4>Mot de passe incorrect.</h4>"; $g=0;
					}
					else if((empty($_POST["motdepasseactuel"])) 
							|| (empty($_POST["motdepasse1"])) 
							|| (empty($_POST["motdepasse"]))) $g=0;
					else if ($_POST["motdepasse1"]!=$_POST["motdepasse"]) 
					$g=0;
					else if((!empty($_POST["motdepasseactuel"])) 
					&& (!empty($_POST["motdepasse1"])) 
					&& (!empty($_POST["motdepasse"]))) {
						if ((!preg_match('/^[a-zA-Z0-9-_]+$/', 
						$_POST["motdepasseactuel"])) 
						|| (!preg_match('/^[a-zA-Z0-9-_]+$/', 
						$_POST["motdepasse1"])) 
						|| (!preg_match('/^[a-zA-Z0-9-_]+$/', 
						$_POST["motdepasse"]))) {	
							echo "<h1>Erreur</h1><h4>L'un "
							."des champs entrés contiens des ".
							"caractères spéciaux ou "
							."accentués.</h4>";
							$g=0;
						}
					}
					else $g=1;
				}
				else{ 
					if(empty($_POST[$infomembre])) {
						$g=0;
					}			
					else if ($infomembre!="mail") {
						if (!preg_match('/^[a-zA-Z0-9-_]+$/', 
						$_POST[$infomembre])) {
							echo "<h1>Erreur</h1><h4>L'un des "
							."champs entrés "
							."contiens des caractères spéciaux "
							."ou accentués.</h4>";
							$g=0;
						}
					}
					else $g=1;
				}
				
				if ($infomembre=="CodePostal") {
					if (!(is_numeric($_POST["CodePostal"]))){
						echo "<h4>Erreur : le code postal doit "
						."être composé de 5 chiffres.</h4>";
						$g=0;
					}else $g=1;
				}

				if ($infomembre=="DateNaissance") { 
					if (!verifiedate ()) {
						
						$g=0;
					}else $g=1;
				}

				if ($infomembre=="mail") {
					if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){  
						echo "L'adresse e-mail est incorrecte.";
						$g=0;
					}else $g=1;
				}

				if ($g==1){
					if ($infomembre=="motdepasse"){
						$sql = 'UPDATE asso SET motdepasse="'
						.md5($_POST["motdepasse1"])
						.'" WHERE id="'.$_SESSION['id']
						.'" AND motdepasse="'
						.$_SESSION['motdepasse'].'"';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

						header('Location: '.$serveur
						.'Accueil%20%281%29.php');

						echo '<p>Votre '.$linfo.' a bien été '
						.'enregistré.</p>'."\n";
						echo '<p>Revenir à <a href=$serveur
						."Accueil%20%281%29.php">'
						.'la page d'."'".'acceuil</a></p>'."\n";
					}
					else if ($infomembre=="DateNaissance") {
						$d1=$_POST['d1'];
						$d2=$_POST['d2'];
						$d3=$_POST['d3'];
						$date=$d1.$d2.$d3;

						if ($date=="") $date = "-11";

						$sql = 'UPDATE asso SET DateNaissance="'
						.$date.'" WHERE id="'
						.$_SESSION['id'].'" AND motdepasse="'
						.$_SESSION['motdepasse'].'"';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

						if (!empty($_SESSION['pageCourante']))
							header('Location: '
							.$_SESSION['pageCourante']);
						else header('Location: '.$serveur
							.'ModifierInformationMembre.php');

						echo '<p>Votre '.$linfo
						.' a bien été enregistré.</p>'."\n";
						echo '<p>Vous pouver retourner à la '
						.'page de <a href=$serveur
						."ModifierInformationMembre.php">modification</a> '
						.'de vos informations ou revenir à '
						.'<a href=$serveur
						."Accueil%20%281%29.php">la page d'."'"
						.'acceuil</a></p>'."\n";
					}
					else if ($infomembre=="id") {
						$requete1 = 'SELECT id FROM asso WHERE id="'
						.$_POST['id'].'"';
						$resultat1 = mysqli_query($connexion, $requete1);
						$ligne1 = mysqli_fetch_array($resultat1);

						if ($ligne1!=false) {
							echo '	 <h4 class="texte">'
							.'Cet identifiant est déjà pris.<br>'
							.' Veuillez en trouver un autre.</h4>'
							."\n";
							$g=0;
						}else {
							$sql = 'UPDATE asso SET id="'.$_POST["id"]
							.'" WHERE id="'.$_SESSION['id']
							.'" AND motdepasse="'
							.$_SESSION['motdepasse'].'"';
							mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
							
							$sql = 'UPDATE posts SET id="'.$_POST["id"]
							.'" WHERE id="'.$_SESSION['id'].'"';
							mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
							
							$sql = 'UPDATE projets SET id="'
							.$_POST["id"]
							.'" WHERE id="'.$_SESSION['id'].'"';
							mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));
							
							$sql = 'UPDATE dataposts SET idmembre="'
							.$_POST["id"].'" WHERE idmembre="'
							.$_SESSION['id'].'"';
							mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));																

							$sql = 'UPDATE dataprojets SET idmembre="'
							.$_POST["id"].'" WHERE idmembre="'
							.$_SESSION['id'].'"';
							mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));

							$sql = 'UPDATE dataposts SET idauteur="'
							.$_POST["id"].'" WHERE idauteur="'
							.$_SESSION['id'].'"';
							mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));																
							
							$sql = 'UPDATE dataprojets SET idauteur="'
							.$_POST["id"].'" WHERE idauteur="'
							.$_SESSION['id'].'"';
							mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));

							header('Location: '.$serveur
							.'Accueil%20%281%29.php');

							echo '<p>Votre '.$linfo.' a bien été '
							.'enregistré.</p>'."\n";
							echo '<p>Retenir à <a href=$serveur
							."Accueil%20%281%29.php">la page d'."'"
							.'acceuil</a>.</p>'."\n";
						}
					}
					else {
						$sql = 'UPDATE asso SET '.$infomembre.'="'
						.$_POST["$infomembre"]
						.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'
						.$_SESSION['motdepasse'].'"';
						mysqli_query(\$connexion, \$sql) or die('Erreur SQL !'.\$sql.'<br />'.mysqli_error(\$connexion));

						if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
						else header('Location: '.$serveur
						.'ModifierInformationMembre.php');

						echo '<p>Votre '.$linfo
						.' a bien été enregistré.</p>'."\n";

						echo '<p>Vous pouver retourner à la page de <a href=$serveur
								."ModifierInformationMembre.php">modification</a> de vos informations '
						.'ou revenir à <a href=$serveur
						."Accueil%20%281%29.php">la page d'
						."'".'acceuil</a></p>'."\n";
					}
				}
			}	
		}
	}
	

	if (empty($_POST) || ($g==0)) {

		if (!empty($_GET['info'])) $infomembre = $_GET['info'];
		else $infomembre = "";

		if ($infomembre!="motdepasse") {
			include 'Fonctions/ConnectionBaseDonnees.php';

			$connexion = mysqli_connect(\$server, \$user, \$motdepasse, \$base);
			if (!$connexion) {
				echo "Pas de connexion au serveur" ;
			}
			else {
				if (!\$connexion) {
					echo "Pas d'accès à la base" ;
				}
				else {
					//echo $infomembre;

					//echo 'SELECT '.$infomembre.' FROM asso WHERE id="'
					//.$_SESSION['id'].'"';

					$requete3 = 'SELECT '.$infomembre.' FROM asso WHERE '
					.'id="'.$_SESSION['id'].'"';
					$resultat3 = mysqli_query($connexion, $requete3);
					$ligne3 = mysqli_fetch_array($resultat3);

					if ($ligne3!=false) $valeur = $ligne3[$infomembre];
					else $valeur = "";

					if ($infomembre=="DateNaissance")
						if ($valeur!=-11) $date = $valeur;
					else $date = "";
					else $date = "";

				}
			}
		}
		else $valeur="";

		$autofocus1="";
		$autofocus2="";

		if ($infomembre=="motdepasse") $autofocus1=" autofocus";
		else $autofocus2=" autofocus";

		echo '	<form class="texte" action="'.$serveur.'ModifierInfo.php?info='
		.$infomembre.'" method="POST">';
		if ($infomembre=="motdepasse") echo '	  <label>Entrez votre mot '
		.'de passe actuel : <input type="password" name="motdepasseactuel"'
		.$autofocus1.'></label><br><br>'."\n";
		if ($infomembre!="DateNaissance") echo '	<label>Entrez '.$linfo
		.' : <input type="'.$type.'" name="'.$infomembre.'" value="'.$valeur
		.'"'.$autofocus2.'></label><br>'."\n";
		else echo 'Entrez votre date de naissance : <input type="text" '
		.'name="d1" size="2" value="'.substr($date,0,2).'" autocomplete="on" '
		.'autofocus>/<input type="text" name="d2" size="2" value="'.substr($date,2,2)
		.'" autocomplete="on">/<input type="text" name="d3" size="4" value="'
		.substr($date,4,4).'" autocomplete="on"> (JJ/MM/AAAA) <br>'."\n";
		if ($infomembre=="motdepasse") echo '	  <label>Confirmer votre '
		.'mot de passe : <input type="password" name="'.$infomembre.'1"></label><br>'."\n";
		echo '	  <input type="submit" value="modifier">';
		echo '	</form>';

		if (!empty($_SESSION['pageCourante'])) echo '	 '
		.'<p class="texte"><a href="'.$_SESSION['pageCourante']
		.'">Annuler</a></p>';
		else echo '	 <p class="texte"><a href="'.$serveur
		.'ModifierInformationMembre.php">Retour à la page de '
		.'modifiaction de vos informations.</a></p>';
	}
}


?>

</body>
</html>