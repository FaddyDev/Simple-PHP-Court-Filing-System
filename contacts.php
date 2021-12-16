<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Contacts</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body onLoad="renderTime();" oncontextmenu="return false">

<div id="header">
THE NYERI LAW COURTS ONLINE CASE FILE MANAGEMENT SYSTEM
</div>


<div id="top">
   <div id="clockDisplay" class="clock">
   </div>
   
   <div id="session">
 <?php
//Confirming that the user is logged in
session_start();
//session_cache_expire(200);
if (isset($_SESSION['loggedIn'])) 
{

$duration=$_SESSION['duration'];
$startTime=$_SESSION['startTime'];

//If the difference btwn the current time and the session start time exceeds the duration, it means the users stayed idle for long, destroy session
if((time()-$startTime)>$duration){
unset($_SESSION['duration']);
unset($_SESSION['startTime']);
unset($_SESSION['loggedIn']);
unset($_SESSION['reg']);

echo ("<script language='javascript'> window.alert('Your session has expired, please log in again')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
}
else{
//keep updating the startime with the current time
$_SESSION['startTime']=time(); 

if($_SESSION['reg']=='ADMIN'){echo "You are logged in as <font color='white'>".$_SESSION['loggedIn']."</font>, an <font color='white'>".$_SESSION['reg']."</font>.";}
else {
echo "You are logged in as <font color='white'>".$_SESSION['loggedIn']." </font> from <font color='white'>".$_SESSION['reg']." </font> Registry.";}

// echo "<script type='text/javascript'> CountDown(10,'session')<//script> ";
}
}
?>
   
   </div>
   
   <div id="logout">
   <?php
   //If a user is logged in, display log out button, else do not display anything
   if (isset($_SESSION['loggedIn'])) 
{
    echo "<form action='logout.php'> <input type='submit' id='logoutbtn' value='Log Out' /> </form>";}
else {echo "";}	
	 ?>
   
   </div>
</div>
<div id="nav">
  <ul>
  <li><a class="active" href="#">Contacts</a></li>
  
   <?php
   //Show different links for different users
   if(isset($_SESSION['reg'])){
if($_SESSION['reg']=='ADMIN'){
  echo "<li><a href='signup.php'>Add Users</a></li>
  <li><a href='viewUsers.php'>View Users</a></li>
   <li class='dropdown'>
    <a href='#' class='dropbtn'>View Cases</a>
    <div class='dropdown-content'>
      <a href='adminViewCases.php'>All Cases</a>
     <a href='adminViewMoved.php'>Moved Cases</a>
    </div>
  </li>  ";

} 
else if($_SESSION['reg']!='ADMIN'){
  echo "
  <li><a href='registerCases.php'>Register</a></li>
  <li><a href='viewCases.php'>All Cases</a></li>
  <li><a href='viewMoved.php'>Moved Cases</a></li>
  ";
}}

//If no user is logged in just show Home in addition to the active contact us page
else{
echo " <li><a href='index.php'>Home</a></li> ";}
  ?>
</ul>
</div>

<div id="container">

<div id="main">
Nyeri Law Courts</br>
0730 181600</br>
nyericourt@judiciary.go.ke</br>
nyerilawcourts@gmail.com</br>

</div>

<div id="side">
<img src="images/court.png" width="320" height="312"/>
</div>

</div>

<div id="footer">
&copy;Nyeri Law Courts:<?php echo date("Y") ?>
</div>


</body>
</html>
