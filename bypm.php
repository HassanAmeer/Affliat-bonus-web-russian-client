<?php
session_start();
include "config.php";
 error_reporting(0);

if(isset($_SESSION['useslog']))
{ $useslog = $_SESSION['useslog']; 
}elseif(isset($_COOKIE['sescoki'])) {
  $useslog = $_COOKIE['sescoki'];
  $_SESSION['useslog'] = $useslog;
}


if(isset($_POST['bypmbtn']))
{
  $pmusd = mysqli_real_escape_string($db, $_POST['bypmamount']);
  $payid = time() + 786143;
  $payidshow = $payid;
if(isset($_SESSION['useslog'])){
 $useslogcoki = $_SESSION['useslog'];
 setcookie('sescoki',$useslogcoki,time() + 60*60*1); } // set for 1 hours

setcookie('pmpayid',$payid,time() + 60*60*1);
 
}






?>
<body style="background:#00805e">
<center>
<div style="width:90%;background:rgb(0,158,116);box-shadow:4px 4px 20px black; border-radius: 22px ; margin-top:20%;">
  <circle style="border-radius:50%; box-shadow: 1px 1px 1px black, inset 1px 1px 3px black; width:2em; height:2em; background:#00805e; position:absolute; left:55; border:2px solid lime;">   </circle>
  <h1 style="color:aqua;text-shadow:3px 3px 3px black;letter-spacing:5px; "> Payment Confirm </h1><br>
  
  <div style="border-radius:10px ;width:80%;">
    <div style="width:100%; border:1px solid silver; border-radius:5px; box-shadow:1px 1px 10px black; background:rgb(237,240,222);">
      <u style="color:green;font-size:1.5em;"> Amounts in <i style="color:blue;"> $</i> </u><br>
      <b style="color:rgb(1,133,0); font-size:3em;"> <? echo $pmusd; ?> </b>
    </div><br><br>
    <div style="width:100%; border:1px solid silver; border-radius:10px; box-shadow:1px 1px 10px black; background:#dae8e8;">
      <u style="color:blue;font-size:1.5em;"> Pay ID </u><br>
      <b style="color:blue; font-size:3em;"> <i style="color:navy;"># </i> <? echo $payidshow; ?> </b>
    </div>
    <br><br>
    <div style="width:100%; border:1px solid silver; border-radius:5px; box-shadow:1px 1px 10px black; background:#dae8e8;">
      <u style="color:red;font-size:1.5em;"> B y </u><br>
     <b style="color:red; font-size:3em; letter-spacing:2px;"> Perfect-Money</b>
    </div>
  </div>
  <br><br><br><br>
  
<form action="https://perfectmoney.com/api/step1.asp" method="POST">
<input type="hidden" name="PAYEE_ACCOUNT" value="<? echo $yourpmacc_no; ?>">
<input type="hidden" name="PAYEE_NAME" value="<? echo $mycompany_msg; ?>">
<input type="hidden" name="PAYMENT_ID" value="<? echo $payidshow; ?>">

<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $pmusd ; ?>">
<input type="hidden" name="PAYMENT_UNITS" value="USD">

<input type="hidden" name="STATUS_URL" value="<? echo $status_url; ?>">
<input type="hidden" name="PAYMENT_URL" value="<? echo $success_url; ?>">
<input type="hidden" name="NOPAYMENT_URL" value="<? echo $fail_url; ?>">


  
<input type="hidden" name="SUGGESTED_MEMO" value="">
<input type="hidden" name="BAGGAGE_FIELDS" value="">


  <center>
  <input type="submit" name="PAYMENT_METHOD" style="color:pink; background:rgb(101,5,25); font-size:4em; width:100%; box-shadow:-1px -1px 35px black; border-radius:40px 40px 0 0" value=" Confirm P A Y √"></center>

</form>
  
  


  
  
  
</div>
</center>
</body>
<!---------------------------------------------
<form action="https://perfectmoney.com/api/step1.asp" method="POST">
<input type="hidden" name="PAYEE_ACCOUNT" value="<? $yourpmacc_no; ?>">
<input type="hidden" name="PAYEE_NAME" value="<? $mycompany_msg; ?>">
<input type="hidden" name="PAYMENT_ID" value="<? $payidshow; ?>">

<input type="hidden" name="PAYMENT_AMOUNT" value="<? $pmusd ; ?>">
<input type="hidden" name="PAYMENT_UNITS" value="USD">

<input type="hidden" name="STATUS_URL" value="<? $status_url; ?>">
<input type="hidden" name="PAYMENT_URL" value="<? $success_url; ?>">
<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
<input type="hidden" name="NOPAYMENT_URL" value="<? $fail_url; ?>">
<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">

  
<input type="hidden" name="SUGGESTED_MEMO" value="buy deposit">
<input type="hidden" name="BAGGAGE_FIELDS" value="786786">


  <center>
  <input type="submit" name="PAYMENT_METHOD" style="color:pink; background:rgb(101,5,25); font-size:4em; width:100%; box-shadow:-1px -1px 35px black; border-radius:40px 40px 0 0" value=" Confirm P A Y √"></center>

</form>
 --------------------------------------------->















