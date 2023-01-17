
<?
error_reporting(0);
session_start();
include "../config.php";

/////////////////////
     $d = 27-5-2022;
     $h = 15; 
     $m = 05;
     $s = 45;
/////////////////////






?>

<?
//////// for perfect money ////////
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
// to     confirm
if( $hash == $_POST['V2_HASH'] )
{
  $_SESSION['okpayid'] = 'okpaybtn';
}




/* //////////////////////////////////////////
 //////////////////////////////////////////
 //////////////////////////////////////////
 ////////////////////////////////////////// */
 
if(isset($_POST['chkpidbtn']))
  {
    require_once('cpayeer.php');
    $accountNumber = $payeeraccno;
    $apiId = $apiIdset;
    $apiKey = $apikeyp;
    $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
    // for check with get id
    $popidesc = mysqli_real_escape_string($db,$_POST['inptpid']);
if ($payeer->isAuth())
{	
  $historyId = $popidesc;
	$arHistory = $payeer-> getHistoryInfo ($historyId);

  foreach ($arHistory as $k)
	{ 	}
  // $_SESSION['paidnotif'] = $k['sumOut']; 
	// end of history id 

	if($k['id']!=$historyId)
	{	
	 $_SESSION['payless'] = 'ваш идентификатор не найден, введите правильный идентификатор';
	}
  else
	{
	 if($k['sumOut'] >= $sellvalue && $k['curOut'] == 'USD')
	{ 

 // check if already id present in db or not
	
	  $chkpopid = "SELECT * FROM getselloffer WHERE pidhistory='$popidesc'";
	  $sqliqpop = mysqli_query($db,$chkpopid);
	  $vtridh = mysqli_fetch_assoc($sqliqpop);
	  if($vtridh['pidhistory'] == $popidesc)
	  { $_SESSION['payless'] ='уже использовал этот идентификатор';
	  }else{ 
	   $insrttrid = "INSERT INTO getselloffer (pidhistory) VALUES ('$popidesc')";
	  $insrttridq = mysqli_query($db,$insrttrid);
	       $_SESSION['okpayid'] = 'okpaybtn';
	      }
	  }else{
	       $_SESSION['payless'] = 'пожалуйста, не платите меньше '.$sellvalue.' USD';
	     } ////////// sumout in rub ////////
   	}
  } //auth 
}

/*-@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
if(isset($_POST['fedbackbtn']))
{
  $fedbakmsg = $_POST['fedbakmail'].'::'.$_POST['fedbaktext'];
  
  $feedbk = "INSERT INTO getselloffer (feedback) VALUES ('$fedbakmsg')";
  $feedbakqry = mysqli_query($db,$feedbk);
  
}

   

?>



<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.3.7">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

      <!-- for awsome fonts -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title> Download Minerbank</title>
    <style>
      .downlodmove{
        animation: donloadbtn 4s infinite alternate-reverse;
      }
      @keyframes donloadbtn
      {
        10%{ margin-top: -10px; color: navy; }
        50%{ margin-top: 10px; color: lime; position:absolute; font-size:3em}
        80%{ margin-top: 40px; color: gold; font-size:8em;opacity:0.4;}
      }
     .buybtndiv{
       animation: buybtndiv 2s infinite alternate;
     }
     @keyframes buybtndiv
     {
      20%{ box-shadow:inset 1px 1px 40px silver, -1px -1px 40px silver; }
     
      50%{ box-shadow: 1px 1px 100px gold, -1px -1px 100px gold; }
     
      90%{ box-shadow: 10px 10px 60px green, -10px -10px 60px green; }
     }
     .redlightblink{
       border-radius: 12px;
      max-height: 25px; max-width: 25px;
       border: 1px solid black; font-size: 20px;
       box-shadow: 1px 1px 4px black;
       animation: lightblink 1s infinite alternate-reverse;
     }
     @keyframes lightblink {
       50%{ color:red; background: none;}
       100%{ color:black; background:none; border:1px solid red;}
     }
    </style>
  </head>
  <body>
    
    
    
 <container class="bg-dark" style="margin-top:20px;">
    
 <div class="btn-group bg-secondary" style="width:100%;" role="group" aria-label="Basic mixed styles example">
  <button type="button" class="btn btn-primary p-2 fa fa-info-circle aboutbtn"> About </button>
  <button type="button" class="p-2 btn btn-warning fa fa-comments feedbackbtn"> Feedback</button>
  <a href="https://getsellweb.ga/" type="button" class="p-2 btn btn-success fa fa-download"> Downloads Others</a>
</div>
    
    <div style="background:#02024b;">
      
    <h2 class="" style="color:lime">Скачать скрипты <? echo $webslsdemoname; ?></h2>
    <h4 class="text-light small">ZIP-файл <? echo $webslsdemoname; ?></h4>
    
    <div style="background:#333334;">
      <container>
    <b class="text-warning" style="width:60%;margin-left:10%;"> <span class="fa fa-download downlodmove" style="position:absolute;"></span>
      
      <h3 style="color:aqua;margin-left:10%;"> 
       Сделать собственный сайт <? echo $webslsdemoname; ?> <u style="color:gold; font-size:0.8em;">( новый в 2022-4 ) </u>
     </h3>
  <div style="display:flex; flex-direction:row;">
   <div style="width:62%;">
    <pre class="" style="color:white ; border-left:15px Solid aqua; margin-left:4%; border-top:1px solid aqua; border-bottom:2px solid aqua;font-size:1.1em; background:rgb(72,95,90); border-right:1px solid aqua; ">
       Чтобы загрузить эти скрипты, платите только <i class="text-warning"> <? echo $sellvalue; ?> </i> <span class="fa fa-dollar text-info"></span>
        это предложение на минимальное время
        <u class="bg-success"> Оригинальный 100% рабочий √</u>
       
        <b class="" style="color-skyblue"><i class="fa fa-star text-info"> </i> это запрашивается некоторыми пользователями для
        ограниченный срок</b>
      <i style="color:pink;"> Все вещи могут быть сброшены по мере вашего управления
      (Ежедневный бонус 5% до 230%, скорость майнинга SO ON
      A-Z в админ паневсе все характеристики в документах</i>
      </pre>
      <!-- after div blue ---> 
     <h3 class="text-danger"> Как установить</h3>
        <p class="text-muted"> Инструкции в архиве </p>
      <!-- after div install ---> 
         
      <ul>
        <li class="text-warning"> USD <i class="text-light"> / </i>  <? echo $sellvalue; ?><span class="fa fa-dollar text-info"></span> </li>
       
        <li class="text-warning"> Тип файла<i class="text-light"> / </i> ZIP  <span class="fa fa-file text-info"> </span></li>
        
        <li class="text-warning"> Скачать<i class="text-light"> / </i>Мгновенное <i class="text-light small"> ( После платежей ) </i> <span class="fa fa-download text-info"> </span> </li>
        
        <li class="text-warning"> если хотите жить сайт  <i class="text-light small"> ( домен + хостинг ) </i> <span class="fa fa-check text-info"> </span> </li>
      </ul>
           <!----- For Btn -->
    <button style="margin-right:10%; font-size:1.2em;" class="btn btn-success float-end buybtndiv"> КУПИТЬ <i class="fa fa-download text-light"></i> </button>
    </div>
     
     
     
      <div class="p-2" style="width:20%;">
        <center>
          <h1 class="redlightblink"> • </h1>
        </center>
        
        <h4 class="text-danger"> Конец времени </h4>
        <h2 class="text-info" id="ofrtime">
        </h2>
     <h3 class="p-2" >
        <strike style="color:rgb(209,89,137);font-size:1.1em;"> <? echo $orignalval; ?><i class="fa fa-dollar"></i></strike>
    
      </h3>
      <b class="" style="color:lime;font-size:1.5em;">
       <? echo $sellvalue; ?> $ √
      </b>
      </div>
      
      <div style="width:25%;">
        <img src="demoimg.png" style="width:80%;">
      </div>
    </div>
      
       </b>
       </container>
    </div>
    <!-- end of container -->
    </div>
    </container>
    
    
    
    
    
    
    <!------ for payeer id chk ----->
 <div class="buydiv" style="background:#3a294a; width:100%; display:none;">
 
 <u style="color:white;"> Step : 1</u><b class="text-info"> PAYEER </b>
   <center>
      <br>
 <div class="p-1" style="color:white ; border-left:15px Solid #e3ff00; margin-left:1%; border-top:1px solid #e3ff00; border-bottom:2px solid #e3ff00; background:rgb(110,106,70); border-right:1px solid #e3ff00; width:65%; border-radius:0 10% 0% 10% ;">
      
      
         
<h4 style="color:rgb(178,253,175);"> Файл прямой загрузки </h4>

      <mark style="font-size:1.4em;" class="p-2">
      Перейти к <u><a href="https://payeer.com/ru/account/send/"> __PAYEER__ </a></u> веб-сайт и <a style="color:rgb(254,4,238);" href="https://payeer.com/ru/account/send/"><b> __ПЕРЕЧИСЛИТЬ__ </b></a><? echo $sellvalue; ?> USD $ необходимая сумма на кошелек  <u><b style="letter-spacing:2px;color:rgb(244,3,229);"> P1041386880 <input type="text" id="coypaccount" style="position:absolute;z-index:-1;" value="P1041386880"><input type="submit" onclick="copypacbtn()" style="color:brown;border:5px solid #d10795;" value="Copy" id="copypacbtn"> </b></u> 
        
         Когда вы заплатили, вы получите идентификатор транзакции, скопируйте идентификатор транзакции из своей учетной записи и проверьте, оплачено ли это или нет (если вы заплатили, вы можете загрузить мгновенный успех полностью) с помощью кнопок получения
         
      </mark>
    <img src="payeer_trid.png" style="width:100%; margin-top:10px;">
     <br></br>
     </div>
      <br>
      <br>
      
  
  
      <form method="post" style="width:80%;">
       <input style="width:80%; border-bottom:4px solid aqua; border-top:none;  border-right:2px solid gold; border-left: 2px solid gold; background:indigo; color:aqua; outline:none; font-size:2em; " type="number" placeholder="История Id" name="inptpid" >
        
        <input style="width:25%;font-size:1.5em;" type="submit" value="проверить Id Paid" class="btn btn-outline-warning" name="chkpidbtn">
      </form>
      </center>
      
      <?
      if(isset($_SESSION['payless']))
      {
       echo '<center> <h3 class=" alert-danger" style="width:60%; margin-top:20px;" role="alert"> × '. $_SESSION['payless'] .'</h3></center> ';
      }
      ?>

      <? 
      if(isset($_SESSION['okpayid']))
      {
      echo '<a href="downloadfile.txt" style="outline:none; border: 2px solid lime; border-radius:20% 0 20% ; color:rgb(22,248,189); font-size:1.5em; box-shadow: 4px 2px 18px 2px gold; text-decoration:none;" class="p-1 btn btn-outline-success" download> Скачать скрипты <i class="fa fa-download text-warning"></i> </a> ';
      }
      
      ?>
   <hr class="p-2 bg-warning">
 <u style="color:white;"> Step : 2</u><b style="color:pink"> PERFECT MONEY </b>
 
<form action="https://perfectmoney.is/api/step1.asp" method="POST">

  <input type="hidden" name="PAYEE_ACCOUNT" value="<? echo $yourpmacc_no; ?>">
  <input type="hidden" name="PAYEE_NAME" value="<? echo $mycompany_msg; ?>">
  
<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $sellvalue; ?>" >
  
  <input type="hidden" name="PAYMENT_UNITS" value="USD">
  <input type="hidden" name="STATUS_URL" 
      value="<? echo $slstatus_url; ?>">
  <input type="hidden" name="PAYMENT_URL" 
      value="<? echo $slsuccess_url; ?>">
  <input type="hidden" name="NOPAYMENT_URL" 
      value="<? echo $slsfail_url; ?>">
  <input type="hidden" name="BAGGAGE_FIELDS" 
      value="ORDER_NUM CUST_NUM">
  <input type="hidden" name="ORDER_NUM" value="9801121">
  <input type="hidden" name="CUST_NUM" value="2067609">
  <center>
  <input type="submit" name="PAYMENT_METHOD" class="btn btn-danger" value="Perfect Money P A Y" id="pmpsendbtn"></center>

</form>
 
 
 
      
    </div>
    <!--------- end of buy div ------------>
    
    
    
    
    
    <!--------- feedback ------------>
    <div style="width:60%; display:none; position:absolute; z-index:6; margin-left:20%; background:#4b0453; border-bottom: 4px solid gold; box-shadow: 1px 1px 142px 1px #c2a402; top: 100px; border-radius: 10% 0 10% 0;" id="feedbackdiv">
        <center>
      <form method="post">
        <br>
        <input style="width:98%; background:#6dbc91;color:info; border-bottom: 5px solid red; font-size: 2em;" type="email" name="fedbakmail" placeholder="Email">
       <br>
       <br>
      <input style="width:98%; background:#6dbc91;color:info; border: 5px solid red; font-size: 3em;" type="text" name="fedbaktext" placeholder="Сообщение">
       <br>
       <br>
        <input style="width:30%; background:black; border-radius:20% 0 20% 0; font-size: 2em; color: lime;" type="submit" name="fedbackbtn" value="Отправлять" >
      </form> 
      <br>
      <p style="color:white;"> Or </p>
      <br>
      <b style="color:lime;"> Свяжитесь с нами с домашней страницы</b>
      </center>
   </div>
    
    <!-------- start of about ------->
    
    <div id="aboutdiv" style="width:70%; display:none; box-shadow: 4px 4px 158px 1px #2091fa; border: 40px solid #028d8a; background: silver; border-radius: 20% 0 20% 0; position:absolute; z-index: 8; top: 10px; margin:15%">
      <center>
        <h2 class="text-brown">
          О сайте загрузки скриптов
        </h2><hr class="p-2 bg-primary">
        <h4 class="text-primary">
       Каждый пользователь может скачать скрипты с работающими и по более низкой цене до конца времени.
    
     <ul class="text-muted">
      <li>на этой платформе есть все скрипты</li>
       <li> ограниченные по времени предложения </li>
       <li>  скачать до конца времени </li>
       <li>   Новые скрипты каждый день </li>
       <li>   Обратная связь  </li>
       <li>   мгновенная загрузка </li>
       <li>   любые проблемы, связанные с контактом с администратором, не стесняйтесь </li>
       <li>  если кто-то хочет получить какой-либо тип сценария, затем скрипты обратной связи </li>
       
          </ul>
        </h4>
        
      </center>
    </div>
    
    
    <style>
      .globmove{
        animation: globmov 4s infinite linear;
      }
      @keyframes globmov
      {
        10%{
          transform: rotate(120deg);
        }
        50%{ transform: rotate(360deg); font-size: 1.5em; }
      }
    </style>
    
    
    
    
    
  <hr class="p-2 text-primary" style="margin-top:100px;">
    <h2 class="text-primary">Скрипт LIVE DEMO <? echo $webslsdemoname; ?> Website <span class="fa fa-arrow-down"></span> <span class="fa fa-globe globmove"></span></h2>
   <center> <iframe src="<? $iframeweblink; ?>" style="width:95%; height:1400px; border:8px solid green; box-shadow: 2px 0px 48px 0px brown;"></iframe> </center>
    
    
    
  
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  
    
  </body>
</html>








<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).on('click','.buybtndiv',function(){
      $(".buydiv").slideToggle();
      $("#feedbackdiv").hide(100);
      $("#aboutdiv").hide(100);
    });
   // end of buybtndiv
    $(document).on('click','.feedbackbtn',function(){
        $("#aboutdiv").hide(100);
      $("#feedbackdiv").slideToggle();
    });
   // end of feedbackdiv
    $(document).on('click','.aboutbtn',function(){
      $("#feedbackdiv").hide(100);
      $("#aboutdiv").slideToggle();
    });
   // end of feedbackdiv
   
      
    
    

/////////////// start of timer with ajax ////
var stime = <?php echo strtotime("$d $h:$m:$s") ?> * 1000;
  var now = <? echo time() ?> * 1000;
  
  // for intervel
  var x = setInterval(function()
  {
    now = now + 1000;
    var dis = stime - now;
    
    var d = Math.floor(dis/(1000*60*60*24));
    var h = Math.floor((dis%(1000*60*60*24))/(1000*60*60));
    
    var m = Math.floor((dis%(1000*60*60))/(1000*60));
    var s = Math.floor((dis%(1000*60))/1000);
    
  document.getElementById("ofrtime").innerHTML = h + "h:" + m + "m: " + s + "s";
    
    if(dis < 0){
      clearInterval(x);
      document.getElementById("ofrtime").innerHTML = "Time End in Some Days"; 
     

    } // end if
  },1000);
  ///// end of timer with ajax
   
   
   
   
   // for p acount copy
    function copypacbtn()
  {
   alert('Copy Payeer Account For Send Money');
    var selectto = document.getElementById("coypaccount");
    selectto.select();
    document.execCommand("copy");
   document.getElementById("copypacbtn").style.color = "blue";
   document.getElementById("copypacbtn").style.border = "10px solid #12f39e";
   document.getElementById("copypacbtn").innerHTML = "Copeid";
  } 
  // end payeer copy account for 
  // send money to this 
  
  
</script>