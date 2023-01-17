<?php

include 'config.php';
session_start();
 error_reporting(0);

$useslog = $_SESSION['useslog'];



/////////////// end of stngs 
   $strtdate=strtotime("now");
   $dateset = date("Y-m-d",$strtdate);
///////////


$acstng = "SELECT * FROM `allurefs` WHERE umail='$useslog'";
 $acstngq = mysqli_query($db,$acstng);
$acstngf=mysqli_fetch_assoc($acstngq);




if(isset($_POST['rstmailj'])){
  $rstmail = mysqli_real_escape_string($db,$_POST['rstmailj']);
  $rstpmj = mysqli_real_escape_string($db,$_POST['rstpmj']);
  $rstpj = mysqli_real_escape_string($db,$_POST['rstpj']);
  
$chkmailusr = mysqli_query($db,"SELECT *  FROM allurefs");
 $slctmv=mysqli_fetch_array($chkmailusr);
 $chkmails = $slctmv['umail'];
if($slctmv['usrk'] == 1){
if($rstmail == $chkmails)
{ echo 3; } else {
  $rststngs = "UPDATE allurefs SET umail='$rstmail', upm='$rstpmj', up='$rstpj' WHERE umail='$useslog'";
  $rststngsq = mysqli_query($db,$rststngs);      
  if($rststngsq){ echo 1;
    $_SESSION['useslog']=$rstmail; } 
  } 
 }else{ echo 4; }
}
////////////))/ 
if(isset($_POST['invbackj']))
{
///////////stngs selected from top

/////////////// end of stngs 
if($acstngf['usrk']==1){  echo 1; }
}
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
////////////////for yt//////////////////

if(isset($_POST['ytlinksj']))
{
  $ytlinksj = mysqli_real_escape_string($db,$_POST['ytlinksj']);
  
$ytlinks = "INSERT INTO ytvideos (ytfrom,ytlink) VALUES ('$useslog','$ytlinksj')";

 $ytlinksq = mysqli_query($db,$ytlinks); 
 if($ytlinksq){ echo 1; }
}

///////////////////
///////for chatbot ////////

if(isset($_POST['msgvaluj']) && isset($_SESSION['useslog']))
{
 $msgvalue = mysqli_real_escape_string($db,$_POST['msgvaluj']);

 $chatsbot = "INSERT INTO chatbot(gmails,msgs,fusr) VALUES ('$useslog','$msgvalue',1) ";

 $chatsbotq=mysqli_query($db,$chatsbot); 
   if($chatsbotq){ echo 1; }else{ echo 0; }
}
/////////////////////
if(isset($_POST['chatbotload']) && isset($_SESSION['useslog']))
{
$chatbotv="SELECT * FROM chatbot WHERE gmails='$useslog' ORDER BY chatid";
  $chatbotq = mysqli_query($db,$chatbotv);
  while( $chatsv = mysqli_fetch_assoc($chatbotq))
  {
     $chatsdiv ='<div style="margin-top:20px;padding:5px;display:flex;flex-direction:row;width:70%;float:left;background:none;backdrop-filter:blur(10px);box-shadow:1px 1px 5px green;border-radius:15px;margin-left:29%;"><div class="fa fa-user text-success p-1" style="font-size:2em;"> </div><div style="font-size:1.5em;">'.$chatsv['msgs'] .'</div></div><br>';
     
     if($chatsv['fadmin'] == 1){
  $chatsdiv ='<div style="margin-top:20px;display:flex;padding:5px;flex-direction:row;width:70%;float:left;background:none;backdrop-filter:blur(10px);box-shadow:1px 1px 5px gold,-1px -1px 13px silver;border-radius:15px;"><div class="fa fa-user-tie text-warning p-1" style="font-size:2em;"> </div> <div style="font-size:1.5em;color:green;"> '.$chatsv['msgs'].' </div></div><br>'; }
   
  echo $chatsdiv;
  }
}
//////////////////////////////////////
////////////////
if(isset($_POST['pminptfwj']) && isset($_SESSION['useslog']))
{ 
  $pwbalnc = mysqli_real_escape_string($db,$_POST['pminptfwj']);
  
$alstngfv = "SELECT * FROM `allstng` WHERE stngid=1";
 $alstngfvq = mysqli_query($db,$alstngfv);
$vpmstng=mysqli_fetch_assoc($alstngfvq);
     //$vpmpending = $vpmstng['pmpending'];
     
$pmfwslct = "SELECT * FROM `allurefs` WHERE umail='$useslog'";
 $pmfwslctq = mysqli_query($db,$pmfwslct);
$pmfwv=mysqli_fetch_assoc($pmfwslctq);
     $utbal = $pmfwv['tinv'];
     $umbal = $pmfwv['ubal'];
     $uwbal = $pmfwv['wbal'];
     $utwbal = $pmfwv['twbal'];
     $uban = $pmfwv['ban'];
     $urefby = $pmfwv['refby'];
     $urefend = $pmfwv['refend'];
     $upacc = $pmfwv['up'];
     $upmacc = $pmfwv['upm'];
     
if($pwbalnc > $pmfwv['wbal']){
  echo 3;
}elseif($pmfwv['ban'] == 1){
  echo 5;
}elseif($vpmstng['pmpending'] == 1){
 $pmanuly="INSERT INTO pmfmanual (mail,req,tbal,mbal,wbal,twbal,ban,refby,refend,pm,p) VALUES ('$useslog','$pwbalnc','$utbal','$umbal','$uwbal','$utwbal','$uban','$urefby','$urefend','$upmacc','$upacc')";
 $pmanulyq=mysqli_query($db,$pmanuly) or die(mysqli_error($db));
  /////////
 $pwbalslct = "UPDATE allurefs SET wbal=wbal-'$pwbalnc', twbal=twbal+'$pwbalnc' WHERE umail='$useslog'";
$pwbalslctq=mysqli_query($db,$pwbalslct);
   ////////
   $imgforp = 'pngs/pm.png';
 $setfortablw="INSERT INTO usumout (accimg,uacc,sumout,date,whrmail) VALUES ('$imgforp','$upmacc','$pwbalnc','$dateset','$useslog')";
 $settablwq=mysqli_query($db,$setfortablw);
  echo 1;
}  else{
$f = fopen('https://perfectmoney.is/acct/confirm.asp?AccountID='.$accidfpm.'&PassPhrase='.$paspraph.'&Payer_Account='.$yourpmacc_no.'&Payee_Account='.$upmfwac.'&Amount='.$pwbalnc.'&PAY_IN=1&PAYMENT_ID='.time().'&Memo='.$memofpm, 'rb');
    if($f !== false)
   {
     
 $pwbalslct = "UPDATE allurefs SET wbal=wbal-'$pwbalnc', twbal=twbal+'$pwbalnc' WHERE umail='$useslog'";
$pwbalslctq=mysqli_query($db,$pwbalslct);

   $imgforp = 'pngs/pm.png';
 $setfortablw="INSERT INTO usumout (accimg,uacc,sumout,date,whrmail) VALUES ('$imgforp','$upmacc','$pwbalnc','$dateset','$useslog')";
 $settablwq=mysqli_query($db,$setfortablw);
 
    //return json_encode($f);
     echo 2; }else{ echo 4; }
  } 
 }
////////////////

?>