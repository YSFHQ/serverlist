<?php 
$array="";
$a=0;
$dir=opendir('memberlist/');
 while ($read_file = readdir($dir)) {
		if (($read_file!=".")&&($read_file!=".."))
			{   
			         
			$fo=fopen("memberlist/$read_file", "r");
            $file=file("memberlist/$read_file");
			
			$array[] =array('pseudo' => $file[0], 'rank' =>$file[1], 'id' =>$file[2],'pts' => $file[3], 'birth' => $file[4], 'pic' => $file[5],'coord' => $file[6], 'mail' => $file[7], 'country' => $file[8], 'town' => $file[9], 'officier' =>$file[10], 'file' => $read_file, 'year'=>substr($file[4],4));
			fclose($fo);
			$a ++ ;
             }
			
		}
closedir($dir);

// Obtient une liste de colonnes
foreach ($array as $key => $row) {
   $pseudo[$key]  = $row['pseudo'];
   $rank[$key] = $row['rank'];
   $id[$key] = $row['id'];
   $pts[$key] = $row['pts'];
   $birth[$key] = $row['birth'];
   $pic[$key] = $row['pic'];
   $coord[$key] = $row['coord'];
   $mail[$key] = $row['mail'];
   $country[$key] = $row['country'];
   $town[$key] = $row['town'];
   $officier[$key]= $row['officier'];
   $day[$key]= substr($row['birth'],0,2);
   $month[$key]= substr($row['birth'],2,2);
   $year[$key]= $row['year'];
   $pseudo2[$key]  = $row['pseudo'];
   $file[$key]  = $row['file'];
}
?>