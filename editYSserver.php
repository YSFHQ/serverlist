<html>
<body>
<a href="index.php">&lt;&lt;-- Back to the server list</a>
<br>
<script language=javascript>
 <!-- 
function showcountry()
{		
        document.images.newcountry.src= 'im/flags/'+
        document.form.country.options[document.form.country.selectedIndex].value
}
		

// --> 
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

<form name="form" method="post" action="editYSserver2.php">
<?php 
include("inc/func.php"); 
include("inc/serversf.php");

$sf        = new Serversf();
$sf->read($_GET["ip"],$_GET["port"]);
?>
<input name="ip" type="hidden" id="ip" value="<?php echo $_GET["ip"] ?>">
<input name="port" type="hidden" id="port" value="<?php echo $_GET["port"]  ?>">
<b><font color='#FF0000'>If you wish to modify your IP or the port, <a href="http://forum.ysfhq.com/ucp.php?i=pm&mode=compose&u=88" target="_blank">contact me by PM.</a></font></b><br><br>

  <table>
    <tr> 
      <td width="144"><input name="name" type="text" id="name" value="<?php echo $sf->serverName ?>" maxlength="30"></td>
      <td width="495"><strong><font size="2">&lt;&lt; Server name <em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mandatory 
        field.</em></font></strong></td>
    </tr>
    <tr> 
      <td><input name="owner" type="text" id="name" value="<?php echo $sf->owner ?>" maxlength="30"></td>
      <td> <strong><font size="2">&lt;&lt; Owner</font></strong></td>
    </tr>
    <tr> 
      <td height="26">
<input name="website" type="text" id="website" value="<?php echo $sf->website ?>" maxlength="70"></td>
      <td><font size="2"><strong>&lt;&lt; Website <font color="#FF0000">(dont' 
        forget &quot;http://&quot;!)</font></strong></font></td>
    </tr>
    <tr> 
      <td><input name="TS_ip" type="text" id="TS_ip" value="<?php echo $sf->TS_ip ?>" maxlength="30"></td>
      <td><strong><font size="2"><< TS (service disabled)** IP</font></strong></td>
    </tr>
    <tr> 
      <td><input name="TS_port" type="text" id="TS_port" value="<?php echo $sf->TS_port ?>" maxlength="8"></td>
      <td><font size="2"><strong>&lt;&lt; TS (service disabled)*** Port</strong></font></td>
    </tr>
    <tr> 
      <td><font size="2">
        <select name="country"  onChange=showcountry() onkeydown=showcountry()>
          <?php $dir=opendir('im/flags');
          while ($read_file = readdir($dir)) {
			if (($read_file!=".")&&($read_file!="..")){
                  echo"<option value=\"$read_file\""; if (strtolower($sf->country).".gif"==$read_file) {echo "SELECTED";} echo" >".substr($read_file,0,-4)."</option>", "\n";
                  }
		}
        closedir($dir);
        ?>
        </select>
        <img src=" <?php echo "im/flags/".strtolower($sf->country).".gif"; ?>" name="newcountry"> 
        </font></td>
      <td><font size="2"><strong>&lt;&lt; Country </strong>(given by your browser)</font></td>
    </tr>
    <tr> 
      <td height="21"><font size="2"><?php echo get_OS($_SERVER['HTTP_USER_AGENT']) ?>&nbsp;</font></td>
      <td><font size="2"><strong>&lt;&lt; OS</strong> (given by your browser)</font></td>
    </tr>
    <tr>
      <td height="21"><input name="lat" type="text" id="lat" value="<?php echo $sf->lat ?>" maxlength="10"></td>
      <td><font size="2"><strong>&lt;&lt; <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Latitude</a></strong> 
        (of the closest city, not of your home!) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Please, 
        do not delete it.</strong></font></td>
    </tr>
    <tr> 
      <td height="21"><input name="long" type="text" id="long" value="<?php echo $sf->long ?>" maxlength="10"></td>
      <td><font size="2"><strong>&lt;&lt; <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Longitude</a> 
        </strong>(of the closest city, not of your home!)<strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please, 
        do not delete it.</strong></font></td>
    </tr>
    <tr> 
      <td height="21"><font size="2">.</font></td>
      <td><font size="2">&nbsp;</font></td>
    </tr>
  </table>
  <strong><font size="2"> </font></strong> 
  <p> 
    <input type="submit" name="Submit" value="Edit the server">
    <br>
    <font size="2"><br>
    <font color="#FF0000">* It should <strong>NOT</strong> start with <strong>192.x.x.x</strong> 
    or <strong>169.x.x.x</strong> (local network ip) else, have a look to <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">this 
    page</a>.</font><br>
    ** TS=Team Speak, let blank if you don't have one.<br>
    *** Let &quot;0&quot; if you don't have one</font> <br>
    <font size="2"><br>
    I recommend you to use a <a href="http://www.dyndn.org">DNS</a> or any <a href="http://www.no-ip.com/">no 
    ip address</a> if you don't have a static ip address, else you won't be able 
    to edit your server from the serverlist. </font> </p>
</form>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-8462049-1");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>
