<?php
		global $serveur;
		if (!isset($serveur)) $serveur = "http://localhost/association/";
		echo '    <link rel="stylesheet" href="'.$serveur.'Ressources/CSS/style.css">';
		echo "\n";

		if (!empty($_SESSION['style']) && $_SESSION['style']==2) {
			echo '    <script>document.addEventListener("DOMContentLoaded", function() { document.body.classList.add("theme2"); });</script>';
			echo "\n";
		}
?>