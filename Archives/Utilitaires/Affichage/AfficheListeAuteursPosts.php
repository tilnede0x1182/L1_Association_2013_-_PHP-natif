

			$requete1 = 'SELECT Post, date, idpost, id FROM posts ORDER BY date DESC';
			$resultat1 = mysqli_query($connexion, $requete1);

			echo '    <table border="1">
			      <tr>
			        <th>Auteur</th>
			        <th>Derniers posts</th>
			        <th>Dates de modification</th>
			      </tr>';

			$tmp1=0;

			while (true) {
				$tmp1=$tmp1+1;
				$ligne = mysqli_fetch_array($resultat1);

				if (($ligne==false) || ($tmp1>5)) break;

				//echo '$ligne['."'".'idpost'."'".'] = '.$ligne['idpost']."<br>\n";

				$idpost=$ligne['idpost'];

				$requete2 = 'SELECT idmembre, date FROM dataposts WHERE idpost="'.$idpost.'" ORDER BY date DESC';
				$resultat2 = mysqli_query($connexion, $requete2);

				$rdataposts=0;

				$date="";
				$membre="";
				$tmp2=0;

				while ($rdataposts!=1){
					$tmp2=$tmp2+1;
					$dataposts = mysqli_fetch_array($resultat2);

					if ($dataposts==false) $rdataposts=1;

					$date[]=$dataposts['date'];
					$membre[]=$dataposts['idmembre'];
				}

				if (empty($date)) $date[0]="";
				if (empty($membre)) $membre[0]="";

				echo "\n<tr>";
	
				echo "<td>".'<a href="http://localhost/Projet1/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a> (".convertDate($ligne['date']).") \n";
				for ($i=0; ($i<$tmp2-1) && ($i<0); $i=$i+1) {
					echo "<br>".'<a href="http://localhost/Projet1/InformationMembre.php?idmembre='.$membre[$i].'">'.$membre[$i]."</a> (".convertDate($date[$i]).") \n";
				}
				echo '<br><br><a href="">Voir la liste</a>&nbsp;&nbsp;</td>'."\n";					
				echo "<td>".detectlId ($ligne['Post'])."</td>\n";
				echo "<td>Dernière modification : <br>\n".'<a href="http://localhost/Projet1/InformationMembre.php?idmembre='.$membre[$i].'">'.$membre[$i]."</a>(".convertDate($date[$tmp2-2]).")<br>\nPublication : \n<br>".'<a href="http://localhost/Projet1/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a> (".convertDate($ligne['date']).") \n";
				echo "      </tr>\n";
			}

			echo '    </table>';
			
		}
	}