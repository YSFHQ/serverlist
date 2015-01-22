<html>
<head>
<title>Log reader</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<u>Older logs:</u><br>
<?php
$dir       = opendir('journal/');
while ($read_file = readdir($dir)) 
{
	if (($read_file!=".")&&($read_file!=".."))
	{
		echo "<a href='logRead.php?page=".$read_file."'>".substr($read_file,0,-5)."</a> &nbsp;&nbsp;";
	}
}
?>
<p>&nbsp;</p>
<?php 
if (!isset($_GET["page"]))
{
	if (file_exists("journal/".date("Y")."_".date("m").".html"))
		include("journal/".date("Y")."_".date("m").".html"); 
	else
		echo "The log is empty.";
}
else
	include("journal/".$_GET["page"]); 	
?>
</body>
</html>
