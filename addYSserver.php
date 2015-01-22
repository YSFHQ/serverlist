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

<form name="form" method="post" action="addYSserver2.php">
	<?php include("inc/func.php"); ?>
  <table cellpadding="3" cellspacing="3">
    <tr> 
      <td width="144"><input name="name" type="text" id="name" value="<?php if (isset($_COOKIE["name"])) {echo $_COOKIE["name"];} ?>" maxlength="30"></td>
      <td width="449"><strong><font size="2">&lt;&lt; Server name <em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mandatory 
        field.</em></font></strong></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td> 
        <input name="owner" type="text" id="name" value="<?php if (isset($_COOKIE["owner"])) {echo $_COOKIE["owner"];} ?>" maxlength="30"></td>
      <td> <strong><font size="2">&lt;&lt; Owner</font></strong></td>
    </tr>
    <tr> 
      <td><input name="website" type="text" id="website" value="<?php if (isset($_COOKIE["website"])) {echo $_COOKIE["website"];} ?>" maxlength="70"></td>
      <td><font size="2"><strong>&lt;&lt; Website </strong></font></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td> 
        <input name="ip" type="text" id="ip" value="<?php echo $_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"]; ?>" maxlength="30"></td>
      <td><strong><font size="2"><< IP<font color="#FF0000">*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font> 
        <em>Mandatory field.</em></font></strong></td>
    </tr>
    <tr> 
      <td><input name="port" type="text" id="port" value="<?php if (isset($_COOKIE["port"])) {echo $_COOKIE["port"];} else {echo "7915"; } ?>" maxlength="6"></td>
      <td><font size="2"><strong>&lt;&lt; Port <em>&nbsp;&nbsp;&nbsp;&nbsp;Mandatory 
        field.</em></strong></font></td>
    </tr>
    
    <tr bgcolor="#EEEEEE"> 
      <td><input name="TS_ip" type="text" id="TS_ip" value="<?php echo $_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"]; ?>" maxlength="30"></td>
      <td><strong><font size="2"><< TS (service disabled)** IP</font></strong></td>
    </tr>
    <tr> 
      <td> 
        <input name="TS_port" type="text" id="TS_port" value="<?php if (isset($_COOKIE["TS_port"])) {echo $_COOKIE["TS_port"];} else {echo "0"; } ?>" maxlength="8"></td>
      <td><font size="2"><strong>&lt;&lt; TS (service disabled)*** Port</strong></font></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td><font size="2"> 
        <select name="country"  onChange=showcountry() onkeydown=showcountry()>
          <?php $dir=opendir('im/flags');
          while ($read_file = readdir($dir)) {
			if (($read_file!=".")&&($read_file!="..")){
                  echo"<option value=\"$read_file\""; if (get_lang().".gif"==$read_file) {echo "SELECTED";} echo" >".substr($read_file,0,-4)."</option>", "\n";
                  }
		}
        closedir($dir);
        ?>
        </select>
        <img src=" <?php echo "im/flags/".get_lang().".gif"; ?>" name="newcountry"> 
        </font></td>
      <td><font size="2"><strong>&lt;&lt; Country </strong>(given by your browser)</font></td>
    </tr>
    <tr> 
      <td height="21"><font size="2"><?php echo get_OS($_SERVER['HTTP_USER_AGENT']) ?>&nbsp;</font></td>
      <td><font size="2"><strong>&lt;&lt; OS</strong> (given by your browser)</font></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td height="21"><input name="lat" type="text" id="lat" value="<?php if (isset($_COOKIE["lat"])) {echo $_COOKIE["lat"];} ?>" maxlength="10"></td>
      <td><font size="2"><strong>&lt;&lt; <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Latitude</a></strong> 
        (of the closest city, not of your home!)</font></td>
    </tr>
    <tr> 
      <td height="21"> 
        <input name="long" type="text" id="long" value="<?php if (isset($_COOKIE["long"])) {echo $_COOKIE["long"];} ?>" maxlength="10"></td>
      <td><font size="2"><strong>&lt;&lt; <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">Longitude</a> 
        </strong>(of the closest city, not of your home!)<strong> </strong></font></td>
    </tr>
    <tr> 
      <td height="21"></td>
      <td><font size="2">&nbsp;</font></td>
    </tr>
  </table>
  <strong><font size="2"> </font></strong> 
  <p> 
    <input type="submit" name="Submit" value="Add the server">
    <br>
    <font size="2"><br>
    <font color="#FF0000">* It should <strong>NOT</strong> start with <strong>192.x.x.x</strong> 
    or <strong>169.x.x.x</strong> (local network ip) else, have a look to <a href="http://www.yougetsignal.com/tools/network-location/" target="_blank">this 
    page</a>.</font><br>
    <font color="#FF0000">** A static IP is an IP address which does no change 
    after a disconnection. In Europe, most of the IP are dynamic.</font><br>
    <br>
    ** TS=Team Speak, let blank if you don't have one.<br>
    *** Let &quot;0&quot; if you don't have one</font> <br>
    <font size="2"><br>
    <strong>I recommend you to use a <a href="http://www.dyndn.org">DNS</a> or 
    any <a href="http://www.no-ip.com/">no ip address</a> if you don't have a 
    static ip address, else you won't be able to edit your server from the serverlist. 
    </strong></font> </p>
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
