<?php
		global $serveur;
		if (!isset($serveur)) $serveur = "http://localhost/association/";
		if (!empty($_SESSION['style'])) {
			if ($_SESSION['style']==1) echo '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style1.css">';
			if ($_SESSION['style']==2) echo '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style2.css">';
		}
		else echo '    <link rel="stylesheet" href="'.$serveur.'Styles/style1.css">';

		echo "\n";
?>