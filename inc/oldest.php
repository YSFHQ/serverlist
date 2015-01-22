<?php 
include("inc/memberlist.php");
		array_multisort($year, SORT_ASC, $month, SORT_ASC, $day, SORT_ASC,$array);
		
		for($n=0; $array[$n]["year"]=0;$n++){
			
}
		echo $array[$n+1]["pseudo"]."(".$array[$n+1]["year"].")<br>";
		?>
