<?
include "../config.php";
session_start();

if(isset($_POST['adloginbtn']))
{
$aname = mysqli_real_escape_string($db, $_POST['adname']);
$apass = mysqli_real_escape_string($db, $_POST['adpass']);

$pasm = md5($apass);
$pash = sha1($pasm);

$sqlcheck = "SELECT * FROM allstng WHERE rawn='$aname' AND rawp='$pash'";
$sqlqry = mysqli_query($db, $sqlcheck);
if(mysqli_num_rows($sqlqry) ==1)
{ 
      $_SESSION['gohome'] = $aname;
      header("location: admin.php");
}
else{
  echo '<br>';
  echo '<br>';
   echo '<div style="background-color:brown; color:lime; padding:14x;">
     This Name ( '.$aname.' ) is Not Found From Hash And MiniMum 11 Character Name Can be Logged In With Also Thats   Correct
    </div>';
    }
}

?>

<style>
  #adlog{
    padding: 14px;
    border: 40px solid brown;
  /*  border-radius: 5%; */
    
    
  }
  #logbtn{
    color: brown;
    padding: 28px;
    width: 30%;
  }
  #forminid{
    width:80%; border-radius: 25% 0 25% 0;border-right:2px Solid lime; border-left:2px Solid lime; border-bottom:2px Solid lime; display:grid; box-shadow:8px 8px 16px brown;
  }
  
</style>





<body style="background-color:#1b2831;">
  <br>
  <br>
  <br>
  <br>
  
  
  <h2 style="color:lime; letter-spacing:2px; border-bottom:4px solid green;">Main Log_In</h2>


<center>
  <form method="post">

   <div id="forminid">
    <input type="text" placeholder="Enter a Admin Name" name="adname" id="adlog" required min="5">
    <input type="password" placeholder="Enter a Admin Password" name="adpass" id="adlog" required min="5">
    </div>
   
       <input type="submit" name="adloginbtn" id="logbtn" value="Log_In">
   </form>
  </center>
   
  
  
</body>