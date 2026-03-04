<?php
	function convertDate ($dd1){
		if ($dd1!=0) {
			$jour=substr($dd1,0,2);
			$mois=substr($dd1,2,2);
			$annee=substr($dd1,4,4);
		
			$d="".$jour.'/'.$mois.'/'.$annee;
				
			return $d;
		}

		else return "Date non renseignée";	
	}
?>