<?php
if ((!isset($_SESSION['241st_pseudo']))&&(!isset($_SESSION['241st_password'])) ) {       
    	  session_unset();
    	  //session_destroy();
		  die("You cannot access this page <Script language=\"JavaScript\"> setTimeout(\"document.location = 'index.php' \", 2500) </script> ");
}
else {
$pseudo=$_SESSION['241st_pseudo'];
$pass  =$_SESSION['241st_password'];
} 
?>