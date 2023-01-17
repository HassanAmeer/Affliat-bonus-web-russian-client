<?php
session_start();
include "config.php";
 error_reporting(0);

// setcookie('pmpayid','1652797258',time() + 60 * 60 * 2); // for 2 hours

if(isset($_COOKIE['pmpayid']))
{ $payidsh1 = $_COOKIE['pmpayid'];
  $payid = sha1($payidsh1); }else{
   return null;
  }
  
if(isset($_SESSION['useslog']))
{ $useslog = $_SESSION['useslog']; 
}
/*elseif(isset($_COOKIE['sescoki'])) {
  $useslog = $_COOKIE['sescoki'];
  $_SESSION['useslog'] = $useslog;
}
*/


/*This script demonstrates querying account historyusing PerfectMoney API interface.*/
// trying to open URL

$f=fopen('https://perfectmoney.is/acct/historycsv.asp?startmonth=5&startday=8&startyear=2022&endmonth=5&endday=28&endyear=2022&AccountID='.$accidfpm.'&PassPhrase='.$paspraph, 'rb');
if($f===false){echo 'error openning url';}
// getting data to array (line per item)
 $lines=array();
 while(!feof($f))
 array_push($lines, trim(fgets($f)));
 fclose($f);
 // try parsing data to array
 if($lines[0]!='Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account,Payment ID,Memo'){
   // print error message
   echo $lines[0];
 }else{ 
     // do parsing
     $ar=array();
     $n=count($lines);
     
     for($i=1; $i<$n; $i++)
     {$item=explode(",", $lines[$i], 10);
    // if(count($item)!=9) continue;
     // line is invalid - pass to next one
    
     $item_named['Time']=$item[0];
   //  $item_named['Type']=$item[1];
   //  $item_named['Batch']=$item[2];
   //  $item_named['Currency']=$item[3];
     $item_named['Amount']=$item[4];
    // $item_named['Fee']=$item[5];
     $item_named['Payer Account']=$item[6];
   //  $item_named['Payee Account']=$item[7];
     $item_named['Payment ID']=$item[8];
    // $item_named['Memo']=$item[9];
     
      array_push($ar, $item_named); 
     } // end for loop
   } // end of if data present to get data
      
    /*  echo '<pre>';
      print_r($ar);
      echo '</pre>'; */


  
  // for each
foreach ($ar as $k){

  if($k['Payment ID'] == $payidsh1)
  { 
    $pbalv = $k['Amount'];
  
$payidv = "SELECT * FROM `pmsetorder` WHERE hid='$payid'";
 $payidvq = mysqli_query($db,$payidv);
$payidvf=mysqli_fetch_assoc($payidvq);
$fhidv = $payidvf['hid'];

  if($fhidv == $payid)
  { echo 'already used try new one'; }else{
$bythisk = "INSERT INTO pmsetorder (hid,amount,bythisk) VALUES ('$payid','$pbalv','$useslog')";
 $bythiskq = mysqli_query($db,$bythisk);
      
      
      
      
      
      
      
      
      
      
      
      
  $strtdate=strtotime("now");
   $dateset = date("Y-m-d",$strtdate);
///////////
$forvuid = " SELECT * FROM `allurefs` WHERE umail = '$useslog' ";
 $fvuidq = mysqli_query($db , $forvuid) or die(mysql_error($db));
 
$fvuidv=mysqli_fetch_assoc($fvuidq);
$fuid = $fvuidv['uid'];
$usrpacc = $fvuidv['upm'];
///////////

 //  $usrpacc = $_POST['PAYER_ACCOUNT'];
//   $pbalv = $_POST['PAYMENT_AMOUNT'];
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
	     

      
      
      
      
      
      
      
      
      
      
      
       
   } // if sh1 id not match end bracket
    
  } // if id match
  
} // end for each
 
setcookie('pmpayid','',time() - 3600);
unset($_COOKIE['pmpayid']);


?>