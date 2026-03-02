<?php
	function convertDate ($dd1){
		if ($dd1!=0) {
			$d1=substr($dd1,0,2);
			$d2=substr($dd1,2,2);
			$d3=substr($dd1,4,4);
		
			$d="".$d1.'/'.$d2.'/'.$d3;
				
			return $d;
		}

		else return "Date non renseignée";	
	}
?>