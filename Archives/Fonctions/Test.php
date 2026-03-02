<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Test</title>
  </head>
  <body>
<?php
	include 'CalcAnciennete4.php';

	$s="14032013";

	echo "\nCalcAnciennete (".'"'.$s.'"'.") : ".CalcAnciennete($s).".";

	echo '<br>'.htmlspecialchars('"');
?>

  </body>
</html>
