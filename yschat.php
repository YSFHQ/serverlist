<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td style="border-top: 1px solid rgb(149,147,164); border-bottom: 1px solid rgb(149,147,164)"><font size="2"><strong>YSChat</strong></font></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="114" valign="top"> <br>
      <font size="2"><strong>author </strong>: VincentWeb<br>
      <strong>language :</strong> <a href="http://www.python.org/" target="_blank">Python</a><br>
      <strong>current version :</strong> 
      <?php $f=fopen('yschat/yscversion.txt','r');
echo fread($f,filesize('yschat/yscversion.txt'));
fclose($f);?>
      (&quot;:&quot; means that the update isn't mandatory, &quot;!&quot; means 
      that the update is mandatory) <br>
      <strong>licence :</strong> open source<br>
      <strong>systems </strong>: all<br>
      downloaded 
      <?php $f=fopen('yschat/count.txt','r');
      echo intval(fread($f,filesize('yschat/count.txt')))+1;
      fclose($f); ?>
      times<br>
      <strong>size : <?php echo round(filesize("yschat/yschat.zip")/1024,1)."Ko"; ?></strong><br>
      <strong>documentation :</strong> <a href="yschat/doc_yschat.pdf" target="_blank">visit 
      this page</a><br>
      <br>
      <a href="http://www.yspilots.com/shadowhunters/dwldysc.php?url=yschat/yschat.zip">DOWNLOAD 
      IT</a><br>
      (the archive contains a compiled version and the source code .py you can 
      run with python)<br>
      <br>
      <strong>What does it permit :</strong><br>
      - follow a conversation when you are away,<br>
      - change of username at any moment<br>
      - sending auto-messages<br>
      - sending accentuated characters<br>
      - copy/paste a part of a conversation and record it (to make log files) 
      <br>
      - auto restart a server and changes is map (stop afer reset = on)<br>
      and a lot of others things...<br>
      <br>
      screenshot:<br>
      <img src="yschat/yschat0.1.PNG" width="635" height="459"> <br>
      <br>
      <br>
      <strong><font size="3">Last updates:</font></strong><br>
      <br>
      <font color="#000066">31 august of 2008, version 0.109</font><br>
      Deleted the combocox (for the ip addresses) which froze the program sometimes.<br>
      Added YSPS support<br>
      <br>
      <font color="#000066">28 august of 2008, version 0.108</font><br>
      I fixed a critical bug wich reduced the flight durations<br>
      <br>
      <font color="#000066">23 february of 2008, version 0.106(oups, I kept the 
      same number of version):</font><br>
      I fixed 2 major bugs in YSChat: <br>
      - the "userlist not found" bug which disconnected YSChat<br>
      - the 30s message: with the last version of YSFlight and YSPS, the client 
      must send a specific message to say "I am not inactive" <br>
      <font color="#000066">09 april of 2007, version 0.106:</font><br>
      #Bug of the /refresh function fixed <br>
      #Bug on exit fixed again (YSChat didn't want to close itself) <br>
      #Fixed the bug when you change the path <br>
      #You can chose the file to restart, /launchserver fsmaindx.exe will start 
      the direct version. You can do the same thing for /autoserver so that it's 
      the Directx version of the server that will auto restart <br>
      #Possibility to connect any version <br>
      #Logfiles in HTML <br>
      #fixed the bug when you change the path <br>
      <br>
      <font color="#000066">20 january of 2007, version 0.104:</font><br>
      - bug fixed $/auto &lt;5&gt; instead of /auto &lt;5&gt;<br>
      - bug fixed $time instead of $gmtime<br>
      - New function /autoserver: to make your server stop and autorestart after 
      a reset (note: you should choose the option reset every x hours and stop 
      after y times) for the moment, you can only use no-opengl version<br>
      The /autoserver also detects if the server failed to restart, and if YSChat 
      cannot reconnect after a quite short time, it starts an other server<br>
      use /stopautoserver to come back to normal settings (no autorestart of the 
      server)<br>
      - New funtion which selects a random map 30 minutes before the reset if 
      the file network.cfg hasn't been modified since the restart<br>
      (only works if the YSC of server uses /automap)<br>
      - also with /automap, the servers say you the next map after each messages 
      &quot;***Server will reset in x minutes***<br>
      - new command /changemap from all the clients : now anybody is able to select 
      the map he wants.<br>
      If the map doesn't exist, you will receive the message &quot;sorry, this 
      map doesn't exist&quot;, if the server succeed to change the map, &quot;map 
      changed successfully&quot;<br>
      Be careful, aomori is different of AOMORI, use Cap Locks when there's cap 
      lock, put the exact name<br>
      (only works if the server has got YSchat and use /automap)<br>
      - when the F3 view is disabled, you want to know who is flying without pressing 
      Escape, use the new command /listusers from any clients to print the users-flying-of-YSchat 
      (updated every minutes only) <br>
      </font><font size="2"> <br>
      <font color="#000066">28 october of 2006 version 0.103</font><br>
      #- bugs in &quot;pilot took off messages&quot; fixed<br>
      #- bug of the /loadcolour function fixed<br>
      #- fixed the error &quot;sself auto-reconnect&quot;<br>
      #- starting to build an option menu, possibility to change the YS_path<br>
      #- messages of end of mission coloured<br>
      #- nickname detection isn't anymore disturb by some tags like (241st), (171st), 
      (YGL) ... they are replaced by [241st], [171st], so that the script can 
      detect the nicknames with the '(' and ')'<br>
      #- Combobox with the last addresses ip used like in Ysflight<br>
      #- map label moved to avoid the problem of window resized <br>
      <br>
      <font color="#000066">27 august of 2006 version 0.102</font><br>
      <em>new options:</em><br>
      - play a sound when you receive a new message<br>
      - support for the versions 20060805 and 20060825 <br>
      <em>bug fixed:</em><br>
      - no nickname in the log<br>
      - sometimes disconnected<br>
      - /stopauto did not stop instantly<br>
      - need to send the command /quit after being kicked out to connect again<br>
      - sending an automessage cleared the entry to send them<br>
      - bad detection of username if you sent a message with '(' or ')' </font><font size="2">&nbsp; 
      <br>
      <br>
      <font color="#000066">20 august of 2006 version 0.1</font><br>
      First official release of YSChat</font></td>
  </tr>
</table>
