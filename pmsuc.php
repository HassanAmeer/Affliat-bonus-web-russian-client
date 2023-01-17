<?php
session_start();
include "config.php";
// error_reporting(0);

/*
echo $_COOKIE['testpmt'];
echo $_COOKIE['testpmd'];

  setcookie('testpmt','not enter file append top',time() + 60* 60 *2); */
/////// pm
$secret = strtoupper(md5($pmseckey));

$hash = $_POST['PAYMENT_ID'].':'.
$_POST['PAYEE_ACCOUNT'].':'.
$_POST['PAYMENT_AMOUNT'].':'.
$_POST['PAYMENT_UNITS'].':'.
$_POST['PAYMENT_BATCH_NUM'].':'.
$_POST['PAYER_ACCOUNT'].':'.
$secret.':'.
// $_POST['AlternateMerchantPassphraseHash']:
$_POST['TIMESTAMPGMT'];

$hash = strtoupper(md5($hash));


// to confirm
if( $hash == $_POST['V2_HASH'])
{

// to make a file if success
file_put_contents('pm_history.text','pmuser::'.$genorderid.','.$_POST['PAYER_ACCOUNT'].','.$_POST['PAYMENT_AMOUNT'].','.$_POST['TIMESTAMPGMT'], FILE_APPEND);
  
  setcookie('testpmd','ok enter file append',time() + 60* 60 *2);
  
/////////////// end of stngs 
   $strtdate=strtotime("now");
   $dateset = date("Y-m-d",$strtdate);
///////////
   $usrpacc = $_POST['PAYER_ACCOUNT'];
   $pbalv = $_POST['PAYMENT_AMOUNT'];
   $imgforp = 'pngs/pm.png';
   
 $sumbalslct = "UPDATE allurefs SET tinv=tinv + '$pbalv', ubal=ubal+'$pbalv', usrk=1 WHERE umail='$useslog'";
 $sumbalsq=mysqli_query($db,$sumbalslct) or die(mysqli_error($db));

 $setfortabl="INSERT INTO usums (accimg,uacc,usum,date,whrmail) VALUES ('$imgforp','$usrpacc','$pbalv','$dateset','$useslog')";
 $setbalqry=mysqli_query($db,$setfortabl);


  
	$slctrefid = mysqli_query($db,"SELECT refby FROM allurefs WHERE umail='$useslog'");
  $slctrefidq =mysqli_fetch_assoc($slctrefid);
  $chkrefid = $slctrefidq['refby'];
  $ksndbns = $slctrefidq['sndbns'];
  if($ksndbns == 0){
	 if($chkrefid > 0)
	 {
   $slctidofrf= mysqli_query($db,"SELECT * FROM allurefs WHERE uid='$chkrefid'");
  $slidofrfq =mysqli_fetch_assoc($slctidofrf);
   $forfbnset = $slidofrfq['ubal']/100*30;
   if($slidofrfq['refend']<=6){
	   //for every transactions
	  $vgfbal = "UPDATE allurefs SET wbal=wbal+'$forfbnset', refend=refend+1 WHERE uid='$chkrefid'";
	    $vfbalq = mysqli_query($db,$vgfbal); 
	    
    $sumtblref = "UPDATE reftbl SET invest='$pbalv', status=1 WHERE mail='$useslog'";
	  $sumtblrefq = mysqli_query($db,$sumtblref); 
  
  $sndbnsk= "UPDATE allurefs SET sndbns=1 WHERE umail='$useslog'";
	$sndbnskq=mysqli_query($db,$sndbnsk); 

   }
	     }   }

/////// end hash
}

?>