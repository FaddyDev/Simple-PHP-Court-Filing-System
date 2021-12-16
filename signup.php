<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NYERI LAW COURTS: Add Users</title>
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
if (!(isset($_SESSION['loggedIn']))) 
{
	echo ("<script language='javascript'> window.alert('You are not Logged In,Please Log In to continue')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}
else{

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
echo "You are logged in as <font color='white'>".$_SESSION['loggedIn']."</font>, an <font color='white'>".$_SESSION['reg']."</font>.";

// echo "<script type='text/javascript'> CountDown(10,'session')<//script> ";
}
}

?>
   
   </div>
   
   <div id="logout"> <?php echo "<form action='logout.php'> <input type='submit' id='logoutbtn' value='Log Out' /> </form>" ?> </div>
</div>
<div id="nav">
  <ul>
  <li><a class="active" href="#">Add Users</a></li>
  <li><a href="viewUsers.php">View Users</a></li>
   <li class="dropdown">
    <a href="#" class="dropbtn">View Cases</a>
    <div class="dropdown-content">
      <a href="adminViewCases.php">All Cases</a>
     <a href="adminViewMoved.php">Moved Cases</a>
    </div>
  </li>
   <li><a href="contacts.php">Contacts</a></li>
  </ul>
</div>

<div id="container">

<div id="main">
<img src="images/nyeri lc.jpg" height="99%" width="99%" border="1" alt="Nyeri Law Courts"/>

</div>

<div id="side">
<fieldset><legend>Add Users</legend>
<form action="createUser.php" method="post"><table>
<tr><td>Registry:</td>  <td><select id="log" name="reg"><option value=''>--Select Registry--</option>
                  	 		<option value="CM CHILDREN">CM'S Children</option>
  							<option value="CM CIVIL">CM'S Civil</option>
  							<option value="CM CRIMINAL">CM'S Criminal</option>
  							<option value="KADHI">Kadhi</option>
							<option value="HC PROBATE">HC Probate</option>
							<option value="HC CIVIL">HC Civil</option>
							<option value="HC CRIMINAL">HC Criminal</option>
							<option value="ELRC">ELRC</option>
							<option value="ADMIN">Admin</option>
				</select> </td></tr>
<tr><td>Username:</td> <td><input type="text" name="username" id="log" placeholder="Enter Username"  required/></td></tr>
<tr><td>Password:</td> <td><input type="password" name="pass" id="log" placeholder="Enter Password"  required/></td></tr>
<tr><td>Verify Password:</td> <td><input type="password" name="pass2" id="log" placeholder="Verify Password"  required/></td></tr>
<tr><td><input type="reset" name="submit" value="Clear" id="submit"></td> <td><input type="submit" name="submit" value="Add User" id="submit"></td>				
</tr></table></form>
</fieldset>
</div>

</div>

<div id="footer">
&copy;Nyeri Law Courts:<?php echo date("Y") ?>

</body>
</html>
