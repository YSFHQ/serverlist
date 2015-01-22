<?php 
$array="";
$a=0;
$dir=opendir('memberlist/');
 while ($read_file = readdir($dir)) {
		if (($read_file!=".")&&($read_file!=".."))
			{   
			         
			$fo=fopen("memberlist/$read_file", "r");
            $file=file("memberlist/$read_file");
			
			$array[] =array('pseudo' => strtolower(rtrim(ltrim($file[0]))), 'rank' =>rtrim(ltrim($file[1])), 'id' =>rtrim(ltrim($file[2])),'pts' => rtrim(ltrim($file[3])), 'birth' => rtrim(ltrim($file[4])), 'pic' => rtrim(ltrim($file[5])),'coord' => rtrim(ltrim($file[6])), 'mail' => rtrim(ltrim($file[7])), 'country' => rtrim(ltrim($file[8])), 'town' => rtrim(ltrim($file[9])), 'officier' =>rtrim(ltrim($file[10])), 'file' => rtrim(ltrim($read_file)), 'year'=>substr($file[4],4));
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
  // $pts[$key] = $row['pts'];
   $birth[$key] = $row['birth'];

   $pic[$key] = $row['pic'];
  // $coord[$key] = $row['coord'];
   $mail[$key] = $row['mail'];
   $country[$key] = $row['country'];
   $town[$key] = $row['town'];
  // $officier[$key]= $row['officier'];
   $day[$key]= substr($row['birth'],0,2);
   if ($row['birth']!='0'){
	   $month[$key]= substr($row['birth'],2,2);
	}
	else {$month[$key]='99';}
	if ($row['birth']!='0'){
	   $year[$key]= $row['year'];}
	   else{$year[$key]='1989';}
   $pseudo2[$key]  = $row['pseudo'];
   $file[$key]  = $row['file'];
}
?>