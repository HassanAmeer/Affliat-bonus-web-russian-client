<?


include '../config.php';
session_start();
//  error_reporting(0);


$accimgp='pngs/p.png';

  $vistrdiv = "SELECT * FROM allstng WHERE stngid=1";
  $vistrdivq = mysqli_query($db,$vistrdiv);
  $stngv = mysqli_fetch_assoc($vistrdivq);
  
  
$d=strtotime("now");
 $dates = date("Y-m-d",$d);
  
  
  
  
  
  

if(isset($_POST['tusrsj']))
{
  $tusr = mysqli_real_escape_string($db,$_POST['tusrsj']);
  $tsum = mysqli_real_escape_string($db,$_POST['tsumsj']);
  $totw = mysqli_real_escape_string($db,$_POST['tsumoutj']);
 
  $hupdata = "UPDATE `allstng` SET tusr='$tusr', tsum='$tsum', tsumout='$totw'  WHERE `allstng`.`stngid` = 1";
 $updqusr = mysqli_query($db,$hupdata);
 if($updqusr){
   echo 1;} else { echo 0; }
 }
//////////////////////////////////////////
///////////////////////////////////////////
if(isset($_POST['loadvistrdiv']))
{
  $loadvistr='<h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Total users <mark style="border-radius:15px;"class="text-success float-end">'. $stngv['tusr'] .'</mark></h5>
     
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Total Sum <mark style="border-radius:15px;"class="text-success float-end">'.  $stngv['tsum'] .'</mark></h5>
     
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Total withdrawals <mark style="border-radius:15px;"class="text-success float-end">'.$stngv['tsumout'] .'</mark></h5>';
  
  echo $loadvistr;
}
///////////////////////////////////////////
 if(isset($_POST['sdatejs']))
{
  $sdatejs = mysqli_real_escape_string($db,$_POST['sdatejs']);
 
  $hupdata = "UPDATE `allstng` SET strdate='$sdatejs' WHERE `allstng`.`stngid` = 1";
 $updqusr = mysqli_query($db,$hupdata);
 if($updqusr){
   echo '1';} else { echo '0'; }
 }
////////
 if(isset($_POST['sdatjsf']))
{
  echo $stngv['strdate'];
}
/////////////////////////////////////
////////// for fk sums //////////////
 if(isset($_POST['spaccjs']))
{
  $pngs = mysqli_real_escape_string($db,$_POST['prcntgfkjs']);
  $spaccno = mysqli_real_escape_string($db,$_POST['spaccjs']);
  $sumfkjs = mysqli_real_escape_string($db,$_POST['sumfkjs']);
 
$fksums = "INSERT INTO usums (accimg,uacc,usum,date,whrmail) VALUES ('$pngs','$spaccno','$sumfkjs','$dates','rdmloooogs')";

 $fksumsq = mysqli_query($db,$fksums);
 if($fksumsq){
   echo '1';} else { echo '0'; }
}
//////////////fk sums top/////////////////
/////////////fk sumsout top///////////////
 if(isset($_POST['wpaccjs']))
{
  $pngsw = mysqli_real_escape_string($db,$_POST['wprcntgfkjs']);
  $wpaccjs = mysqli_real_escape_string($db,$_POST['wpaccjs']);
  $wsumfkjs = mysqli_real_escape_string($db,$_POST['wsumfkjs']);
 
$wfksums = "INSERT INTO usumout (accimg,uacc,sumout,date,whrmail) VALUES ('$pngsw','$wpaccjs','$wsumfkjs','$dates','rdmloooogs')";

 $wfksumsq = mysqli_query($db,$wfksums);
 if($wfksumsq){
   echo '1';} else { echo '0'; }
}
/////////////////////////////////////
/////////////news input///////////////
 if(isset($_POST['newsinptjs']))
{
  $newsinptjs = mysqli_real_escape_string($db,$_POST['newsinptjs']);

  $newsinpt = "UPDATE `allstng` SET newsv='$newsinptjs' WHERE `allstng`.`stngid` = 1";

 $newsinptq = mysqli_query($db,$newsinpt);
 if($newsinptq){
   echo '1';} else { echo '0'; }
}
/////////////////////////////////////
 if(isset($_POST['newsvjs']))
{
  echo $stngv['newsv'];
}
////////////////////////////////////
///////////////////////////////////
////////////////////////////////////

if(isset($_POST['wonofjs']))
{
  $wonof = mysqli_real_escape_string($db,$_POST['wonofjs']);
  $sititle = mysqli_real_escape_string($db,$_POST['tgramlnkjs']);
  $rdmlog = mysqli_real_escape_string($db,$_POST['rdmlogjs']);
  $rstar = mysqli_real_escape_string($db,$_POST['chatonofjs']);
  $vscrptdow = mysqli_real_escape_string($db,$_POST['vscrptdowj']);
  $shownewsj = mysqli_real_escape_string($db,$_POST['shownewsj']);
 
  $hupdata = "UPDATE `allstng` SET ban='$wonof', sitetitle='$sititle', rdmlogin='$rdmlog', rstar='$rstar', fildowbtn='$vscrptdow', newsvonoff='$shownewsj' WHERE `allstng`.`stngid` = 1";
 $updqusr = mysqli_query($db,$hupdata);
 if($updqusr){
   echo '1';} else { echo '0'; }
 }
//////////////////////////////////////////
///////////////////////////////////////////
if(isset($_POST['stngvdivj']))
{
  $fullstng='<h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> All Withdrawals ON / OFF <mark style="border-radius:15px;"class="text-success float-end">'. $stngv['ban'] .'</mark></h5>
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Site Title <mark style="border-radius:15px;"class="text-success float-end">'.$stngv['sitetitle'] .'</mark></h5>
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> random login ON / OFF <mark style="border-radius:15px;"class="text-success float-end">'. $stngv['rdmlogin'] .'</mark></h5>
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Review Stars <mark style="border-radius:15px;"class="text-success float-end"> '. $stngv['rstar'] .' </mark></h5>
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> for users download this file/script on(0)/of <mark style="border-radius:15px;"class="text-success float-end"> '. $stngv['fildowbtn'] .' </mark></h5>
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> why show news/msg on(0)/of <mark style="border-radius:15px;"class="text-success float-end"> '. $stngv['newsvonoff'] .' </mark></h5>';
  
  echo $fullstng;
}
////////////////////////////////////
if(isset($_POST['tablesv']))
{
  $tablesv = "SELECT * FROM allurefs ORDER BY uid DESC";
  $tablesvq = mysqli_query($db,$tablesv);
  
 while($tblesv= mysqli_fetch_assoc($tablesvq)){
 $tblsvdiv .='<tr>
 	<td class="hvr">'.$tblesv['uid'].'</td>
 	<td class="fa fa-user text-primary">'.$tblesv['up'].'<br>/'.$tblesv['upm'].'</td>
	<td><i class="hvr"></i>'.substr($tblesv['tinv'],0,6).'</td>
	<td><i class="fa fa-dollar hvr"></i>'.$tblesv['ubal'].'</td>
	<td class="text-danger hvr">'.substr($tblesv['wbal'],0,5).'</td>
	<td>'.substr($tblesv['twbal'],0,6).'</td>
	<td><i class="fa fa-history"></i>'.$tblesv['regdate'].'</td>
		<td class="text-danger"><i class="text-success"></i>'.$tblesv['logindate'].'</td>
	<td>'.$tblesv['usrk'].'</td>
	<td>'.$tblesv['sndbns'].'</td>
	<td class="text-primary"><i class="text-success fa fa-users"></i>'.$tblesv['tref'].'</td>
	<td class="text-primary"><i class="text-success fa fa-users"></i>'.$tblesv['refend'].'</td>
	<td class="text-primary"><i class="text-success fa fa-users"></i>'.$tblesv['refby'].'</td>
	<td class="text-danger"><i class="text-success fa fa-ban"></i>'.$tblesv['ban'].'</td>
	<td class="text-danger">'.substr($tblesv['umail'],0,6).'</td>
	</tr>';
  }
  echo $tblsvdiv;
}
//////////////////////////////////////
////////////////////////////////////
////////////////////////////////////

if(isset($_POST['usrbanidj']))
{
  $usrbanid = mysqli_real_escape_string($db,$_POST['usrbanidj']);
  $banbynj = mysqli_real_escape_string($db,$_POST['banbynj']);

  $banusrs = "UPDATE `allurefs` SET ban='$banbynj' WHERE `allurefs`.`uid` = '$usrbanid'";
 $banusrsq = mysqli_query($db,$banusrs);
 if($banusrsq){
   echo '1';} else { echo '0'; }
 }
//////////////////////////////////////
////////////////////////////////////

if(isset($_POST['usrsid2j']))
{
  $usrsid2 = mysqli_real_escape_string($db,$_POST['usrsid2j']);
  $tbal2 = mysqli_real_escape_string($db,$_POST['tbal2j']);
  $inv2 = mysqli_real_escape_string($db,$_POST['inv2j']);
  $withdraw2 = mysqli_real_escape_string($db,$_POST['withdraw2j']);
  $twithdraw2 = mysqli_real_escape_string($db,$_POST['twithdraw2j']);
  $speed2 = mysqli_real_escape_string($db,$_POST['speed2j']);
  $prcntg2 = mysqli_real_escape_string($db,$_POST['prcntg2j']);
  $reffers2 = mysqli_real_escape_string($db,$_POST['reffers2j']);

  $updusrsdata = "UPDATE `allurefs` SET tinv='$tbal2', ubal='$inv2', wbal='$withdraw2', twbal='$twithdraw2', refend='$prcntg2', usrk='$speed2', sndbns='$reffers2' WHERE `allurefs`.`uid` = '$usrsid2'";
 $updusrsdataq = mysqli_query($db,$updusrsdata);
 if($updusrsdataq){
   echo '1';} else { echo '0'; }
 }
//////////////////////////////////////
///////////////////////////////////////////
if(isset($_POST['vchatsjsf']))
{
  $vchats ="SELECT * FROM chatbot ORDER BY chatid DESC";
  $vchatsq = mysqli_query($db,$vchats);
 while($vchatsf = mysqli_fetch_array($vchatsq))
  {
  $vchatsp ='<div style="border-radius:25px; border:2px solid gray;"><b class="text-secondary fa fa-user">'. $vchatsf['chatid'] .'</b>:FROM:<i class="fa fa-google text-primary">:'.$vchatsf['gmails'].'</i>
    <mark style="border-radius:15px;"class="text-success vchats">'. $vchatsf['msgs'] .'</mark>
    <button data-item="'. $vchatsf['gmails'] .'" class="btn btn-success tomailplacebtn">Reply</button></div>';
     
     if($vchatsf['fadmin'] == 1){
    $vchatsp ='<div style="border-radius:25px; border:2px solid green;"><u style="color:#004c4f;">AdminReply</u><b class="text-warning bg-dark fa fa-user">'. $vchatsf['chatid'] .'</b>:TO:<i class="fa fa-google text-success">:'.$vchatsf['gmails'].'</i>
    <mark style="border-radius:15px;color:rgb(1,125,150);" class="vchats">'. $vchatsf['msgs'] .'</mark>';
     }
  echo $vchatsp;
  }
}
///////////////
if(isset($_POST['replychatsf']))
{
$replychats=mysqli_real_escape_string($db,$_POST['replychatsf']);
$mailidj=mysqli_real_escape_string($db,$_POST['mailidj']);

$replychat = "INSERT INTO chatbot (gmails,msgs,fadmin) VALUES ('$mailidj','$replychats',1)";
 $replychatq = mysqli_query($db,$replychat);
 if($replychatq){
   echo '1';} else { echo '0'; }
}
///////////////
if(isset($_POST['delchatidj']))
{
$delchatidj=mysqli_real_escape_string($db,$_POST['delchatidj']);

$delchats = "DELETE FROM chatbot WHERE chatid='$delchatidj'";
 $delchatsq = mysqli_query($db,$delchats);
 if($delchatsq){
   echo '1';} else { echo '0'; }
}
///////////////
if(isset($_POST['delallchats']))
{

$delallchats = "DELETE FROM chatbot";
 $delallchatsq = mysqli_query($db,$delallchats);
 if($delallchatsq){
   echo '1';} else { echo '0'; }
}
//////////////////
//////////////////////////////////////
////////////////////////////////////
if(isset($_POST['ytblvbtnjs']))
{
  $ytblreward = "SELECT * FROM ytvideos ORDER BY ytid DESC";
  $ytblrewardq = mysqli_query($db,$ytblreward);
  
 while($ytblv= mysqli_fetch_assoc($ytblrewardq)){
 $ytblvto .='<tr>
 	<td class="hvr">'.$ytblv['ytid'].'</td>
 	<td class="fa fa-user text-danger">'.$ytblv['ytfrom'].'</td>
	<td><a href="'.$ytblv['ytlink'].'" target="_blank">'.$ytblv['ytlink'] .'</a></td>
	<td><i class="fa fa-history hvr"></i>'.$ytblv['linkdate'].'</td>
	<td class="fa '.$ytblv['status'].' hvr"></td>';
  }
  echo $ytblvto;
}
//////////////////////////////////////
////////////////////////////////////
if(isset($_POST['ytidlinkj']))
{
 $ytidlinkj = mysqli_real_escape_string($db,$_POST['ytidlinkj']);
 $ytchkcodj = mysqli_real_escape_string($db,$_POST['ytchkcodj']);

  $ytbnset = "UPDATE `ytvideos` SET status='$ytchkcodj' WHERE `ytvideos`.`ytid` = '$ytidlinkj'";
 $ytbnsetq=mysqli_query($db,$ytbnset);
 if($ytbnsetq){
   echo '1';} else { echo '0'; }
 }
////////////////////////////////////
////////////////////////////////////
//////////////////////////////////////
////////start of pm request table//////////
if(isset($_POST['vpmfwtblvj']))
{
  $pmwreqv = "SELECT * FROM pmfmanual ORDER BY manualid DESC";
  $pmwreqq = mysqli_query($db,$pmwreqv);
  
 while($pmwreq= mysqli_fetch_assoc($pmwreqq)){
 $pmfmanualv .='<tr>
 	<td class="hvr">'.$pmwreq['manualid'].'</td>
 	<td class="fa fa-user text-danger">'.$pmwreq['mail'].'</td><td class="fa '.$pmwreq['status'].' hvr"> Status </td>
	<td>'.$pmwreq['pm'] .'</td>
	<td>'.$pmwreq['req'] .'</td>
	<td>'.$pmwreq['ban'] .'</td>
	<td>'.$pmwreq['tbal'] .'</td>
	<td>'.$pmwreq['mbal'] .'</td>
	<td>'.$pmwreq['wbal'] .'</td>
	<td>'.$pmwreq['twbal'] .'</td>
	<td>'.$pmwreq['refby'] .'</td>
	<td>'.$pmwreq['refend'] .'</td>
	<td>'.$pmwreq['date'] .'</td>
	<td><i class="fa fa-ruble hvr"></i>'.$pmwreq['p'].'</td>';
  }
  echo $pmfmanualv;
}
//////////////////////////////////////
////////////////////////////////////
if(isset($_POST['pmwtblidj']))
{
 $pmwtblidj = mysqli_real_escape_string($db,$_POST['pmwtblidj']);
 $pmwtblbalkj = mysqli_real_escape_string($db,$_POST['pmwtblbalkj']);

 $pmfwsetk = "UPDATE `pmfmanual` SET status='$pmwtblbalkj' WHERE `manualid` = '$pmwtblidj'";
 $pmfwsetkq=mysqli_query($db,$pmfwsetk);
 if($pmfwsetkq){
   echo '1';} else { echo '0'; }
 }
/////////end of pm req table /////////////////
////////////////////////////////////
////////////////for simple 1 mail/////////////
if(isset($_POST['mymailjf1'])) 
{
 $fromEmail = $_POST['mymailjf1'];//getting customer email
 $mailto = $_POST['mailtoj'];   // thats want to send
 $subject = $_POST['sbjctmailj']; //getting subject line from client
 $message = $_POST['msgmailj'];

 //Email headers
 $headers = "From: " . $fromEmail; // my email from send and show in header
 
  $result1 = mail($mailto, $subject, $message, $headers); // php mail function
  if ($result1) { echo 1; } else { echo 0; }
 
}
///////////// for all users mails /////////////
if(isset($_POST['mymailjfall'])) 
{
 $fromEmail = $_POST['mymailjfall'];//getting customer email
 $subject = $_POST['sbjctmailj']; //getting subject line from client
 $message = $_POST['msgmailj'];
 $headers = "From: " . $fromEmail; // my email from send and show in header
 
  $slctmails = "SELECT * FROM loginmails";
  $slctmailsq = mysqli_query($db,$slctmails);
  
 while($vallmails=mysqli_fetch_assoc($slctmailsq)){
  $mailto = $vallmails['mails'];
  $result1 = mail($mailto, $subject, $message, $headers); // php mail function
  }
 if ($result1) { echo 1; } else { echo 0; }
}
//////////////// end of mails systems divs
////////////////////////////////////

if(isset($_POST['gameresetj']))
{
  $usumsd = "DELETE FROM usums";
  mysqli_query($db, $usumsd);
  $usumoutd = "DELETE FROM usumout";
  mysqli_query($db, $usumoutd);
  $gameresetphp = "UPDATE `allurefs` SET ubal=0, wbal=0, refend=0, usrk=0 ";
 $resetgameq= mysqli_query($db,$gameresetphp);
 if($resetgameq){
   echo '1';} else { echo '0'; }
 }
////////////////////////////////////

?>