<?php

include 'config.php';
session_start();
 error_reporting();






$chkstng = "SELECT * FROM `allstng` WHERE stngid=1";
 $chkstngq=mysqli_query($db,$chkstng);
 $chkstngv=mysqli_fetch_assoc($chkstngq);
///////////////for open sources show stngs

////////////// start signup
if(isset($_SESSION['refbyses']))
{ $refbyses = $_SESSION['refbyses']; }
else{ $refbyses = ""; }

if(isset($_POST['usrpacj']))
{
  $usrpacc = mysqli_real_escape_string($db,$_POST['usrpacj']);
  $usrpmj = mysqli_real_escape_string($db,$_POST['usrpmj']);
  $usremailj = mysqli_real_escape_string($db,$_POST['usremailj']);
  $usrpasj = mysqli_real_escape_string($db,$_POST['usrpasj']);

$chkmailusr = mysqli_query($db,"SELECT * FROM allurefs");
 $slctmv=mysqli_fetch_array($chkmailusr);
 $chkmails = $slctmv['umail'];

if($usremailj == $chkmails){
  echo 2; 
}else{

$upasssha1 = sha1($usrpasj);
$upassmd = md5($upasssha1);
$thisip = $_SERVER['REMOTE_ADDR'];

$signup1="INSERT INTO allurefs(umail,up,upm,upas,refby,ip) VALUES ('$usremailj','$usrpacc','$usrpmj','$upassmd','$refbyses','$thisip') ";

    $signupq = mysqli_query($db,$signup1); 
   if($signupq){ echo 1; } 
  
$chkmailofrf = mysqli_query($db,"SELECT * FROM allurefs WHERE uid='$refbyses'");
 $chkmailfrfq=mysqli_fetch_array($chkmailofrf);
 $chkmailrf = $chkmailfrfq['umail'];
  
  $sumtblref = "INSERT INTO reftbl (mail,status,whrmail) VALUES ('$usremailj','0','$chkmailrf')";
	  $sumtblrefq = mysqli_query($db,$sumtblref); 
	  
$addrfto= "UPDATE allurefs SET tref=tref+1 WHERE umail='$sumtblref'";
	$addrftoq=mysqli_query($db,$addrfto); 

  $mailsthats = "INSERT INTO loginmails (mails) VALUES ('$usremailj')";
  $mailsthatsq = mysqli_query($db,$mailsthats); 
  }
}
///////////////
//////////////////////////////////
//////// start of sums rdm //////////

if(isset($_POST['gensumsj']))
{
$accimgpm = 'pngs/pm.png';
$accimgp = 'pngs/p.png';
$rdmpmp = mt_rand(2064674,980000050);
$rdmpmpac = mt_rand(1,3);
$rdmbal = mt_rand(7,50.5);
$rdmbal = $rdmbal/100*15;
$strtdate=strtotime("now");
$datesum = date("Y-m-d",$strtdate);
if($chkstngv['rdmlogin']==0){
if($rdmpmpac==3)
{
  $rdmpmac = 'U'.$rdmpmp ;
 $rdmsums = "INSERT INTO usums(accimg,uacc,usum,date) VALUES ('$accimgpm','$rdmpmac','$rdmbal','$datesum') ";

    $rdmsumsq = mysqli_query($db,$rdmsums); 
}else{
 $rdmpac = 'P'.$rdmpmp;
 $rdmsums = "INSERT INTO usums(accimg,uacc,usum,date) VALUES ('$accimgp','$rdmpac','$rdmbal','$datesum') ";

    $rdmsumsq = mysqli_query($db,$rdmsums); 
}
}
}
/////////////// end of rdm sums 
/////////////// start of rdm sums veiw

if(isset($_POST['gensumsvj']))
{
$usumsv = "SELECT * FROM usums ORDER BY uid DESC LIMIT 21";
  $usumsvq = mysqli_query($db,$usumsv);
  while($usumsvf = mysqli_fetch_assoc($usumsvq))
  {  $usumsvlst='<tr class="sumtbltd"> <td><img src="'.substr($usumsvf['accimg'],0).'" style="width:1em">'.substr($usumsvf['uacc'],0,7).'***</td> <td class="sumdolr" style="text-align:center">'.$usumsvf['usum'].'<b class="text-light"> $ </b></td><td>'.$usumsvf['date'].'</td>';
 echo $usumsvlst;
  }
}


/////////////// end of rdm sums veiw
//////// start of sumout rdm //////////

if(isset($_POST['gensoutblj']))
{
$accimgpmw = 'pngs/pm.png';
$accimgpw = 'pngs/p.png';
$rdmpmpw = mt_rand(2064674,980000050);
$rdmpmpacw = mt_rand(1,3);
$rdmbalw = mt_rand(1,15);
$rdmbalw = $rdmbalw/100*15;
$strtdate=strtotime("now");
$datesum = date("Y-m-d",$strtdate);
if($chkstngv['rdmlogin']==0){
if($rdmpmpacw==3)
{
  $rdmpmac = 'U'.$rdmpmpw;
 $rdmsums = "INSERT INTO usumout(accimg,uacc,sumout,date) VALUES('$accimgpmw','$rdmpmac','$rdmbalw','$datesum') ";

    $rdmsumsq = mysqli_query($db,$rdmsums); 
}else{
 $rdmpac = 'P'.$rdmpmpw;
 $rdmsums = "INSERT INTO usumout(accimg,uacc,sumout,date) VALUES ('$accimgpw','$rdmpac','$rdmbalw','$datesum') ";
 $rdmsumsq = mysqli_query($db,$rdmsums); 
}
}
}
//////////////////////////
if(isset($_POST['gensoutblvj']))
{
$usumsv = "SELECT * FROM usumout ORDER BY uid DESC LIMIT 21";
  $usumsvq = mysqli_query($db,$usumsv);
  while($usumsvf = mysqli_fetch_assoc($usumsvq))
  {  $usumsvlst='<tr class="sumoutbltd"> <td><img src="'.substr($usumsvf['accimg'],0).'" style="width:1em">'.substr($usumsvf['uacc'],0,7).'***</td> <td class="sumdoutdlr" style="text-align:center">'.$usumsvf['sumout'].'<b class="text-light"> $ </b></td><td>'.$usumsvf['date'].'</td>';
 echo $usumsvlst;
  }
}
/////////////

?>