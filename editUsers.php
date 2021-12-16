<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Edit Users</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>

<link rel="stylesheet" href="datepicker/css/jquery-ui.css">
  <script src="datepicker/js/jquery-1.10.2.js"></script>
  <script src="datepicker/js/jquery-ui.js"></script>

 <script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat: "dd/mm/yy",minDate: new Date()});
  });
  </script>
  

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
  <li><a class="active" href="#view">Edit Users</a></li>
   <li class="dropdown">
    <a href="#" class="dropbtn">View Cases</a>
    <div class="dropdown-content">
      <a href="adminViewCases.php">All Cases</a>
     <a href="adminViewMoved.php">Moved Cases</a>
    </div>
  </li>
  <li><a href="signup.php">Register Users</a></li>
  <li><a href="viewUsers.php">View Users</a></li>
<li><a href="contacts.php">Contacts</a></li>
  </ul>
</div>

<div id="container">

<div id="main">
<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//Just ensuring that we only continue if the user is logged in
if (isset($_SESSION['loggedIn']) ) 
{


if(isset($_GET['edit']))
{
$id=$_GET['edit'];
$sql="SELECT * FROM users WHERE sr='".$id."' ";
$result=$conn->query($sql);

if($result->num_rows>0){
//Heading
echo "<center><h1>EDIT USERS</h1></center>";
//Getting case details from database and display them on table in web page
while($row=$result->fetch_assoc()){
echo "<form action='UsersUpdate.php' method='post'> <table>";
echo "<tr> <td>User Type:</td> <td><select  name='reg'>
                  	<option value='".$row["usertype"]."'>".$row["usertype"]."</option>
						<option value='CM CHILDREN'>CM'S Children</option>
  							<option value='CM CIVIL'>CM'S Civil</option>
  							<option value='CM CRIMINAL'>CM'S Criminal</option>
  							<option value='KADHI'>Kadhi</option>
  							<option value='CM TRAFFIC'>CM'S Traffic</option>
							<option value='HC PROBATE'>HC Probate</option>
							<option value='HC CIVIL'>HC Civil</option>
							<option value='HC CRIMINAL'>HC Criminal</option>
							<option value='ELRC'>ELRC</option>
							<option value='ADMIN'>Admin</option> </select></td></tr>
 <tr><td>User Name:</td> <td> <input type='text' name='username' id='in' value='".$row["username"]."' required/> </td></tr> 
 <tr><td>Password:</td> <td> <input type='text' name='password' id='in' value='".$row["password"]."' required/> </td></tr> 
<input type='hidden' name='sr' value='".$id."'/>

<tr> <td> <input type='reset' size='10' value='Clear' id='submit' /> </td>
	 <td><input type='submit' size='10' value='Update' id='submit' /></td> </tr>
</tr></table></form>";}

}
else{
//When case table is empty
echo ("<script language='javascript'> window.alert('No users to be displayed')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewUsers.php'> ";}
}


}
else{
//When session is not set, go to home page directly
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}
?>
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
