<?php
	$blabla="blabla";

	for ($i=0; $i<5; $i=$i+1){
		$un[]=$blabla;
	}

	foreach ($un as $a => $b){
		echo '['.$a.'] = '.$b.'<br>'."\n";
	}

?>