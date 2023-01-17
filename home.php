<?php

include 'config.php';
session_start();
 error_reporting(0);

if(isset($_COOKIE['pmpayid']))
{ include 'pmpayid.php'; } 


if(isset($_SESSION['phpred']))
{ unset($_SESSION['phpred']); }
if(isset($_SESSION['phpgreen']))
{ unset($_SESSION['phpgreen']); }


if(isset($_COOKIE['sescoki']))
{
  if($_COOKIE['sescoki'] == "" || $_COOKIE['sescoki'] == " "){
    header('location:index.php');
  }
}
// if(!$useslog)
// { header('location:index.php'); }


if(isset($_SESSION['useslog']))
{ $useslog = $_SESSION['useslog']; 
}elseif(isset($_COOKIE['sescoki'])) {
  $useslog = $_COOKIE['sescoki'];
  $_SESSION['useslog'] = $useslog;
}else{
  header('location:index.php');
}




if(isset($_POST['logoutbtn']))
{  unset($_SESSION['useslog']);
  header('location:index.php');
}

if(isset($_SESSION['phpred']))
{ unset($_SESSION['phpred']); }
if(isset($_SESSION['phpgreen']))
{ unset($_SESSION['phpgreen']); }

$useslog = $_SESSION['useslog'];

/**********************************/
$navlds = " SELECT COUNT(uid) AS cuid FROM usums";
$navldq = mysqli_query($db,$navlds);
$navld = mysqli_fetch_assoc($navldq);
///// end of count total users
$chkstng = "SELECT * FROM `allstng` WHERE stngid=1";
 $chkstngq=mysqli_query($db,$chkstng);
 $chkstngv=mysqli_fetch_assoc($chkstngq);
///////////////
$navtsum = " SELECT SUM(usum) AS usumbal FROM usums";
$navtsq = mysqli_query($db,$navtsum);
$scrubles = mysqli_fetch_assoc($navtsq);
///// start count total sums
$navtsumout = "SELECT SUM(sumout) AS sumoutw FROM usumout";
$navtsumoutq=mysqli_query($db,$navtsumout);
$sumoutv=mysqli_fetch_assoc($navtsumoutq);
///// end all count total Withdraw

/////////// for stngs 
$acstng = "SELECT * FROM `allurefs` WHERE umail='$useslog'";
 $acstngq = mysqli_query($db,$acstng);
$acstngf=mysqli_fetch_assoc($acstngq);
$ifrfend = $acstngf['refend'];
if($ifrfend >= 6)
{
  $zero = 0;
 $refendif= "UPDATE allurefs SET ubal='$zero' WHERE umail='$useslog'";
	$refendifq=mysqli_query($db,$refendif);
}
/////////////// end of stngs 
   $strtdate=strtotime("now");
   $dateset = date("Y-m-d",$strtdate);
///////////


//////////////////////////////////////
////////////////


/* ////////////////////////////////////
 //////////////////////////////////////
 ///////////Start of Payeer Withdraw/////////////////////////////////////////////////////////////// */
     
 if(isset($_POST['withdbtnp']))
 {
   $wpaccno = $acstngf['up'];
   $pwbalnc = mysqli_real_escape_string($db,$_POST['pwithdinpt']);
   
   if($pwbalnc > $acstngf['wbal'])
   {
     $_SESSION['phpred'] = 'You entered higher Amount';
   } else if($pwbalnc < 0.1){
   $_SESSION['phpred'] = ' Minimum 0.1 $ Amount Can Withdrawal';
   }else{
    $stngsban = $chkstngv['ban'];
    $sban =$acstngf['ban'];
    if($sban == 1 || $stngsban == 1){
      $_SESSION['phpred'] = 'Dears ! Invite 1  Freinds Balance automatically in your wallets';
    }else{
    require_once('cpayeer.php');
  $accountNumber = $payeeraccno;
  $apiId = $apiIdset;
  $apiKey = $apikeyp;
  $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
if($payeer->isAuth())
{
	$arTransfer = $payeer->transfer(array(
		'curIn' => 'USD',
		'sum' => $pwbalnc,
		'curOut' => 'USD',
		'to' => $wpaccno,
		'comment' => 'invest before get last bonus then bonus is doubled (simple tricks)',
	));
	// for updates
	if (empty($arTransfer['errors']))
	{
     $setwidfch = $arTransfer['historyId'];
	   $setwidfchs = sha1($setwidfch);
	   $setwidfchm = md5($setwidfchs);
 $insrtwid = "INSERT INTO coinshistory (coinph) VALUES ('$setwidfchm')";
$insrtwidq=mysqli_query($db,$insrtwid) or die(mysqli_error($db));
	  
   $pwbalslct = "UPDATE allurefs SET wbal=wbal-'$pwbalnc', twbal=twbal+'$pwbalnc' WHERE umail='$useslog'";
$pwbalslctq=mysqli_query($db,$pwbalslct);
   $imgforp = 'pngs/p.png';
 $setfortablw="INSERT INTO usumout (accimg,uacc,sumout,date,whrmail) VALUES ('$imgforp','$wpaccno','$pwbalnc','$dateset','$useslog')";
 $settablwq=mysqli_query($db,$setfortablw);
		if($pwbalslctq)
		{
		  $_SESSION['phpgreen'] = 'Success Paid : ('.$pwbalnc.') $';
		}
		
 }else{ echo 'Tr errors Some Time By Payeer'; }
		/*echo '<pre>'.print_r($arTransfer["errors"], true).'</pre>'; */
	 // end updates
}else{ // for not authorized

	  echo 'Tr auth errors Some Time By Payeer'; 
	  /*
	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>'; */
}
}
  }
}

 
/* ////////// end of withdraw p///////
 ////////////////////////////////////
 /////////////////////////////////////
 ///////////////////////////////////// */
/* ///// Start of payeer get bal /////
 ////////////////////////////////////
 /////////////////////////////////////
 ///////////////////////////////////// */
   
if(isset($_POST['pchtridbtn']))
  {
    require_once('cpayeer.php');
    $accountNumber = $payeeraccno;
    $apiId = $apiIdset;
    $apiKey = $apikeyp;
    $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
    // for check with get id
    $popidesc = mysqli_real_escape_string($db,$_POST['pchtridinpt']);
if ($payeer->isAuth())
{	
  $historyId = $popidesc;
	$arHistory = $payeer-> getHistoryInfo ($historyId);
  foreach ($arHistory as $k)
	{ }
	$_SESSION['phpgreen'] = $k['sumOut'].' USD √ + added'; 

	// end of history id 
	 if($k['sumOut'] >= 1 && $k['curOut'] == 'USD')
	{ 
	  // check if already id present in db or not
	   $popidesch = sha1($popidesc);
	   $popidescm = md5($popidesch);
	  $chkpopid = "SELECT * FROM coinshistory WHERE coinph='$popidescm'";
  $sqliqpop = mysqli_query($db,$chkpopid);
	$vtridh = mysqli_fetch_assoc($sqliqpop);
	  if($vtridh['coinph'] == $popidescm)
	 { $_SESSION['phpred'] =' Already Used This Transaction ID';
	  }else{
	  $insrttrid = "INSERT INTO coinshistory (coinph) VALUES ('$popidescm')";
	  $insrttridq = mysqli_query($db,$insrttrid);

   $pbalv = $k['sumOut'];
 $sumbalslct = "UPDATE allurefs SET tinv=tinv + '$pbalv', ubal=ubal+'$pbalv', usrk=1 WHERE umail='$useslog'";
 $sumbalsq=mysqli_query($db,$sumbalslct) or die(mysqli_error($db));
  
   $imgforp = 'pngs/p.png';
   $usrpacc = $acstngf['up'];
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


	}  //////////end bal//else////////// 
  

  	}
	}else{
	  $_SESSION['phpred'] = 'Dears! SomeTime Tr author errors by  Payeer';
	}
}

/* ///// Start of payeer get bal /////
 ////////////////////////////////////
 /////////////////////////////////////
 /////////////////////////////////// */
/* ///// Start of PM get bal /////
 ////////////////////////////////////
 /////////////////////////////////////
 ////////////////////////////////// */






















?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.4">
    <link rel="shortcut icon" href="pngs/bonustrade.png" type="image/x-icon">
    <title> Top_Bonus </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="fontawesomecss">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="pngs/bonustrade.png" type="image/x-icon">
</head>
<body>
    
    
     
<!------- start of top div-->
    <div style="width: 100%;border: 10px solid indigo; border-radius:15px;">
        <center>
            <div style="display: flex;flex-direction: row;">
                  <div style="width: 33%;">
                  <h5 style="color: rgb(0, 144, 201);"> total users </h5><b class="text-success"> <? echo $navld['cuid'] + $chkstngv['tusr']; ?> </b>
                </div>
                <div style="width: 33%;">
                    <h5 style="color: rgb(0, 26, 255);"> total sum </h5><b class="text-success">  <? echo substr($scrubles['usumbal']/100*70 + $chkstngv['tsum'],0,8); ?> $</b>
                  </div>
                  <div style="width: 33%;">
                    <h5 style="color: rgb(7, 218, 182);"> total sumout </h5><b class="text-success"> <? echo substr($sumoutv['sumoutw'] + $chkstngv['tsumout'],0,8); ?> $</b>
                  </div>
            </div>
            <h4 style="color: rgb(76, 0, 255);  border-radius: 15px; background: rgb(255, 227, 227);width: auto;">
        <img src="pngs/bonustrade.png" style="width: 2em;"> <?  echo $chkstngv['sitetitle']; ?> </h4>
        </center>
        
           <? if($chkstngv['rstar']==3.5){
        ?>
        <div class="float-start" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 30%;border-radius: 10px;"> 
            <h5 class="fa fa-users text-light"> </h5>
            <h5 class="text-info"> Total reviews </h5>      
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star-half phpstrs "> </h5>
            <h5 class="fa fa-star text-muted"> </h5>
        </div>
        <? } ?>
        
      <? if($chkstngv['rstar']==4){
        ?>
        <div class="float-start" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 30%;border-radius: 10px;"> 
            <h5 class="fa fa-users text-light"> </h5>
            <h5 class="text-info"> Total reviews </h5>      
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star text-muted"> </h5>
        </div>
        <? } ?>
        
      <? if($chkstngv['rstar']==4.5){
        ?>
        <div class="float-start" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 30%;border-radius: 10px;"> 
            <h5 class="fa fa-users text-light"> </h5>
            <h5 class="text-info"> Total reviews </h5>      
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star-half phpstrs"> </h5>
        </div>
        <? } ?>
        
      <? if($chkstngv['rstar']==5){
        ?>
        <div class="float-start" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 30%;border-radius: 10px;"> 
            <h5 class="fa fa-users text-light"> </h5>
            <h5 class="text-info"> Total reviews </h5>      
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
            <h5 class="fa fa-star phpstrs"> </h5>
        </div>
        <? } ?>
       
        <style>
            .rstr{
                color:rgb(153, 131, 131);
            }
          .phpstrs{
            color: lime;
          }
        </style>
        
        <div class="float-end" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 27%;border-radius: 10px;"> 
            <h5 class="fa fa-user-tie text-light"> </h5>
            <h5 class="adedrstrs" style="color:aqua;"> review this </h5>      
            <h5 class="fa fa-star str1 rstr"> </h5>
            <h5 class="fa fa-star str2 rstr"> </h5>
            <h5 class="fa fa-star str3 rstr"> </h5>
            <h5 class="fa fa-star str4 rstr"> </h5>
            <h5 class="fa fa-star str5 rstr"> </h5>
        
        </div>
        
        </div></br>

        
        <!---------- start for menus buttons -->
      <style>
       .hmenus a{
          margin-left: 4em; font-size: 1em;
            }
       .godashbtn{
         animation: godashbtn 3s infinite alternate;
       }
  @keyframes godashbtn{
    30%{ box-shadow: 1px 1px 25px silver; }
    70%{ box-shadow: 1px 1px 50px gold;color:orange; letter-spacing:4px; }
  }
 .whenewsbtn{
background:navy;border:none;border-left:7px solid aqua;outline:none;border-radius:0 15px 15px 0; }
  .whenews{width:2em;color:gold;font-size:1.5em;outline:none;animation: whenews 4s infinite reverse; }
  @keyframes whenews
  {
    10%{
      transform: rotate(15deg);
    }
    30%{
      transform: rotate(-15deg);
      color: aqua;
    }
    50%{
      transform: rotate(30deg);
    }
    80%{
      transform: rotate(-30deg);
      color: aqua;
    }
    90%{
      transform: rotate(0deg);
      color: silver;
    }
  }
    </style>
        <center>
         <div class="hmenus" style="display: flex;flex-direction: row;width: 70%; background: none;justify-content: center;">
         
          <a href="/" class="btn btn-warning"> HOME </a>

          <a href="contact.php" class="btn btn-warning" style="margin-left:1em;"> CHAT US </a> 
          
        <a class="btn btn-success rststngbtnav"><i class="fa fa-cogs"> </i><i class="fa fa-user-cog text-warning"> </i></a>
        
         <a><form method="POST" style="">
         <input type="submit" class="btn btn-danger" value="LOGOUT" name="logoutbtn">
         </form></a>
         </div>
        </center>
<!------- end of top div -->
<!----------------------------------------------------------------------------->





 <!-------- php alert----success ------>
 <? if(isset($_SESSION['phpgreen'])){ ?>
 <div class="alert alert-success" role="alert"> <? echo $_SESSION['phpgreen']; ?> </div>
 <? } ?>
 <!------ php alert----danger--------->
 <? if(isset($_SESSION['phpred'])){ ?>
 <div class="alert alert-danger" role="alert"> <? echo $_SESSION['phpred']; ?> </div>
 <? } ?>
 <!--------------------------------->
 <!---------------------------------->

 <!---------------------------------->
 <div id="errors" class="alert notifycross" style="width:100%; display:none;position:sticky;z-index:100;top:300px; background:rgb(114,0,0); color:#fe839c; border-radius:20px; border:1px solid #ff6e6ede; box-shadow:2px 2px 14px 2px black;font-size:0.7em;" role="alert">
   </div>
 <!---------------------------------->
 <!---------------------------------->
 <div id="successrs"class="alert notifycross" style="width:100%; position:sticky;z-index:100;top:220px; background:rgb(0,75,0); display:none;color:lime;border-radius:20px; border:1px solid #00e300;font-size:0.7em; box-shadow:2px 2px 14px 2px black;" role="alert">
</div>
 <!---------------------------------->
 <!---------------------------------->
<? if($chkstngv['newsvonoff'] == 0){ ?>
<button class="whenewsbtn"><b class="fa fa-bell whenews"></b></button>
<center>
<div class="whenewsdiv" style="display:none;background:navy; border-radius:0 20px 20px 0; border:none; border-left:7px solid aqua;"> 
<button class="btn btn-danger float-start whenewsbtncros">X</button>
<u style="color:gold;"> Notification </u>
  <p style="color:silver;"> <? echo $chkstngv['newsv'] ; ?></p>
</div>
</center>
<? } ?>





<center>
<div class="rststngdiv" style="display:none;border-radius: 20px;box-shadow: 2px 2px 20px black; width: 60%;background: rgb(56, 51, 51);">
 
 <button class="btn btn-danger rststngcros float-end" style="margin-top:1em;"> X </button>
  <h5 class="text-light"> Setting Account </h5><br>
  
    <input type="text" class="rstmail" style="color:#ff409e; border:none; border-bottom:5px solid #ff208a;outline:none;" value="<? echo $acstngf['umail']; ?>" placeholder="Reset Emails"><br><br>
    <input type="text" class="rstpm" style="color:red; border:none; border-bottom:5px solid red;outline:none;" value="<? echo $acstngf['upm']; ?>" placeholder="Reset Perfect Money"><br><br>
    <input type="text" class="rstp" style="color:navy; border:none; border-bottom:5px solid navy;outline:none;" value="<? echo $acstngf['up']; ?>" placeholder="Reset Payeer"><br><br>
   <input type="submit" class="rststngbtn" value="Reset" style="font-size:2em;color:lime; background:#045b00;border:none;border-left:15px solid green; border-radius:0 20px 20px 0;">
</div></center>



<center><br>
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 80%;background: rgb(56, 51, 51);">
  <u style="color:pink;font-size:em;"> <? echo $_SESSION['useslog']; ?></u>
    <h3 style="color:white"> Invest balance : <b style="color:aqua;"> <? echo $acstngf['ubal']; ?></b> <b class="fa fa-coins text-warning"> </b></h3><br>
    <h3 style="color:white"> Paid refferals : <b style="color:aqua;"> <? echo $acstngf['tref']; ?></b> <b class="fa fa-users text-light"> </b></h3><br>
    <h3 style="color:white"> Your Earning : <b style="color:aqua;">  <? echo $acstngf['wbal']; ?> </b> <b class="fa fa-coins text-warning"> </b></h3><br>
    <h3 style="color:white"> Your ip : <b style="color:silver;"> <? echo $acstngf['ip']; ?> </b> <b class="fa fa-server text-info"> </b></h3>
    <hr class="p-1 bg-light">
    <p class="text-danger">want to back my investment cash</p><button class="btn btn-outline-warning invstbackbtn"> Invest Back</button>
</div>

<br><br>
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 60%;background: rgb(56, 51, 51);">
  <h5 class="text-light"> Your Refferal Link </h5><br>
 
  <b class="fa fa-users text-info" style="font-size:2em;"> </b><input type="text" value="<? echo $_SERVER['HTTP_HOST'].'/?referid='. $acstngf['uid']; ?>" id="copyreflink" style="width:75%;  margin-left:5%; color:lime;background:none;border-bottom:4px solid navy; border-right:none;border-left:none;border-top:none;outline:none;font-size:1.5em;">
  <button class="btn btn-outline-warning" onclick="copyrefbtn()" id="copyrefbtn"> Copy </button>
</div>
<!----------------------------------
<h4 class="text-danger"> pm 1 by get</h4>
<form action="https://perfectmoney.com/api/step1.asp" method="POST">
<input type="hidden" name="PAYEE_ACCOUNT" value="U27052943">
<input type="hidden" name="PAYEE_NAME" value="getsell">
<input type="hidden" name="PAYMENT_ID" value="786">
<input type="hidden" name="PAYMENT_AMOUNT" value="1">
<input type="hidden" name="PAYMENT_UNITS" value="USD">
<input type="hidden" name="STATUS_URL" value="https://topbonuss.tk/pmstsuc.php">
<input type="hidden" name="PAYMENT_URL" value="https://topbonuss.tk/success.php">
<input type="hidden" name="PAYMENT_URL_METHOD" value="GET">
<input type="hidden" name="NOPAYMENT_URL" value="https://topbonuss.tk/fail.php">
<input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">
<input type="hidden" name="SUGGESTED_MEMO" value="getsellmemo">
<input type="hidden" name="BAGGAGE_FIELDS" value="">
<input type="submit" class="btn btn-dark" name="PAYMENT_METHOD" value="Pay Now!">
</form>
---------------------------------->
<br><br>
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 80%;background: rgb(56, 51, 51);">
  <h4 class="text-warning">
    choose Investment BY : <b class="fa fa-dollar text-info"> </b>
  </h4>
  <div style="display: flex;flex-direction: row;width: 100%;">
    <div style="width:49%;justify-content: center;"><img src="pngs/pm.jpeg" class="invbypmbtn" style="width: 45%;margin-right:2%;border-radius: 15px;"> </div>
    <div style="width: 49%;justify-content: center;"><img src="pngs/payeerl.png" class="invbypbtn" style="width: 45%;margin-right: 2%;border-radius:15px;"> </div>
    </div>
    <br>

    <div class="invbypmdiv" style="border:none;border-left: 10px solid pink;">
      <h5 class="" style="color: crimson;float-left"> Invest By Perfect Money</h5>
      <i class="" style="color: pink;"> Minimum 1 $</i>


<form action="bypm.php" method="POST">

  
<input type="number" value="1" name="bypmamount" placeholder="Enter Amount in $" style="color: rgb(104, 2, 95); outline: none;border:none;border-bottom: 5px solid pink; text-align:center;" min="1">
  
  <center>
  <input type="submit" name="bypmbtn" class="btn btn-danger" value="P A Y" id="pmpsendbtn"></center>

</form>
    </div>
        
    <div class="invbypdiv" style="display: none; border:none;border-right: 10px solid aqua;">
      <h5 class="" style="color: aqua;float-left"> Invest By PAYEER</h5>

      <h5 style="color:skyblue;">your Balance auto added</h5><h6 style="background:#d9effa; border:2px solid green;">
        Go To <u><a href="https://payeer.com/ru/account/send/" target="_blank"> __PAYEER__ </a></u> ACCOUNT <a style="color:rgb(254,4,238);" href="https://payeer.com/ru/account/send/" target="_blank"> <input type="text" id="coypaccount" style="position:absolute;z-index:-4;" value="P1038065239"><b> __TRANSFER__ </b></a> The Amount  minimum ( 1 $ ) To this Payeer Account Number__ click<u><b style="letter-spacing:2px;color:rgb(244,3,229);"> <? echo $payeeracno; ?><input type="submit" onclick="copypacbtn()" style="color:brown;border:5px solid #d10795;" value="Copy" id="copypacbtn"> </b></u> Transfer amount must be in 
        DOLLARS. After the operation is completed, you will have access to <mark> Transaction ID </mark> ( numbers only) from the history section. Copy it and go back to our site, paste the transaction ID in the form, click "Check ID" if you have paid, minimum <mark>1 $ </mark> THEN your balance is automatically added to your account. ACCESS PAYMENTS easily without waiting.<u style="color:#fb5353;"> One ID one time after successful processing. </u></h6>
          <img src="pngs/payeer_trid.png" width="100%">

      <i class="" style="color: skyblue;"> Minimum 1 $</i>
     <form method="POST"><input type="number" name="pchtridinpt" placeholder="Enter Transaction ID" style="color: navy; outline: none;border:none;border-bottom: 5px solid skyblue; text-align:center;" required><br><br>
       <input type="submit" name="pchtridbtn" class="btn btn-primary" value="Check paid">
     </form><br>
    </div>


</div>

<br><br>
<div class="" style="border-radius: 20px;box-shadow: 2px 3px 30px navy,inset 1px 1px 8px red; width: 60%;background: rgb(56, 51, 51);">
  <h4 class="text-warning">
    <b class="text-success"> Instant</b> Withdrawals <b class="text-muted fa fa-arrow-right"> </b> <b class="fa fa-dollar text-info"> </b>
  </h4><br>
  <b class="text-danger">Minimum <i class="text-info">0.1 $ </i> can Withdrawals </b><br>
 <form method="POST">
  <input type="text" id="pminptfw" name="pwithdinpt" placeholder="Enter Amount in $" style="color: navy; outline: none;border:none;border-bottom: 5px solid orange; text-align:center;width:70%;" min="0.1" required><br><br>
  


    <button type="submit" class="float-start" name="withdbtnp" style="width:45%;border-radius:0 0 0 20%;box-shadow:1px 1px 16px blue; justify-content: center;"><img class="withdbtnp" src="pngs/payeerl.png" style="width: 45%;border-radius:15px;">
    </button>
  </form>
    <button id="pmbtnfw" class="float-end" style="width:45%;justify-content:center; box-shadow:1px 1px 16px red; border-radius:0 0 20% 0;"><img type="submit" src="pngs/pm.jpeg" style="width: 52%;border-radius: 15px;"> </button>
    <hr class="p-2 bg-secondary">
</div>


<br><br>
<? if(!$acstngf['usrk'] == 1){ ?>
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 80%;background: rgb(56, 51, 51);">
  <h5 class="text-light"> Go To Earning Dashboard </h5><br>
  <button class="btn btn-info godashbtn"> GO </button>
  
  <br><b class="godbtn" style="color:pink;"> without balance cannot access profit Dashboard</b>
</div>
<? } ?>


<br><br>
<div class="" style=""> 
<? if($acstngf['usrk'] == 1){ ?>
  <p class="" style="color: indigo;"><i class="fa fa-info text-info"> </i> Reffers any user you will get <b style="color: cornflowerblue;">30% </b> Bonus of your balance Back on every refferals <u style="color: rgb(0, 153, 13);"> Bonus UpTo :</u><b class="text-muted"> 200% To 500% </b> </p>
<? } ?>
  <h3 style="color: rgb(0, 99, 74);"> your refferals lists </h3>




 
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 80%;background: rgb(56, 51, 51);">
  
<br>
  <style type="text/css">
    .tftable {color:#333333;width:90%;border-width: 1px; text-align:center;border-color: #ebab3a;border-collapse:collapse;}
    .tftable th {font-size:1.5em;background-color:#1d281d;letter-spacing:1px;text-align:center; color:rgb(218, 202, 255);border:1px solid green;}
    .tftable tr {background-color:rgba(215, 237, 255, 0.94);}
    .tftable td {font-size:1em;border:1px solid green;}
    .tftable tr:hover {background-color:#d4fffbd5;}
    </style>
    
    <table class="tftable">
      <tr>
      <th> Name </th>
      <th> Invest </th>
      <th> Status </th>
      <th> Bonus </th>
      </tr>
<?
$useslog = $_SESSION['useslog'];
$vreftbl = mysqli_query($db,"SELECT * FROM reftbl WHERE whrmail='$useslog'");
while($vreftblf=mysqli_fetch_assoc($vreftbl)){
 ?>
 
      <tr class="tftable">
        <td> <? echo $vreftblf['mail']; ?> </td>
       <td> <? echo $vreftblf['invest']; ?>  </td>
       
       <? if($vreftblf['status']==1){ ?> <td class="fa fa-check text-success"> </td> <? } else { ?> <td class="fa fa-user-slash text-danger"> not paid <? } ?>
       
        <td><img src="pngs/bonusbox.png" style="width: 1.5em;"> 30 %</td>
      </tr>
      
<? } ?>
 
     </table>    
<br>

<? if($acstngf['refend'] >= 5){ ?>
<h3 style="color:pink"> <b class="fa fa-warning text-warning"> </b> You have last step of Bonus To Accept 200% </h3>
<p style="color:gold"> If You Invest More before this Then Last Invest Balance + new Balance is doubled and also collect bonus According To This </p>
<p style="color:pink"> After This Only New Balance Added </p>
<? } ?>
</div></div>


<br><br>
<? if($acstngf['usrk'] == 1){ ?>
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 60%;background: rgb(56, 51, 51);">
  <h5 class="text-muted"> Suggetion <img src="pngs/bonusbox.png" style="width: 1.5em;"></h5>
 <p class="text-white"> <b class="fa fa-info text-warning"> </b> start investment from <b class="text-info">1$</b> when you Agree To collect Extra Bonus + refferal bonus <b class="text-info"> 30% </b> To <b class="text-info">50% </b> and <b class="text-info"> 85% </b> per refferals bonus Then You Invest in others levels of bonuses </p>
 <img src="pngs/refchair.jpg" style="width: 80%;">
<hr class="p-1 bg-light">

<ul>
  <u class="text-light">On Every efferal Bonus</u>
  <li class="text-warning"> invest 1-5 $<b class="text-info"> 30% </b> Bonus </li>
  <li class="text-warning"> invest 5-7 $<b class="text-info"> 50% </b> Bonus </li>
  <li class="text-warning"> invest 7 $<b class="text-info"> 85% </b> Bonus </li>
</ul>
</div>
<? } ?>

<!--------------------------------->
<!----- start of hitory table ------->
<div class="" style="border-radius: 20px;box-shadow: 2px 2px 20px black; width: 80%;background: rgb(56, 51, 51);">
  
<br>
  <style type="text/css">
    .tftableh {color:#333333;width:90%;border-width: 1px; text-align:center;border-color: #ebab3a;border-collapse:collapse;}
    .tftableh th {font-size:1.5em;background-color:rgb(6,67,6);letter-spacing:1px;text-align:center; color:lime;border:1px solid green;}
    .tftableh tr {background-color:rgba(215, 237, 255, 0.94);}
    .tftableh td {font-size:1em;border:1px solid green;}
    .tftableh tr:hover {background-color:#d4fffbd5;}
    </style>
    <h3 style="color:gold"> All History </h3>
    <table class="tftableh">
      <tr>
      <th> Account </th>
      <th> Invest </th>
      <th> Withdraw </th>
      <th> Date </th>
      </tr>
    
<?
$useslog = $_SESSION['useslog'];
$vusumslst = mysqli_query($db,"SELECT * FROM usums WHERE whrmail='$useslog'");
while($vsumf=mysqli_fetch_assoc($vusumslst)){
 ?>
      <tr class="tftableh">
        <td><img src="<? echo $vsumf['accimg']; ?>" style="width:1.5em;">  <? echo $vsumf['uacc']; ?></td>
        <td style="color:navy;"> <? echo $vsumf['usum']; ?> </td>
        <td style="color:rgb(2,87,0);">  </td>
        <td> <? echo $vsumf['date']; ?> </td>
      </tr>
<? } ?>
<?
$useslog = $_SESSION['useslog'];
$vsumoutlst = mysqli_query($db,"SELECT * FROM usumout WHERE whrmail='$useslog'");
while($vsumoutf=mysqli_fetch_assoc($vsumoutlst)){
 ?>
      <tr class="tftableh">
        <td><img src="<? echo $vsumoutf['accimg']; ?>" style="width:1.5em;">  <? echo $vsumoutf['uacc']; ?></td>
        <td style="color:navy;"> </td>
        <td style="color:rgb(2,87,0);"><? echo $vsumoutf['sumout']; ?> </td>
        <td> <? echo $vsumoutf['date']; ?> </td>
      </tr>
<? } ?>

  
      </table>    
<br>
</div>
<!------ end of history table ------->
<!--------------------------------->



</center>













<div class="vidrwrdiv" style="display: none; position:sticky; z-index: 5; max-width: 20em; bottom: 100px;background: none; backdrop-filter: blur(10px);box-shadow: 1px 1px 10px silver;justify-content: center; border-left: 4px solid rgb(255, 97, 97);">
 <h5 class="text-success"> Paste Video Link</h5>
 <p class="text-dark"> Get Reward according to performance<b class="text-warning"> Max-3$</b></p>
 <i class="text-muted"> for full reward Minimum 1k Subcribers/followers</i><br>
 <input type="link" placeholder="Enter Video Links" class="ytlinks" style="color: rgb(148, 79, 0);background:#d9effa; border: none;outline: none;border-bottom: 5px solid pink;overflow: hidden; width:14em;text-align: center;margin-left: 2em;"><br><br>
 <button class="btn btn-danger ytlnkbtn" style="margin-left: 8em;"> send </button>
</div>

<div class="vidrwrdbtn" style="width: auto; max-width: 7.5em; position: sticky; bottom: 50px; z-index: 4;border-left:5px solid #ff6984;border-radius:0 25px 25px 0;box-shadow: 1px 1px 5px silver, -1px -1px 5px silver;">
 <img src="pngs/bonusbox.png" style="width: 2em;"> <b class="fa fa-play text-danger p-1" style="background:rgb(202, 240, 255);text-align: center; border-radius: 20px;box-shadow: 1px 1px 5px silver, -1px -1px 5px silver ; width: 2em; height: 2em; margin-left: 2.4em;"> </b>
</div>








<div id="copyright" style=" width:100%;aligh-item:center;box-shadow: -3px -3px 21px 3px silver,1px 1px 14px 1px navy; background:#2e0b55;">
  <center style="color:rgb(227, 210, 255);" ><a href="https://ordersite-ezyro.com/" target="_blank" style="text-decoration:none; color:silver;"><b style="color:pink;font-size:1.1em;"> Perfect Money </b> <b> | </b> <img style="width:7em;" src="pngs/payeer.png"> Copyright © 2022 All Rights Reserved <i class="fa fa-web"></i> </a> </center>
</div>



<!------- bootstrap.min.js -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
-->
<script src="js/jqoffline.js"></script>
<script>
    $(document).on('click','.str1',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','silver');
  $('.str3').css('color','silver');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
  $('.adedrstrs').html('added !').css('color','yellow');
});
$(document).on('click','.str2',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','silver');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
  $('.adedrstrs').html('added !').css('color','yellow');
 localStorage.setItem('strsvto','2',2);
});
$(document).on('click','.str3',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
  $('.adedrstrs').html('added !').css('color','yellow');
 localStorage.setItem('strsvto','3',3);
});
$(document).on('click','.str4',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','silver');
  $('.adedrstrs').html('added !').css('color','yellow');
 localStorage.setItem('strsvto','4',7);
});
$(document).on('click','.str5',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','lime');
  $('.adedrstrs').html('added !').css('color','yellow');
 localStorage.setItem('strsvto','5',7);
});

//////// for check stars users reviews
var chkstrcoki = localStorage.getItem("strsvto");
if(chkstrcoki == 2){
 $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','silver');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
}else if(chkstrcoki == 3){
 $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
}else if(chkstrcoki == 4){
 $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','silver');
}else if(chkstrcoki == 5){
 $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','lime');
}
// godashbtn for alert show
$(document).on('click','.godashbtn',function(){
   $("#successrs").fadeIn();
   $("#successrs").html(' √ Plz Invest First To Access Earning Dashboard <i class="text-muted"> or get back your cash if not interested</i>');
});
   // for p acount copy
   function copypacbtn()
  {
   alert(' PAYEER Account Number Is Copy ( read Next )');
    var selectto = document.getElementById("coypaccount");
    selectto.select();
    document.execCommand("copy");
   document.getElementById("copypacbtn").style.color = "blue";
   document.getElementById("copypacbtn").style.border = "10px solid #12f39e";
   document.getElementById("copypacbtn").innerHTML = "Copeid";
  } 
  // end payeer copy account for 
  // start for copy refferal link
  function copyrefbtn()
  {
   var selectto = document.getElementById("copyreflink");
    selectto.select();
    document.execCommand("copy");
   document.getElementById("copyrefbtn").style.color = "rgb(85,240,244)";
   document.getElementById("copyrefbtn").style.background = "rgb(2,54,56)";
   document.getElementById("copyrefbtn").style.border = "4px solid #12f39e";
   document.getElementById("copyrefbtn").innerHTML = "Ok Copy !";
  } 
  // end for copy refferal link
//////// for yt video toggle btn form
$(document).on('click','.vidrwrdbtn',function(){
  $('.vidrwrdiv').slideToggle();
});
//////// end for yt video t

//////// for inv by pmdiv
$(document).on('click','.invbypmbtn',function(){
  $('.invbypmdiv').show();
  $('.invbypdiv').hide();
});
//////// end of inv by pm div


//////// for inv by pdiv
$(document).on('click','.invbypbtn',function(){
  $('.invbypmdiv').hide();
  $('.invbypdiv').show();
});
//////// end of inv by p div

//////// for inv by whenewsdiv
$(document).on('click','.whenewsbtn',function(){
  $('.whenewsdiv').slideToggle(200);
});
//////// end of whenewsdiv
//////// for inv by whenewsdiv
$(document).on('click','.whenewsbtncros',function(){
  $('.whenewsdiv').hide(100);
});
//////// end of whenewsdiv
//////// start of ytlnkbtn     
$(document).on('click','.ytlnkbtn',function(){
 var ytlinks = $('.ytlinks').val();
  $.post(
       "jaxh.php",
      {ytlinksj:ytlinks},
      function(ytlinksf){
        if(ytlinksf == 1){
           var rdmytno = Math.floor((Math.random() * 700) + 200);
          $("#successrs").fadeIn();
          $("#successrs").html(' √  When admins See then Reward automatically in Your Account [ Reward no.'+ rdmytno +' ]');
          $('.ytlinks').val('thank You added');
        }else{
          $("#errors").fadeIn();
          $("#errors").html(' √ Something Went Rong !');
        }
      }
          ); //end post
  })

//////// end of ytlnkbtn 
//////// start of pminptfw     
$(document).on('click','#pmbtnfw',function(){
 var pminptfw = $('#pminptfw').val();
 if(pminptfw <= 0){
   $("#errors").fadeIn();
   $("#errors").html(' ! Minimum 0.1$ => wrong value ( ' + pminptfw +' )');
 }else{
  $.post(
      "jaxh.php",
      {pminptfwj:pminptfw},
      function(pminptf){
        if(pminptf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html(' √ Your Withdrawals of perfectmoney ==> ' + pminptfw+'$ is go to pending (this day manually) if by payeer then Instant');
        }else if(pminptf == 2){
          $("#successrs").fadeIn();
          $("#successrs").html(' √ Your Perfect Money ==> ' + pminptfw+'$ Withdrawals SUCCESSFULLY');
        }else if(pminptf == 3){
          $("#errors").fadeIn();
          $("#errors").html(' ! You Enter higher Amount thats You Not have => '+ pminptfw+'$');
        }else if(pminptf == 4){
          $("#errors").fadeIn();
          $("#errors").html(' ! your Account open errors from PERFECT MONEY');
        }else if(pminptf == 5){
          $("#errors").fadeIn();
          $("#errors").html(' ! Need 1 paid Refferals Balance automatically in your wallets');
        }else{
          $("#errors").fadeIn();
          $("#errors").html(' √ Something Went Rong !');
        }
      }
          ); //end post
     }
  })

//////// end of pminptfw 
//////// start of rststngbtn     
$(document).on('click','.rststngbtn',function(){
 var rstmail = $('.rstmail').val();
 var rstpm = $('.rstpm').val();
 var rstp = $('.rstp').val();

  $.post(
      "jaxh.php",
      {rstmailj:rstmail,rstpmj:rstpm, rstpj:rstp},
      function(rststngf){
        if(rststngf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html(' √  SUCCESSFULLY Reset Your Setting (Refresh)');
        }else if(rststngf == 3){
          $("#errors").fadeIn();
          $("#errors").html('x This Email Can Not Be Accept !');
        }else if(rststngf == 4){
          $("#errors").fadeIn();
          $("#errors").html(' Without Invest Your data Cannot be changed !');
        }else{
          $("#errors").fadeIn();
          $("#errors").html(' √  Something Went Rong !');
        }
      }
          ); //end post
  })

//////// end of rststngbtn 
/////////////////////////////////////
//////// start of invstback     
$(document).on('click','.invstbackbtn',function(){

  $.post(
      "jaxh.php",
      {invbackj:'hshxmrs'},
      function(invbackjf){
        if(invbackjf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html(' √ Go To inbox And put Your Id with reason');
        }else{
          $("#errors").fadeIn();
          $("#errors").html(' √  You Not Invest Any Amount !');
        }
      }
          ); //end post
  })

//////// end of rststngbtn 
/////////////////////////////////////
  $(document).on('click','.notifycross',function(){
      $('#errors').hide(100);
      $('#successrs').hide(100);
    })
//////////////////////////////////
/////////////////////////////////////
  $(document).on('click','.rststngbtnav',function(){
      $('.rststngdiv').slideToggle();
    })
//////////////////////////////////
/////////////////////////////////////
  $(document).on('click','.rststngcros',function(){
      $('.rststngdiv').hide();
    })
//////////////////////////////////



</script>
</body>
</html>



