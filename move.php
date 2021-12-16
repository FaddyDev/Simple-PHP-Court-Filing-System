<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Move Cases</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>

<link rel="stylesheet" href="datepicker/css/jquery-ui.css">
  <script src="datepicker/js/jquery-1.10.2.js"></script>
  <script src="datepicker/js/jquery-ui.js"></script>

 <script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat: "dd/mm/yy",maxDate: new Date()});
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
echo "You are logged in as <font color='white'>".$_SESSION['loggedIn']." </font> from <font color='white'>".$_SESSION['reg']." </font> Registry.";

// echo "<script type='text/javascript'> CountDown(10,'session')<//script> ";
}
}

?>
   
   </div>
   
   <div id="logout"> <?php echo "<form action='logout.php'> <input type='submit' id='logoutbtn' value='Log Out' /> </form>" ?> </div>
</div>
<div id="nav">

<ul>
  <li><a class="active" href="#">Move</a></li>
  <li><a href="viewMoved.php">Moved Cases</a></li>
  <li><a href="registerCases.php">Register</a></li>
  <li><a href="viewCases.php">All Cases</a></li>
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

if(isset($_GET['move']))
{
$id=$_GET['move'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);

if($result->num_rows>0){

//Getting case details from database and display them on table in web page
while($row=$result->fetch_assoc()){

//checking if the file is already moved, in which case we recieve it, else we move it
$status = $row["status"];
if(stripos($status,'File taken by ')===false){
echo "<center><h1>MOVE CASE</h1></center>";

echo "<form action='InsertMove.php' method='post'> <table>";
echo " <input type='hidden' name='case' id='in' value='".$row["case_type"]."' />
 
 <tr> <td>Case Number:</td> <td> <input type='text' name='num' id='in' value='".$row["case_num"]."' readonly=''/> </td>
 <td>Case Letter:</td> <td> <input type='text' name='letter' id='in' value='".$row["letter"]."' readonly=''/> </td></tr> 
  
 <input type='hidden' name='status' id='in' value='".$row["status"]."' /> 

<tr><td>of</td> <td> <input type='text' name='regyear' id='in' value='".$row["year"]."' readonly/> </td>
<td>Date Moved:</td> <td> <input type='text' name='dateout' class='datepicker' placeholder='Date File Moved' onKeyDown='return false' autocomplete='off' required/> </td></tr> 

<tr><td>Authorised By:</td> <td><input type='text' name='authname' id='in' placeholder='Name of Authorising officer' required/> </td>
<td>PJ NO:</td> <td><input type='text' name='authpj' id='in' placeholder='P.J Number of Authorising officer' required/> </td></tr> 
 <input type='hidden' name='regfrom' id='in' value='".$_SESSION['reg']."' required/> 

<tr><td>Received By:</td> <td><input type='text' name='rcvname' id='in' placeholder='Name of Receiving officer' required/> </td>
<td>PJ NO:</td> <td><input type='text' name='rcvpj' id='in' placeholder='P.J Number of Receiving officer' required/> </td></tr>
<tr> <td>Reason:</td> <td> <textarea name='reason' placeholder='Reason for moving the file' required/></textarea> </td>

  <td> <input type='reset' size='10' value='Clear' id='submit' /> </td>
	 <td><input type='submit' size='10' value='Move' id='submit' /></td> </tr>
</tr></table></form>";
}


else{
echo "<center><h1>RECEIVE CASE</h1></center>";

echo "<form action='InsertMove.php' method='post'> <table>";
echo " <input type='hidden' name='case' id='in' value='".$row["case_type"]."' />
 
 <tr> <td>Case Number:</td> <td> <input type='text' name='num' id='in' value='".$row["case_num"]."' readonly=''/> </td>
 <td>Case Letter:</td> <td> <input type='text' name='letter' id='in' value='".$row["letter"]."' readonly=''/> </td></tr> 
  
 <input type='hidden' name='status' id='in' value='".$row["status"]."' /> 

<tr><td>of</td> <td> <input type='text' name='regyear' id='in' value='".$row["year"]."' readonly/> </td>
<td>Date Received:</td> <td> <input type='text' name='dateout' class='datepicker' placeholder='Date File Moved' onKeyDown='return false' autocomplete='off' required/> </td></tr> 

<tr><td>Given Back By:</td> <td><input type='text' name='authname' id='in' placeholder='Name of officer returning the file' required/> </td>
<td>PJ NO:</td> <td><input type='text' name='authpj' id='in' placeholder='P.J Number of officer returning the file' required/> </td></tr> 
 <input type='hidden' name='regfrom' id='in' value='".$_SESSION['reg']."' required/> 

<tr><td>Received By:</td> <td><input type='text' name='rcvname' id='in' placeholder='Name of Receiving officer' required/> </td>
<td>PJ NO:</td> <td><input type='text' name='rcvpj' id='in' placeholder='P.J Number of Receiving officer' required/> </td></tr>
 <input type='hidden' name='reason' id='in' value='Returning file to registry' required/>

<tr> <td></td>  <td> <input type='reset' size='10' value='Clear' id='submit' /> </td>
	 <td><input type='submit' size='10' value='Recieve' id='submit' /></td> </tr>
</tr></table></form>";}
}

}
else{
//When case table is empty
echo ("<script language='javascript'> window.alert('No case details to be displayed')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";}
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
