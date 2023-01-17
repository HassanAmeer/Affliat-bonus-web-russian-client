
<?


include '../config.php';
session_start();
//  error_reporting(0);


if(!isset($_SESSION['gohome']))
{
  header('location:../index.php');
}
////////////////////////////////////////
if(isset($_POST['logout']))
{
  unset($_SESSION['gohome']);
  header('location:../index.php');
}





/**********************************/
$chkstng = "SELECT * FROM `allstng` WHERE stngid=1";
 $chkstngq = mysqli_query($db,$chkstng);
$chkstngv = mysqli_fetch_assoc($chkstngq);
///////////////
$navlds = " SELECT COUNT(uid) AS ctid FROM usums";
$navldq = mysqli_query($db,$navlds);
$navld = mysqli_fetch_assoc($navldq);
///// end of count total users
$navtsum = " SELECT SUM(usum) AS scrubles FROM usums";
$navtsq = mysqli_query($db,$navtsum);
$scrubles = mysqli_fetch_assoc($navtsq);
///// start count total sums
$navtsumout = " SELECT SUM(sumout) AS wcrubles FROM usumout";
$navtsumoutq=mysqli_query($db,$navtsumout);
$sumoutv=mysqli_fetch_assoc($navtsumoutq);
///// start count total Withdraw










?>



<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <!-- for awsome fonts -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="../css/fontawesome.css">
    <title>admin</title>
<style>
      /* for table golden star and silver */
      
      
 table.edTable { width: 100%; font: 17px calibri; } table, table.edTable th, table.edTable td { border: solid px #9b58b5; border-collapse: collapse; padding: 3px; text-align: center; } table.edTable td { background-color: #5c0e80; color: #ffffff; font-size: 14px; } table.edTable th { background-color : #b02875; color: #ffffff; } tr:hover td { background-color:navy; color: #dddddd; }
 
      
/*  own */
.silTable{
  width: 100%;

  
}
.sthead{
  background: silver;
  border:2px solid gray;
  border-radius: 10%;
  box-shadow: 2px 3px 14px 2px black;
}
.sthead th{
  color:green;
  font-size: 1em;
}
.gthead{
  background:rgb(203,149,6);
  border:2px solid gray;
  border-radius: 10%;
  box-shadow: 2px 3px 14px 2px black;
}
.gthead th{
  color:indigo;
  font-size: 1em;
}
.strowdata td{
  font-size: 0.8em;
  
}
.strowdata:hover { letter-spacing:1px; }
.strowdata:hover td i{ color:#05cecd; }
.strowdata td i{
  width: 1em;
  color:indigo;
}
/* end of golden star table */
#listtable{
    width: 100%;
    height: 80%;
    overflow-x: auto; 
    overflow-y: auto; 
    height: 40em;
 }      
</style>
  </head>
  
  <body class="bg" style="background:rgb(216,231,219)">
    
    
  <!------ menu side bar -->
<button class="btn btn-primary" style="position:sticky; z-index:100; top:10px; left:10px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> Menu </button>


<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Admin Panel</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <form method="post">
  <input type="submit" name="logout" style="color:red; background:gold; font-style:italic; border-radius:25px; border: 2px solid red;" value="LogOut">
  </form>
  <div class="offcanvas-body">
    
  <p> Your ip adress is tracked used This Panel carefuly !</p>
      <br>
      <button class="btn btn-warning visitorbtn"> Visitor Setting</button>
      <button class="btn btn-success setdatesbtn"> start dates</button>
     <button class="btn btn-danger fkdepositebtn"> fk deposite </button>
      <br></br>
      <button class="btn btn-dark newsmsgbtn"> news msg  </button>
      <button class="btn btn-primary settingbtn"> Settings </button>
      <button class="btn btn-secondary listsbtn"> lists </button>
      <br></br>
      <button class="btn btn-primary chatbtn"> Chats </button>
      <button class="btn btn-dark ytvidivbtn"> YT rewards </button>
      
     <button class="btn btn-danger mailsndbtn"> send Emails </button><br></br>
     <button class="btn btn-success vpmfwtblbtn"> PM_Request </button>
      <button class="btn btn-danger resetbtnin" style="display:none;"> reset every thing  </button>
      <br></br><br></br>
      <button class="btn btn-danger resetbtnok" style="display:none;"> Every things reset </button>
  </div>
  <button class="btn btn-danger resetbtn"> reset game</button>
</div>
<!------ end of sidebar menu -------->

<div id="errors" class="alert notifycross" style="display:none;background:#fdb0b0f0; color:red; border-radius:20px; border:1px solid red; box-shadow:2px 2px 14px 2px black;font-size:em;" role="alert">
   </div>
 
 <!---------------------------------->
 <!---------------------------------->

 <div id="successrs"class="alert alert-success notifycross" style="display:none;color:green;border-radius:20px; border:1px solid green;font-size:em; box-shadow:2px 2px 14px 2px black;" role="alert">
</div>
 <!---------------------------------->

<!------ starting of menu divs --------> 
<div id="visitordiv" style="display:none;">
  <center>
    <h3 class="" style="color:orange"> visitor set </h3>
  <!----- start of data show of visits ----->
    <div style="display:flex;flex-direction:column; width:70%;">
   <center>

        <h4 class=" text-success" style="border:1px solid green; border-radius:10px; background:#c0fcadb2;"> Marketing </h4> </center>
     <div id="vistrdivload"> </div>
    
     
    </div>
    <br>
    <br>
    <br>
    
  <input type="number" placeholder=" Total Users" id="tusrs" style="border: 1px solid orange; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" Total Sum" id="tsums" style="border: 1px solid orange; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" Total withdrawals " id="twithdraw" style="border: 1px solid orange; outline:none; color:indigo; font-size:1.5em;">
  <br>
  <br>

<button class="btn btn-warning vistrjbtn"> Update </button>
  
  </center>
</div>


<!--------->
<div id="setdatesdiv" style="display:none;">
  <center>
    <h3 class="" style="color:orange"> Starting Date settings </h3>
  <!----- start of data shiw of visits ----->
    <div style="display:flex;flex-direction:column; width:70%;"><center>

        <h4 class=" text-success" style="border:1px solid green; border-radius:10px; background:#c0fcadb2;"> Marketing </h4> </center>
     
      <h5 class="text-dark" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902);"> Starting date is <mark style="border-radius:15px;" class="text-success float-end vstrdate"> </mark></h5>
     
    </div>
    <br>
    <br>
    
  <input type="date" placeholder=" set starting Date " id="startdate" style="border: 1px solid green; outline:none; color:green; font-size:2em;">
  <br>
  <br>

<button class="btn btn-success strdatebtn"> Update Date </button>
  
  </center>
</div>




<!--------->
<div id="fkdepositediv" style="display:none;">
  <center>
    <h3 class="" style="color:#016dbdd5"> Fk deposites set </h3>
    
  <input type="text" placeholder="pngs  links" value="pngs/p.png" id="sprcntgfk" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
  <input type="text" placeholder="Payeer account" value="P" id="spayeerac" style="border: 1px solid red; outline:none; color:red; font-size:2em;">

  <input type="number" placeholder="sum " id="sumfk" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
<br>
<button class="btn btn-danger fksumbtn"> Update  deposite </button>
<br>
<br>
<hr>
    <h3 class="" style="color:red"> Fk withdrawals set </h3>
    
  <input type="text" placeholder=" pngs links" value="pngs/p.png" id="wprcntgfk" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
  <input type="text" placeholder="Payeer account" value="P" id="wpayeerac" style="border: 1px solid red; outline:none; color:red; font-size:2em;">

  <input type="number" placeholder="sumout " id="wsumfk" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
<br>
<button class="btn btn-danger fkwbtn"> Update  withdrawals </button>
  
  </center>
</div>
<!------->
<div id="newsmsgdiv" style="display:none;">
  <center>
    <h3 class="" style="color:gray"> Set news msgs </h3>

  <h4 class=" text-success" style="border:1px solid green; border-radius:10px; background:#c0fcadb2;"> this time show news msg </h4>
     
  <P class="text-dark newsdiv" style="border-radius:15px; border:1px solid gray; with:100%;background:rgba(221,216,204,0.902); font-size:1em;"> msg here </p>
    <br>

  <input type="text" placeholder="Type Any News For All " id="newsinpt" style="border: 1px solid black; outline:none; color:indigo; font-size:1.5em;">
  <br>
  <br>

<button class="btn btn-dark newsjsbtn"> Update news </button>
  </center>
</div>
<!----end of news msg div--->
<!----starting of setting div--->
<div id="settingdiv" style="display:none;">
  <center>
    <h3 class="" style="color:blue"> Settings Update </h3>
  <!----- start of data show of visits ----->
    <div style="display:flex;flex-direction:column; width:70%;"><center>

  <h4 class=" text-success" style="border:1px solid green;box-shadow:1px 1px 15px black; border-radius:10px; background:#c0fcadb2;">Full Settings ( On/0 | OFF/1 ) </h4> </center>
     
    <div class="stngvdiv"> </div>
        
    </div>
    <br>
    <br>
    
  <input type="number" placeholder=" Withdraw ON OFF" id="wonof" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <input type="text" placeholder=" Site Title " id="tgramlink" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" Random Login ON OFF " id="rdmlogin" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" Review Stars " id="chatonof" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" show for download script on(0)/off " id="vscrptdow" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <input type="number" placeholder=" for show news on(0)/off " id="shownews" style="border: 1px solid blue; outline:none; color:indigo; font-size:1.5em;">
  <br>
  <br>
<button class="btn btn-primary flstngbtn">Update Setting</button>
  </center>
</div>
<!----end of setting div--->
<div id="listsdiv" style="display:none;">
  <center><h3 class="" style="color:blue;"> lists Of Login Users </h3>
<div id="listtable">
   <!-- start here for Silver stars users -->
 <table class="silTable" id="sTab" style="width:180%;">
<tbody class="vbandusrs">
  <tr class="sthead">
	<th>id</th>
	<th>Login</th>
	<th>t_bal</th>
	<th>Invest</th>
	<th>sumout</th>
	<th>t_out</th>
	<th>Regdate</th>
	<th>logDate</th>
	<th>okSum?</th>
	<th>paytoreferal</th>
	<th>Total reffers</th>
	<th>RefferEnd</th>
	<th>RefBy</th>
	<th>Ban</th>
	<th>Emails</th>
  </tr>
  </tbody>
  
  <tbody class="tablesvall"> </tbody>
  
  
</table> 
</div>
  
  <hr style="padding:1%; box-shadow:inset 3px 3px 6px 4px navy,3px 3px 11px 4px brown; background:silver;">
  
  <input type="text" placeholder=" user id " id="usrbanid" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:30%;">
  <input type="text" placeholder=" ban id " id="banbyn" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:30%;">
<button class="btn btn-outline-danger usrsbanbtn"> ban user </button>

  <hr style="padding:1%; box-shadow:inset 3px 3px 6px 4px navy,3px 3px 11px 4px lime; background:white;">

  <input type="text" placeholder="user id" id="usrsid2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="text" placeholder="t_bal" id="tbal2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="text" placeholder="invest" id="inv2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="text" placeholder="withdraw" id="withdraw2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="text" placeholder="t_withdraw" id="twithdraw2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="number" placeholder="ok Sum 1" id="speed2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="text" placeholder="paidtoref" id="reffers2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">
  <input type="number" placeholder="endrefbns" id="prcntg2" style="border: 1px solid black; outline:none; color:indigo; font-size:2em; width:20%;">

  <br>
<button class="btn btn-danger updusrsbtn2"> update user </button>
  </center>
</div>
<!------ end of list div ------->
<div id="chatdiv" style="display:none;">
<center>
  <h3 class="text-primary"> Users inbox </h3>
   <div style="display:flex;flex-direction:column; width:98%;">


    <h4 class=" text-success" style="border:1px solid green; border-radius:10px; background:#c0fcadb2;"> Uers Mail Managements </h4>
  
</center>

<div class="vchats" style="width:100%;height: 70%;  overflow-x: hidden; overflow-y: auto; height: 50em; box-shadow:inset 2px 2px 14px black;">

</div>
<center>
  <hr style="padding:1%; box-shadow:inset 3px 3px 6px 4px navy,3px 3px 11px 4px red; background:aqua;">

  <div style="border-radius:15px; border:1px solid red; width:53%;">
    
  <button class="btn btn-outline-danger delallchatbtn" style="border-radius:15px;"> Delete All</button>
   <input type="number " placeholder="mail id" id="delchatid" style="border-radius:15px; border:1px solid green; outline:none;">

 <button class="btn btn-danger delchatbtn" style="border-radius:15px;"> Delete</button>

  </div>
 
  <hr style="padding:1%; box-shadow:inset 3px 3px 6px 4px navy, 3px 3px 11px 4px blue; background:aqua;"> 
       
 <input type="text" placeholder="mail ID" class="mailidsnd" style="border-radius:15px; border:1px solid green; outline:none;">
 
   <input type="text" placeholder="reply" class="chatsreply" style="border-radius:15px; border:1px solid green; outline:none;">
   
    <button class="btn btn-primary replybtn" style="border-radius:15px;"> Send</button>  
</center>

    </div>
</div>

<!------ start of Youtube Videos Links rewards Div -------->
<br>
<br>
<div id="ytvidiv" style="display:none;">
 <table class="silTable" id="sTab" style="width:100%;">
<tbody class="vbandusrs">
  <tr class="sthead">
	<th>id</th>
	<th>FROM</th>
	<th>Video Link</th>
	<th>DATE</th>
	<th>Status</th>
  </tr>
  </tbody>
  
  <tbody class="ytblv"> </tbody>
</table>
<center>
<hr class="bg-danger p-1">
    <h3 class="" style="color:red"> For Video Rewards When You Paid then Update </h3>

  <input type="number" placeholder="Reward ID" id="ytidlink" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
  <input type="text" placeholder="check code" value="fa-check" id="ytchkcod" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
<br>
<button class="btn btn-danger updtytokbtn"> Update Rewards </button></center>
</div>
<!------ end of Youtube Videos Links rewards Div -------->

<!------ start of mail divs -------->
<div id="mailsdiv" style="display:none;">
  <center>
   <h3 class="" style="color:#016dbdd5"> Send Mail To all / or 1 person </h3>

  <input type="text" placeholder="My Email" value="From@gmail.com" id="mymail" style="border: 1px solid red; outline:none; color:red; font-size:2em;"><br>
  <b style="color:green;"> If want to send all mails no need to type there mail and send all button press (emails selected from data base)</b></br>
  <input type="text" placeholder="Email To" value="To@gmail.com" id="mailto" style="border: 1px solid green; outline:none; color:green; font-size:2em;"><br>
  <input type="text" placeholder="Subject Here" id="sbjctmail" style="border: 1px solid rgb(0,87,107); outline:none; color:rgb(0,87,107); font-size:2em;"><br>
  <textarea type="text" placeholder="Main Message Here" id="msgmail" style="border: 1px solid navy; outline:none; color:navy; font-size:1em;width:80%;height:8em;"></textarea><br><br>
  <button class="btn btn-success sndmail1"> send to this only</button><br><br>
  <button class="btn btn-danger sndmailall"> send to all </button>
</center>
</div>
<!------ end of mail divs -------->

<!------ start of start of pm request withdraw tables -------->
<br>
<br>
<div id="vpmfwtbldiv" style="display:none;">

<h4 class="text-danger"> Perfect Money Withdraw Request Table</h4>
 <table class="silTable" id="sTab" style="width:100%;">
<tbody class="vbandusrs">
  <tr class="sthead">
	<th>id</th>
	<th>mail</th>
	<th>PM_acc</th>
	<th>req_$</th>
	<th>ban</th>
	<th>t_bal</th>
	<th>m_bal</th>
	<th>w_bal</th>
	<th>tw_bal</th>
	<th>refby</th>
	<th>refend</th>
	<th>date</th>
	<th>P_acc</th>
  </tr>
  </tbody>
  
  <tbody class="vpmfwtbl"> </tbody>
</table>
<center>
<hr class="bg-danger p-1">
    <h3 class="" style="color:red"> if send this user of perfect money withdraw then update check other wise hitory </h3>

  <input type="number" placeholder="withdraw request ID" id="pmwtblid" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
  <input type="text" placeholder="check code" value="fa-check" id="pmwtblbalk" style="border: 1px solid red; outline:none; color:red; font-size:2em;">
<br>
<button class="btn btn-danger updtpmwtblbtn"> Update when bal sended</button></center>
</div>
<!------ end of pm request of withdraw table div -------->

<!------ end of menu divs -------->
<!------ end of menu divs -------->

  </body>
  
  
</head>    
<!-- Option 1: Bootstrap Bundle with Popper -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
<script type="text/javascript">
    /////////////////////////////////////
  $(document).on('click','.notifycross',function(){
      $('#errors').hide(100);
      $('#successrs').hide(100);
    })
/////////////////////////////////////////
     $(document).on('click','.visitorbtn', function(){
    $('#visitordiv').show();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#ytvidiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
  
     $(document).on('click','.setdatesbtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').show(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#ytvidiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
  
     $(document).on('click','.fkdepositebtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').show(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#ytvidiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.newsmsgbtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').show(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#ytvidiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.settingbtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').show(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#ytvidiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.listsbtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').show(100);
     $('#chatdiv').hide(100);
     $('#ytvidiv').hide(100);
     $('#mailsdiv').hide(100);
     $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.chatbtn', function(){
    $('#visitordiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#ytvidiv').hide();
    $('#mailsdiv').hide();
    $('#chatdiv').show(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.ytvidivbtn', function(){
    $('#ytvidiv').show();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#mailsdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.mailsndbtn', function(){
    $('#mailsdiv').show();
    $('#ytvidiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#vpmfwtbldiv').hide(100);
  }) 
     $(document).on('click','.vpmfwtblbtn', function(){
    $('#mailsdiv').hide();
    $('#ytvidiv').hide();
    $('#setdatesdiv').hide(100);
    $('#fkdepositediv').hide(100);
    $('#newsmsgdiv').hide(100);
    $('#settingdiv').hide(100);
    $('#listsdiv').hide(100);
    $('#chatdiv').hide(100);
    $('#vpmfwtbldiv').show(100);
  }) 
  
     $(document).on('click','.resetbtn', function(){
    $('.resetbtnin').slideToggle();
    $('.resetbtnok').hide();
     })
     $(document).on('click','.resetbtnin', function(){
    $('.resetbtnok').slideToggle();
     })
/***** end of menu btns ****/
////////////
 $(document).on('click','.vistrjbtn',function(){ 
   var tusrs = $('#tusrs').val();
   var tsums = $('#tsums').val();
   var tsumout = $('#twithdraw').val();
      $.post(
      "ajax.php",
      {tusrsj:tusrs,tsumsj:tsums,tsumoutj:tsumout},
       function(vistrupd){
          loadvistrdiv();
       if(vistrupd == 1){
          $("#successrs").fadeIn();
         $("#successrs").html(' √ Update');
        }else if(vistrupd == 0){
          $('#errors').fadeIn();
          $("#errors").html(' × Visitor not update');
      }  }); // end post
  })
////////////
////////////
 $(document).on('click','.updtpmwtblbtn',function(){ 
   var pmwtblid = $('#pmwtblid').val();
   var pmwtblbalk = $('#pmwtblbalk').val();
      $.post(
      "ajax.php",
      {pmwtblidj:pmwtblid,pmwtblbalkj:pmwtblbalk},
       function(pmwfchk){
          vpmfwtblf();
       if(pmwfchk == 1){
          $("#successrs").fadeIn();
         $("#successrs").html(' √ Updated pm of withdraw');
        }else if(pmwfchk == 0){
          $('#errors').fadeIn();
          $("#errors").html(' × pm withdraw Not Update Some Error');
      }  }); // end post
  })
////////////
////////////
 $(document).on('click','.updtytkbtn',function(){ 
   var ytidlink = $('#ytidlink').val();
   var ytchkcod = $('#ytchkcod').val();
      $.post(
      "ajax.php",
      {ytidlinkj:ytidlink,ytchkcodj:ytchkcod},
       function(ytbnsf){
          ytblvf();
       if(ytbnsf == 1){
          $("#successrs").fadeIn();
         $("#successrs").html(' √ Updated YT Video Rewards');
        }else if(ytbnsf == 0){
          $('#errors').fadeIn();
          $("#errors").html(' × Reward Not Update Some Error');
      }  }); // end post
  })
////////////
 $(document).on('click','.strdatebtn',function(){
   var sdate = $('#startdate').val();
      $.post(
      "ajax.php",
      {sdatejs:sdate},
       function(sdatef){
       if(sdatef == 1){
          $("#successrs").fadeIn();
          $("#successrs").html(' √ Update starting project date'); loadstrdate();
        }else if(sdatef == 0){
          $('#errors').fadeIn();
          $("#errors").html(' × starting  project date not update');
      }  }); // end post
  })
//////////////////////////////
 $(document).on('click','.fksumbtn',function(){
   var spacc = $('#spayeerac').val();
   var prcntgfk = $('#sprcntgfk').val();
   var sumfk = $('#sumfk').val();
      $.post(
      "ajax.php",
      {spaccjs:spacc,prcntgfkjs:prcntgfk,sumfkjs:sumfk},
       function(fksums){
       if(fksums == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Update fk sum');
        }else if(fksums == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not fk sum');
      }  }); // end post
  })
////////////////// 
//////////////////////////////
 $(document).on('click','.fkwbtn',function(){
   var wpacc = $('#wpayeerac').val();
   var wprcntgfk = $('#wprcntgfk').val();
   var wsumfk = $('#wsumfk').val();
      $.post(
      "ajax.php",
      {wpaccjs:wpacc,wprcntgfkjs:wprcntgfk,wsumfkjs:wsumfk},
       function(fkw){
       if(fkw == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Update fk withdraw');
        }else if(fkw == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not fk withdraw');
      }  }); // end post
  })
///////////////////////////////
 $(document).on('click','.newsjsbtn',function(){
   var newsinpt = $('#newsinpt').val();
      $.post(
      "ajax.php",
      {newsinptjs:newsinpt},
       function(newsf){
       if(newsf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Update users news'); newsdivf();
        }else if(newsf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not updaye users news');
      }  }); // end post
  })
////////////////// 
///////////////////////////////
 $(document).on('click','.flstngbtn',function(){
   var wonof = $('#wonof').val();
   var tgramlink = $('#tgramlink').val();
   var rdmlogin = $('#rdmlogin').val();
   var chatonof = $('#chatonof').val();
   var vscrptdow = $('#vscrptdow').val();
   var shownews = $('#shownews').val();
      $.post( 
      "ajax.php",
      {wonofjs:wonof,tgramlnkjs:tgramlink,rdmlogjs:rdmlogin,chatonofjs:chatonof,vscrptdowj:vscrptdow,shownewsj:shownews},
       function(flstng){
       if(flstng == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Update Full settings'); stngvdiv();
        }else if(flstng == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not updated full settings');
      }  }); // end post
  })     
///////////////////////////////
 $(document).on('click','.usrsbanbtn',function(){
   var usrbanid = $('#usrbanid').val();
   var banbyn = $('#banbyn').val();
   $.post( 
      "ajax.php",
      {usrbanidj:usrbanid,banbynj:banbyn},
       function(usrsbanf){
       if(usrsbanf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Updated users ban by this ID : '+ usrbanid ); tblsvf();
        }else if(usrsbanf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not updated ban users ');
      }  }); // end post
  })
  
///////////////////////////////
 $(document).on('click','.updusrsbtn2',function(){
   var usrsid2 = $('#usrsid2').val();
   var tbal2 = $('#tbal2').val();
   var inv2 = $('#inv2').val();
   var withdraw2 = $('#withdraw2').val();
   var twithdraw2 = $('#twithdraw2').val();
   var speed2 = $('#speed2').val();
   var prcntg2 = $('#prcntg2').val();
   var reffers2 = $('#reffers2').val();
   $.post( 
      "ajax.php",
      {usrsid2j:usrsid2,tbal2j:tbal2,inv2j:inv2,withdraw2j:withdraw2,twithdraw2j:twithdraw2,speed2j:speed2,prcntg2j:prcntg2,reffers2j:reffers2},
       function(usrupd2){
       if(usrupd2 == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ Updated users data '); tblsvf();
        }else if(usrupd2 == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not updated  users data');
      }  }); // end post
  })
////////////////// 
////////////////// 
////////////////// 
//////////////////
function loadvistrdiv(){
    $.post(
      "ajax.php",
      {loadvistrdiv:'jzhxldiz'},
      function(vistrdiv){
      $("#vistrdivload").html(vistrdiv);
    }); // end post
}    
/////////////////////////////////// 
function loadstrdate(){
    $.post(
      "ajax.php",
      {sdatjsf:'jxjxjx'},
      function(sdatef){
      $(".vstrdate").html(sdatef);
    }); // end post
}    
/////////////////////////////////// 
function newsdivf(){
    $.post(
      "ajax.php",
      {newsvjs:'cuuckc'},
      function(newsf){
      $(".newsdiv").html(newsf);
    }); // end post
}
/////////////////////////////////// 
function stngvdiv(){
    $.post(
      "ajax.php",
      {stngvdivj:'gxhdhd'},
      function(fstngv){
      $(".stngvdiv").html(fstngv);
    }); // end post
}    
//////////////////  
function tblsvf(){
    $.post(
      "ajax.php",
      {tablesv:'duucuc'},
      function(tblsv){
      $(".tablesvall").html(tblsv);
    }); // end post
}    
//////////////////  
function ytblvf(){
    $.post(
      "ajax.php",
      {ytblvbtnjs:'shhdhdh'},
      function(ytblf){
      $(".ytblv").html(ytblf);
    }); // end post
}    
//////////////////  
function vpmfwtblf(){
    $.post(
      "ajax.php",
      {vpmfwtblvj:'vptbldjdn'},
      function(vpmfwtblf){
      $(".vpmfwtbl").html(vpmfwtblf);
    }); // end post
}    
function vchatsf(){
    $.post(
      "ajax.php",
      {vchatsjsf:'jxk'},
      function(vchatsf){
      $(".vchats").html(vchatsf);
  
      }
    ); // end post
}    
//////////////////  
  $(document).on('click','.tomailplacebtn',function(){
  toplacemails = $(this).data("item");
  $(".mailidsnd").val(toplacemails);
  })
//////////////////  
  $(document).on('click','.replybtn',function(){
  var mailid = $('.mailidsnd').val();
  var replychats = $('.chatsreply').val();
  
      $.post(
      "ajax.php",
      {replychatsf:replychats,mailidj:mailid},
      function(replychatf){
       if(replychatf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ reply successfully '); vchatsf();
        }else if(replychatf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not reply errors');
      }  }); // end post
})
/////////////
//////////////////    
  $(document).on('click','.delchatbtn',function(){
  var delchatid = $('#delchatid').val();
      $.post(
      "ajax.php",
      {delchatidj:delchatid},
      function(delchatsf){
       if(delchatsf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ deleted successfully ID:'+delchatid); vchatsf();
        }else if(delchatsf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not deleted errors');
      }  }); // end post
})
/////////////
//////////////////    
  $(document).on('click','.delallchatbtn',function(){
    var delconfrm = confirm('why Delete All Chats');
    if(delconfrm){
      $.post(
      "ajax.php",
      {delallchats:'delallchatsf'},
      function(delallchatsf){
       if(delallchatsf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ deleted All Chats successfully '); vchatsf();
        }else if(delallchatsf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not deleted All Chats errors');
      }  }); }// end post
})
/////////////
///////////////////////////////
/////////////single person mail ///////////////
 $(document).on('click','.sndmail1',function(){
   var mymail = $('#mymail').val();
   var mailto = $('#mailto').val();
   var sbjctmail = $('#sbjctmail').val();
   var msgmail = $('#msgmail').val();
      $.post(
      "ajax.php",
      {mymailjf1:mymail,mailtoj:mailto,sbjctmailj:sbjctmail,msgmailj:msgmail},
       function(sendmail1f){
       if(sendmail1f == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ mail send successfully to all');
        }else if(sendmail1f == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not send mail to all mails try again');
      }  }); // end post
  })
///////////////////////////////
///////////for all person mail //////////
 $(document).on('click','.sndmailall',function(){
   var mymail = $('#mymail').val();
   var sbjctmail = $('#sbjctmail').val();
   var msgmail = $('#msgmail').val();
      $.post(
      "ajax.php",
      {mymailjfall:mymail,sbjctmailj:sbjctmail,msgmailj:msgmail},
       function(sendmailsf){
       if(sendmailsf == 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ mail send successfully to this');
        }else if(sendmailsf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not send mail to this for 1 mail try again');
      }  }); // end post
  })
///////////////////////////////
//////////////////    
  $(document).on('click','.resetbtnok',function(){
    var delconfrm = confirm('why Reset All Games ');
    if(delconfrm){
      $.post(
      "ajax.php",
      {gameresetj:'jcjdjsk'},
      function(resetgmf){
       if(resetgmf== 1){
          $("#successrs").fadeIn();
          $("#successrs").html('√ all game reset successfully '); 
          tblsvf();
        }else if(resetgmf == 0){
          $('#errors').fadeIn();
          $("#errors").html('× Not reset games ');
      }  }); }// end post
})
/////////////
	window.onload = loadvistrdiv();
  window.onload = loadstrdate();
  window.onload = newsdivf();
  window.onload = stngvdiv();
  window.onload = tblsvf();
  window.onload = vchatsf();
  window.onload = ytblvf();
  window.onload = vpmfwtblf();



</script>  