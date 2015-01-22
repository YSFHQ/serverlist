

      
<table width="93%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="100%" style="border-top: 1px solid rgb(149,147,164); border-bottom: 1px solid rgb(149,147,164)"><font size="2"><strong>&nbsp;&nbsp;SERVERS</strong></font></td>
        </tr>
      </table>
      <table width="681" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="681" height="102" valign="top">
<div align="left">
              <table width="100%" border="0" align="center">
                <tr> 
                  <td colspan="3"><div align="center"><font size="4"><strong> 
                      ------------ our YSflight servers ------------ </strong></font></div></td>
                </tr>
                <tr> 
                  <td align="center"> <div align="center"><strong><font color="#333333" size="4"><em><img src="server.gif" width="90" height="90"><br>
                      ip: 241st.game-server.cc<br>
                      <font size="3">port: 7915<br>
                      <?php 
@$e=fopen("http://241st.game-server.cc/","r");
$ok = $e;
if ($e){
?>
                      <iframe src="http://241st.game-server.cc/241st/outserver/vince.php" align="middle" width="150pt" name="vincentweb" height="50pt" scrolling="no" hspace="0" frameborder="0"></iframe>
                      <?php }else {echo "<img src=offline.gif>";} ?>
                      </font></em></font></strong></div>
                    <div align="center"> 
                      <?php
@$f=fopen("http://241st.game-server.cc/yserver/", "r");
@$fserver=fread($f, 200);
@fclose($f);
@$fserver2=strstr($fserver,'DEFLTFIELD');
@$fserver=substr($fserver2,12);
@$fserver2=strstr($fserver,'DFSTPOSSVR');
@$fserver3=substr($fserver, 0,strlen($fserver)-strlen($fserver2));
@$fserver=substr($fserver3,0,strlen($fserver3)-3);
if ($fserver){
echo "<br><font color=\"#333333\"><em> map : " . $fserver . "</em></font>";}
?>
                    </div></td>
                  <td align="center"><div align="center"><strong><font color="#000000" size="4">Piko's 
                      server</font><font color="#333333" size="4"><em> <br>
                      <br>
                      ip: 217.30.219.241<br>
                      <font size="3">port: 7915</font></em></font></strong><br>
                    </div>
                    <?php 
@$e=fopen("http://241st.game-server.cc/","r");
if ($e){
?>
                    <iframe src="http://241st.game-server.cc/241st/outserver/piko.php" align="middle" width="150pt" name="piko" height="50pt" scrolling="no" hspace="0" frameborder="0"></iframe> 
                    <?php }else {echo "<img src=offline.gif>";} ?>
                  </td>
                  <td align="center"> <div align="center"><strong><font color="#333333" size="4"><em><img src="jakobserver.gif" width="90" height="90"><br>
                      ip: jakob.game-server.cc<br>
                      <font size="3">port: 7915</font></em></font></strong><br>
                    </div>
                    <?php 
@$e=fopen("http://241st.game-server.cc/","r");
if ($e){
?>
                    <iframe src="http://241st.game-server.cc/241st/outserver/jakob.php" align="middle" width="150pt" name="jakob" height="50pt" scrolling="no" hspace="0" frameborder="0"></iframe>
                    <?php }else {echo "<img src=offline.gif>";} ?>
                  </td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"><strong><font size="4"><strong>------------ 
                      </strong>our Teamspeak servers <strong>------------ </strong></font></strong></div></td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> <div align="center"><strong><font color="#333333" size="4"><em>Teamspeak<br>
                      ip: <a href="teamspeak://241st.game-server.cc" target="_blank"><font color="#333334">241st.game-server.cc</font></a><br>
                      <font size="3">port: 8767/14534</font></em></font></strong><br>
                      <?php 

if ($ok){
?>
                      <iframe src="http://241st.game-server.cc/241st/outserver/teamspeak.php" align="middle" width="150pt" name="teamspeak" height="50pt" scrolling="no" hspace="0" frameborder="0"></iframe>
                      <?php }else {echo "<img src=offline.gif>";} ?>
                    </div>
                    <div align="center"><strong><font color="#333333" size="4"><em><br>
                      </em></font></strong></div></td>
                </tr>
              </table>
              <font size="2"><br>
              </font></div></td>
        </tr>
      </table>
      <strong> </strong></td>
  </tr>
</table>


