<?php
	function includeStylesheet2() {
		global $serveur;
		if (!isset($serveur)) $serveur = "http://localhost/association/";
		$style = '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style.css">'."\n";

		if (!empty($_SESSION['style']) && $_SESSION['style']==2) {
			$style .= '    <script>document.addEventListener("DOMContentLoaded", function() { document.body.classList.add("theme2"); });</script>'."\n";
		}

		return $style;
	}
?>