<?php

include 'config.php';
session_start();
// error_reporting(0);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.4">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title> u reffers </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="fontawesomecss">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/h.css">
    <link rel="shortcut icon" href="pngs/bonustrade.png" type="image/x-icon">
</head>
<style>
    .redlightblink{
      border-radius: 20px;
      min-height: 29px;min-width: 30px;
      max-height: 29px; max-width: 30px;
      border: 2px solid black; font-size: 20px;
       box-shadow: 1px 1px 4px 2px black;
       animation: lightblink 1s infinite alternate-reverse;
     }
     @keyframes lightblink {
       50%{ color:green; background: none;}
      100%{ color:black; background:none; border:2px solid green;box-shadow:2px 2px 8px black;}
     }
</style>
<body>

<div class="bg-dark" style="display: flex;flex-direction:row;">
  
   <button class="fa fa-arrow-left text-light backbtn" onclick="backbtnf()" style="background: none;border: none;font-size:2em;"> </button>
    <div style="margin-left: 2em;"><img src="pngs/admin.png" style="width:3em; height:3em; border-radius:50%;border:3px solid green;"></div>
      
    <div style="margin-top: 0.7em;margin-left: 1.5em;"><b class="text-muted"> TO: </b><b class="text-light"> ADMIN </b><i style="color: silver;"> lukasin </i></div>
   
   <div style="margin-left:2em;margin-top:0.7em">
    <center><h1 class="redlightblink"> • </h1></center></div>
        
      
</div>
<center>
  <? if(!isset($_SESSION['useslog']))
{ ?>
    <h6 class="text-danger" style="border-radius: 10px;border-top:none;border: 1px solid red;width: 30%;"> Please Login First </h6>
<? } ?>
    <h6 class="text-success" style="border-radius: 10px;border-top:none;border: 1px solid green;width: 30%;"> <? if(isset($_SESSION['useslog']))
{ echo $_SESSION['useslog'];} ?></h6>
</center>

 <!---------------------------------->
 <div id="errors" class="alert notifycross" style="display:none;background:rgba(114,0,0,0.128); color:red; border-radius:20px; border:1px solid #ff6e6ede; box-shadow:2px 2px 14px 2px black;font-size:0.8em;" role="alert">
   </div>
 <!---------------------------------->
 <!---------------------------------->
 <div id="successrs"class="alert notifycross" style="background:rgba(0,75,0,0.105); display:none;color:green;border-radius:20px; border:1px solid #00e300;font-size:0.8em; box-shadow:2px 2px 14px 2px black;" role="alert">
</div>
 <!---------------------------------->
 <!---------------------------------->


<style>
#vchats{
    width: 100%; height: 90em;
    overflow-x: hidden; 
    overflow-y: auto;box-shadow:inset 0px 0px 10px navy;
}
@media only screen and (max-width: 500px){
  #vchats{
    height: 40em;
  } }
@media only screen and (min-width: 500px){
  #vchats{
    height: 90em;
  }
}
</style>
<!---- start for chats lists-->

<div id="vchats" style="">
  
</div>
<p class="text-warning"> Scrolled </p>

<!---- end of chats lists-->



<!---- start of text messages and button -->
<div style="display: flex;flex-direction: row; width: 100%; position: absolute;bottom: 0;justify-content: center;">
     <input type="text" placeholder=" Need help" id="usrsmsgs" style="border-radius: 10px;border: none; border-bottom:4px solid rgb(1, 197, 1);outline: none; background: rgb(200, 223, 253);color: green;min-width:70%;font-size:3em">
     <button type="submit" id="msgsbtn" class="fa fa-paper-plane" style="color:lime;background: none;border: none;outline: none; font-size: 4em;"> </button>
     
</div>
<!---- start of text messages and button -->
<script src="js/jqoffline.js"></script>
<script>
    function backbtnf(){
        window.history.back();
    }
    
////////////
////////////
 $(document).on('click','#msgsbtn',function(){
   var msgvalue = $('#usrsmsgs').val();
    if(msgvalue == ''){ 
      $('#errors').fadeIn();
      $("#errors").html(' × write some text ');
    }else{ $.post(
      "jaxh.php",
      {msgvaluj:msgvalue},
       function(chats){
       if(chats == 1){
     $('#vchats').scrollTop($('#vchats').prop('scrollHeight'));
          $("#successrs").fadeIn();
          $("#successrs").html(' √ ' + msgvalue);
         $('#chatsinput').val("");
         $('#usrsmsgs').val("");
          chatbotf();
        }else if(chats == 0){
        $('#vchats').scrollTop($('#vchats')[0].scrollHeight);
          $('#errors').fadeIn();
          $("#errors").html(' × SomeThing Wrong chatbot');
      }  }); } // end post
  })
///////// 
    
///////// 
function chatbotf(){
    $.post(
      "jaxh.php",
      {chatbotload:'chatbot'},
      function(chatbotf){
      $("#vchats").html(chatbotf);
    }); // end post
}    
///////
function chatdown(){
$('#vchats').scrollTop($('#vchats').prop('scrollHeight'));
}
/////////////////////////////////////
  $(document).on('click','.notifycross',function(){
      $('#errors').hide(100);
      $('#successrs').hide(100);
    })
//////////////////////////////////
/////////////////////////////////////
window.onload = chatbotf();
window.onload = chatdown();
</script>
</body>
</html>