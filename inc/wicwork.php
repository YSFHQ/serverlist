
<?php
$fo=fopen("wicpack/name.txt", "r");
$file=fread($fo, filesize('wicpack/name.txt'));
fclose($fo);
$path = "http://www.yspilots.com/shadowhunters/wicpack/";
$file= $path.$file;

?>
  <strong>
      </strong>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td style="border-top: 1px solid rgb(149,147,164); border-bottom: 1px solid rgb(149,147,164)"><font size="2"><strong>&nbsp;&nbsp;Wic 
            Works</strong></font></td>
        </tr>
      </table>
      <table width="100%" height="248" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="1%" height="102" valign="top">&nbsp;</td>
          <td width="99%" valign="top"><br>
            <a href="<?php echo $file ?>">[download 
            the pack]</a><br>
            <br>
            
		
<?php include("wicworkspage/index_ww.htm"); ?>		
			
            <a href="<?php echo $file ?>">[download the pack]</a> 
            <br>
            <br>
   
          </td>
        </tr>
      </table>
      <strong> </strong></td>

