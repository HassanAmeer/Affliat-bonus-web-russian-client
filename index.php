<?php

include 'config.php';
session_start();
 error_reporting(0);

if(isset($_SESSION['useslog']))
 { header('location:home.php');
}elseif(isset($_COOKIE['sescoki'])) {
  header('location:home.php'); }

////////////// start signup
if(isset($_POST['loginbtn']))
{
  $mail = mysqli_real_escape_string($db,$_POST['email']);
  $password = mysqli_real_escape_string($db,$_POST['password']);
 
$upasssha1 = sha1($password);
$upassmd = md5($upasssha1);

$ulogin = "SELECT umail, upas FROM allurefs WHERE umail='$mail' AND upas='$upassmd'";
$loginqry = mysqli_query($db,$ulogin);
if(mysqli_num_rows($loginqry) == 1)
  { 
   $strtdate=strtotime("now");
   $setdate = date("Y-m-d",$strtdate);
   $setthisip =$_SERVER['REMOTE_ADDR'];
  $setlogs = "UPDATE allurefs SET logindate='$setdate', ip='$setthisip' WHERE umail='$mail'";
  $setlogsq=mysqli_query($db,$setlogs); 
  
    $_SESSION['useslog'] = $mail;
    header('location:home.php');
  }else{
    echo '<div class="alert alert-danger" role="alert">  Incorrect Login Data !</div>'; 
  }
}
////////////////////////



if(isset($_GET['referid']))
{ $_SESSION['refbyses']=$_GET['referid']; }

/////////////////////////////////
/**********************************/
$navlds = " SELECT COUNT(uid) AS cuid FROM usums";
$navldq = mysqli_query($db,$navlds);
$navld = mysqli_fetch_assoc($navldq);
///// end of count total users
$chkstng = "SELECT * FROM `allstng` WHERE stngid=1";
 $chkstngq = mysqli_query($db,$chkstng);
$chkstngv = mysqli_fetch_assoc($chkstngq);
///////////////
$navtsum = " SELECT SUM(usum) AS usumbal FROM usums";
$navtsq = mysqli_query($db,$navtsum);
$scrubles = mysqli_fetch_assoc($navtsq);
///// start count total sums
$navtsumout = "SELECT SUM(sumout) AS sumoutw FROM usumout";
$navtsumoutq=mysqli_query($db,$navtsumout);
$sumoutv=mysqli_fetch_assoc($navtsumoutq);
///// start count total Withdraw


     

       
  

       

?>




















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.4">
    <link rel="shortcut icon" href="pngs/bonustrade.png" type="image/x-icon">
    <title> PUMAZEK Great </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/fontawesome.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="pngs/bonustrade.png" type="image/x-icon">
</head>
<body>
    
    
 <? if($chkstngv['fildowbtn'] == 0){ ?>
  <br><center>
      <a href="/sells/index.php" style="font-size:2em;" class="fa fa-download btn btn-dark"> скачать это / Download </a>
    </center><br>
 <? } ?>
     
     
     
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
           <img src="pngs/bonustrade.png" style="width: 2em;"> <?  echo $chkstngv['sitetitle']; ?>  </h4>
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
                color:silver;
            }
        </style>
        
        <div class="float-end" style="background: rgb(57, 57, 66);display: flex;flex-direction: row;width: 26%;border-radius: 10px;"> 
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
        .hmenus button{
           margin-left: 1em; font-size: 1em;
            }
        .phpstrs{ color: lime; }
        </style>
        <center>
         <div class="hmenus" style="display: flex;flex-direction: row;width: 70%; background: none;justify-content: center;">
         
          <a href="/" class="btn btn-warning"> HOME </a>
          <button class="btn btn-warning aboutpbtn"> ABOUT </button>
          <a href="contact.php" class="btn btn-warning" style="margin-left:1em;"> CHAT US </a> 
          <button class="btn btn-success loginbtnav"> LOGIN </button>
          <button class="btn btn-warning signupbtnav"> SIGN UP </button>
         </div>
        </center>
<!------- end of top div -->
<!----------------------------------------------------------------------------->

<div style="width: 100%;display: flex;flex-direction: row;">

<!------- stat of left div -->
<div style="width: 22%;border: 2px solid blue;justify-content: center;">
    <style>
 .sumtbl th{
    border:  1px solid navy; box-shadow: 1px 1px 3px black , inset 1px 1px 30px aqua;
 }
 .sumtbltd{

 }
 .sumdolr{
     background: navy;color: aqua;box-shadow: 1px 1px 5px rgb(52, 91, 165),-1px -2px 4px silver,inset 1px 1px 3px silver;
 }
 .sumarowgif
 {
     animation: sumarowgif 2s linear infinite;
 }
  @keyframes sumarowgif{
     to{color:navy;}
     from{color:aqua;}
 }

    </style>
   <center> <h4 style="color: aqua; background: navy;"> TOP 20 SUM </h4>
    <table>
            <tr  class="sumtbl">
                <th>USERS</th>
                <th class="text-primary" style="color: rgb(55, 10, 25e5);display: flex;flex-direction: row;"> SUM<mark class="sumarowgif fa fa-arrow-down"></mark></th>
                <th>DATE</th>
            </tr>
        <tbody class="vsumslst">
            
        </tbody>
    </table>
    </center>
</div>
<!------- stat of left div -->


<!------- stat of mid div -->
<div style="width: 56%;border: 2px solid rgb(243, 4, 183);">

 <!---------------------------------->
 <div id="errors" class="alert notifycross" style="display:none;background:rgb(114,0,0); color:#fe839c; border-radius:20px; border:1px solid #ff6e6ede; box-shadow:2px 2px 14px 2px black;font-size:0.6em;" role="alert">
   </div>
 <!---------------------------------->
 <!---------------------------------->
 <div id="successrs"class="alert notifycross" style="background:rgb(0,75,0); display:none;color:lime;border-radius:20px; border:1px solid #00e300;font-size:0.6em; box-shadow:2px 2px 14px 2px black;" role="alert">
</div>
 <!---------------------------------->
 <!---------------------------------->
 <div class="aboutpdiv" style="display:none;">
<h4 class="text-dark"> ABOUT This</h4>
<p>
    this project is stand for bussiness communicate services company
    every one can earn much money garrented only thats users invest

</p>
<br>
<b> investment (NO RISK) </b>
<p>
 any users can invest from 1$ to 100$ only and earn money from 200% to 500% garrented
 ( risk free )
</p>
<br>
<b> payment Accept </b>
<p>
 we Accept payments in DOLLARS from 2 types of wallets
 1.( PAYEER ) 2.(PERFECT MONEY)
</p>

<br>
<b> IF RETURN BACK PAYMENTS </b>
<p>
  you can return back your payments when you invest and after this not accept to bonus
</p>


<br>
<b> any problems </b>
<p>
  you can contact with us feel free if You face any problems  
 </div>
 
 
 
 <!---------------------------------->

    <style>
        .loginmp{
         width: 80%;  text-align: center; border: none;border-bottom: 2px solid green;outline: none; background:rgb(225, 255, 239); color: green;
        }
        #loginbtn:active{background:black;color:lime; font-style:italic;}
        #loginbtn{
            color: green; background: rgb(187, 255, 235); font: 2em; text-align: center; border: 2px solid green; border-radius: 0 15px 15px 0;outline: none;
        }

        .signupmppmp{
         width: 80%;  text-align: center; border: none;border-bottom: 2px solid blue;outline: none; background:rgb(207, 239, 247); color: blue;
        }
        #signupbtn{
            color: blue; background: rgba(165,202,245,0.825); font: 2em; text-align: center; border: 2px solid blue; border-radius: 0 15px 15px 0;outline: none;
        }
        #stdatev{
          animation: stdatev 4s infinite alternate-reverse; background: none;
         color:indigo; font-size:1em; text-shadow: 1px 1px 1px orange;letter-spacing:5px; 
        }
       @keyframes stdatev{
         30%{
           color: white; background: none;
         }
         70%{
           color: orange; background: none;
         }
         90%{
           color: navy; text-shadow: 2px 2px 2px blue; background:rgb(215,227,215);box-shadow: 2px 2px 8px black;
         }
       }
    </style>
    <center>
    <div class="loginform" style="display: none;">
      <h5 class="text-success">USER LOGIN</h5>
       <form method="POST" class="loginf">
           <input type="email" name="email" class="loginmp" placeholder="Enter emails " value="@gmail.com" required><br><br>
           <input type="password" name="password" class="loginmp" placeholder="Enter Password" required><br><br>
           <input type="submit" value="LOG IN" name="loginbtn" id="loginbtn">
       </form>    <br>
    </div>

    <div class="signupform" style="display: none;">
        <h5 class="text-primary">USER SIGNUP</h5>
       
             <input type="email" name="" id="useremail" class="signupmppmp" placeholder="Enter emails " value="@gmail.com" required><br><br>
             <input type="password" name="" id="userpassword" class="signupmppmp" placeholder="Enter Password" required><br><br>

             <input type="text" name="" id="userpayeer" class="signupmppmp" placeholder="Payeer"><br>OR<br>
             <input type="text" name="" id="userpm" class="signupmppmp" placeholder="Perfect Money Account"><br><br>
             <input type="submit" value="Sign Up" name="" id="signupbtn">
        <br><br>
      </div>

      <div class="midindigo" style="background:indigo; box-shadow:0 1px 10px black;">
        <img src="pngs/dolarwal.gif">
         <u class="text-warning">Reward Garunted <b class="fa fa-gift"> </b></u>
         <h4 class="text-light"> Earn Upto 200% To 500% </h4>
        <h5 class="text-warning"> Cash Back ? <b class="text-info"> Yes</b></h5>
        <hr class="p-1 bg-light" style="box-shadow: 1px 1px 6px silver, -1px -1px 6px silver;">
      <i class="text-light"> Minimum Investment </i><b class="text-info"> 1 $</b><br>
      <i class="text-light"> Maximum Investment </i><b class="text-info"> 100 $</b><br>
      <i class="text-light"> Minimum Bonus </i><b style="color: lime";> 200% </b><br>
      <i class="text-light"> Maximum Bonus </i><b style="color: lime;"> 500% </b><br>
      <i class="text-light"> Minimum Withdrawals </i><b style="color: gold;"> 0.1 $ </b><b class="text-muted"> Instant </b><b class="fa fa-check text-info"> </b><br>
      <i class="text-light"> Per Refferal </i><b style="color: gold;"> 30 % </b><b class="text-light fa fa-users"> </b><b class="fa fa-bonus text-info"> </b><br>
      <h1 style="text-shadow: 1px 1px 4px lime;" class="text-light"> We Accept </h1>
      <div style="display: flex;flex-direction: row;">
    <div ><img src="pngs/pm.jpeg" style="width: 45%;margin-right:2%;border-radius: 15px;"> </div>
    <div ><img src="pngs/payeerl.png" style="width: 45%;margin-right: 2%;border-radius:15px;"> </div>
    </div>
<br>
<div class="" style="width: 30%;">
<img src="pngs/top85.png" style="width: 100%;">
<h4 style="color: rgb(212, 151, 255);text-shadow: 1px 1px 1px rgb(43, 255, 0);"> Bonus  upTo 200% to 500% </h4>
</div>

<hr class="p-2" style="background:rgb(3, 255, 158);box-shadow: inset 1px 1px 3px rgb(61, 0, 105),inset -1px -1px 3px rgb(54, 0, 92);">
<button class="btn btn-success loginbtnav"> LOGIN </button>
<button class="btn btn-warning signupbtnav"> SIGN UP </button>
    </div>
    </center>
 <center>
   <h3 class="text-primary"> Project Started </h3>
   <b id="stdatev"> <? echo $chkstngv['strdate']; ?> </b>
 </center>
</div>

<!------- stat of mid div -->



<!------- stat of right div -->
<div style="width: 22%;border: 2px solid rgb(21, 184, 0);">
    <style>
        .sumoutbl th{
           font-size: ; border:  1px solid rgb(2, 46, 0); box-shadow: 1px 1px 3px black , inset 1px 1px 30px rgba(9, 255, 152, 0.767);
        }
.sumoutarowgif
 {
     animation: sumoutargif 2s infinite alternate-reverse;
 }
  @keyframes sumoutargif{
     to{color:rgb(7, 73, 1);}
     from{color:lime;}
 }
        .sumdoutdlr{
            background: rgb(2, 46, 0);color: lime;box-shadow: 1px 1px 5px green,-1px -2px 4px silver,inset 1px 1px 3px silver;
        }
           </style>
          <center> <h5 style="color: lime; background: rgb(2, 46, 0);"> TOP 20 Withdrawals </h5>
           <table>
                   <tr  class="sumoutbl">
                       <th>USERS</th>
                       <th class="text-success" style="color: rgb(0, 58, 0);display: flex;flex-direction: row;"> OUT<mark class="sumoutarowgif fa fa-arrow-up"></mark></th>
               
                       <th>DATE</th>
                   </tr>
             <tbody class="vsumoutlst">
               
               
             </tbody>      
           </table>
           </center>
</div>
<!------- stat of right div -->
                      


</div>
<!-------end of flex div -------------------------------->
<!----------------------------------------------------------------------------->
<br>

<!---------- start of banners div -->
<center>   
<h4 style="color:orange"> advertising here </h4>
   <div id="linkslot_340864"><script src="https://linkslot.ru/bancode.php?id=340864" async></script></div>
      
    
<br>
     
  <div id="linkslot_340865"><script src="https://linkslot.ru/bancode.php?id=340865" async></script></div>

</center>
<!----------------------------------------------------------------------------->
<!---------- end of banners div -->

<a href="contact.php" style="position:sticky;right: 0;top: 10;" class="btn btn-dark fa fa-chats"> chats </a>
<!----------------------------------------------------------------------------->
<center><img src="pngs/ssl.png" style="width:100%;">
</center>
<!---------- end of chat btns div -->
<div id="copyright" style=" width:100%;aligh-item:center;box-shadow: -3px -3px 21px 3px silver,1px 1px 14px 1px navy; background:#2e0b55;">
    <center style="color:rgb(227, 210, 255);" ><a href="https://ordersite-ezyro.com/" target="_blank" style="text-decoration:none; color:silver;"><b style="color:pink;font-size:1.1em;"> Perfect Money </b> <b> | </b> <img style="width:5em;" src="pngs/payeer.png"> Copyright © 2022 All Rights Reserved <i class="fa fa-web"></i> </a> </center>
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
  $('.adedrstrs').html(' LogIn !').css('color','yellow');
});
$(document).on('click','.str2',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','silver');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
  $('.adedrstrs').html(' LogIn !').css('color','yellow');
});
$(document).on('click','.str3',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','silver');
  $('.str5').css('color','silver');
  $('.adedrstrs').html(' LogIn !').css('color','yellow');
});
$(document).on('click','.str4',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','silver');
  $('.adedrstrs').html(' LogIn !').css('color','yellow');
});
$(document).on('click','.str5',function(){
  $('.str1').css('color','lime');
  $('.str2').css('color','lime');
  $('.str3').css('color','lime');
  $('.str4').css('color','lime');
  $('.str5').css('color','lime');
  $('.adedrstrs').html(' LogIn !').css('color','yellow');
});
//////// for login and signup div show
$(document).on('click','.loginbtnav',function(){
    $('.loginform').show();
  $('.signupform').hide();
});

$(document).on('click','.signupbtnav',function(){
  $('.loginform').hide();
  $('.signupform').show();
});
///////////////////////

$(document).on('click','.aboutpbtn',function(){
  $('.aboutpdiv').slideToggle();
  $('.midindigo').slideToggle();
});
///////////////////////




////////////// for signup ///////////
$(document).on('click','#signupbtn',function(){
 var userpayeer = $('#userpayeer').val();
 var userpm = $('#userpm').val();
 var useremail = $('#useremail').val();
 var userpas = $('#userpassword').val();

  setTimeout(function(){
  $('#signupbtn').attr("value", "Sign Up");
  $('#signupbtn').css('color','blue');
  }, 1500);

$('#signupbtn').css('color','#ae0000').attr("value", " Wait For Scaning ");

 if(useremail=="" ||  userpas==""){
   $('#errors').fadeIn(); 
    $('#errors').html(' × All feilds are Required <i style="color:silver;"> click To hide</i>'); }else{

   $.post(
      "jax1.php",
      {usrpacj:userpayeer,usrpmj:userpm, usremailj:useremail, usrpasj:userpas},
      function(register){
        if(register == 1){
          $("#successrs").fadeIn();
          $("#successrs").html(' √  SUCCESSFULLY Registerd You Can Login <i style="color:silver;"> click To hide</i');
         $('#userpayeer').val("");
         $('#userpm').val("");
          $('#useremail').val("");
          $('#userpassword').val("");
        } else if(register == 2){
          $("#errors").fadeIn();
          $("#errors").html(' √ This account Already Registerd ! <i style="color:silver;"> click To hide</i');
        }
        
        
      }
          ); //end post
    }
  })
//////////////////////////////////
/////////////////////////////////////
  $(document).on('click','.notifycross',function(){
      $('#errors').hide(100);
      $('#successrs').hide(100);
    })
//////////////////////////////////
function gensumtbl(){ 
   $.post(
      "jax1.php",
      {gensumsj:'gensums'},
      function(vsumlstf){
         sumtblv(); }
      );
}    
setInterval(gensumtbl,11000);  
//////////////////////////////////
function sumtblv(){ 
   $.post(
      "jax1.php",
      {gensumsvj:'gensumsv'},
      function(vsumlstvf){
       $(".vsumslst").html(vsumlstvf); }
      );
}                                      
///////////////end of sums tbls
//////////////// start of wbal tbls
function gensoutbl(){ 
   $.post(
      "jax1.php",
      {gensoutblj:'gensoutbl'},
      function(gensoutblf){
         gensoutblv(); }
      );
}    
setInterval(gensoutbl,7000);  
////////
function gensoutblv(){ 
   $.post(
      "jax1.php",
      {gensoutblvj:'gensoutblv'},
      function(gensoutblvf){
     $(".vsumoutlst").html(gensoutblvf); }
      );
}                                      
//////////////// end of wbal tbls
	window.onload = sumtblv();
	window.onload = gensoutblv();
 </script>
</body>
</html>
