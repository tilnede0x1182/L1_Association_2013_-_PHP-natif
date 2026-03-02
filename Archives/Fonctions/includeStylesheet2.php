<?php
	function includeStylesheet2() {
		global $serveur;
		if (!isset($serveur)) $serveur = "http://localhost/association/";
		if (!empty($_SESSION['style'])) {
			if ($_SESSION['style']==1) $style = '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style1.css">';
			if ($_SESSION['style']==2) $style = '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style2.css">';
		}
		else $style = '    <link rel="stylesheet" href="'.$serveur.'Styles/style1.css">';

		return $style."\n";
	}
?>