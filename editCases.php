<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Edit Cases</title>
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
  <li><a class="active" href="#view">Edit Case</a></li>
  <li><a href="registerCases.php">Register</a></li>
  <li><a href="viewCases.php">All Cases</a></li>
  <li><a href="viewMoved.php">Moved Cases</a></li>
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
$reg = $_SESSION['reg'];

if(isset($_GET['edit']))
{
$id=$_GET['edit'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);

if($result->num_rows>0){
//Heading
echo "<center><h1>UPDATE STATUS</h1></center>";
//Getting case details from database and display them on table in web page
while($row=$result->fetch_assoc()){
echo "<form action='updateCases.php' method='post'> <table>";
echo "<tr> <td>Case Type:</td> <td><select  name='case' required>
                  	<option value='".$row["case_type"]."'>".$row["case_type"]."</option>";
					
					if($reg=='CM CRIMINAL' || $reg=='HC CRIMINAL' ){
                  echo " <option value='Criminal'>CM's Criminal Cases</option>
                  	 		<option value='Traffic'>Traffic</option>
  							<option value='Misc'>Miscellaneous</option>
  							<option value='Sexual Offence'>Sexual Offence</option>
  							<option value='Inquist'>Inquist</option>
  							<option value='Anti-Corruption'>Anti-Corruption</option>
						";}
						
						//CM Civil cases
						else if($reg=='CM CIVIL'){
                  echo "	<option value='Civil'>Civil Case</option>
  							<option value='Misc'>Misc</option>
  							<option value='Divorce'>Divorce</option>
						";}
						
						//CM CHILDREN cases
						else if($reg=='CM CHILDREN'){
                  echo "	<option value='Children'>Children case</option>
  							<option value='PnC'>Protection and Care</option>
  							<option value='Divorce'>Divorce</option>
						";}
						
						//Kadhi's court cases
						else if($reg=='KADHI'){
                  echo "	<option value='Kadhi'>Kadhi</option>
						";}
						
						//HC PROBATE cases
						else if($reg=='HC PROBATE'){
                  echo "	<option value='Adoption'>Adoption</option>
				  			<option value='SUCC'>Succession</option>
							<option value='DIV'>Divorce</option>
							<option value='MISC'>Misc</option>
							<option value='PnA Appeals'>PnA Appeals</option>
						";}
						
						//HC CIVIL Cases
						else if($reg=='HC CIVIL'){
                  echo "	<option value='ELC'>ELC</option>
				  			<option value='ELCA'>ELCA</option>
							<option value='ELCJR'>ELCJR</option>
							<option value='ELC Misc'>ELC Misc</option>
							<option value='ELC petition'>ELC petition</option>
							<option value='HCCC'>HCCC</option>
							<option value='HCCA'>HCCA</option>
							<option value='Misc'>Misc</option>
							<option value='JR'>JR</option>
							<option value='Petition'>Petition</option>
						";}
						
						//ELRC Cases
							else if($reg=='ELRC'){
                  echo "	<option value='Causes'>Causes</option>
				  			<option value='Misc'>Misc</option>
							<option value='ELCJR'>Petitions</option>
							<option value='JR'>Judicial Reveiws</option>
							<option value='Awards'>Awards</option>
							<option value='CBA'>CBA</option>
							<option value='Appeals'>Appeals</option>
						";}
					
					
				echo"	 </select> </td>
 <td>Case Number:</td> <td> <input type='text' name='num' id='in' value='".$row["case_num"]."' readonly='' required/> </td></tr> 
<tr> <td>Case Letter:</td> <td> <select name='letter'>
                  	<option value='".$row["letter"]."'>".$row["letter"]."</option>
				</select> </td>
 <td>Parties:</td> <td> <input type='text' name='parties' id='in' value='".$row["parties"]."' required/> </td></tr> 
<tr> <td>Date In:</td> <td> <input type='text' name='date' class='datepicker' value='".$row["date_in"]."' onKeyDown='return false' autocomplete='off' required/> </td> 
 <td>Receipt No:</td> <td> <input type='text' onKeyPress='return numbersonly(event)' name='rcpt' id='in' value='".$row["rcptno"]."'/> </td></tr>
<tr> <td>Charge Sheet:</td> <td> <textarea name='charge' required/>".$row["charge_sheet"]."</textarea> </td>  
 <td>Judgement:</td> <td> <textarea name='judgement'  />".$row["judgement"]."</textarea> </td></tr>
<tr> <td>Status:</td> <td> <textarea name='status' required/>".$row["status"]."</textarea> </td>
  <input type='hidden' name='oriji_state' id='in' value='".$row["status"]."' readonly=''/> 
 <td>Regd. By:</td> <td> <input type='text' name='regd_by' id='in' value='".$row["regd_by"]."' readonly='' required/> </td></tr>

 <td> <input type='hidden' name='reg' id='in' value='".$row["registry"]."' /> </td></tr>

<tr> <td><input type='hidden' name='year' id='in' value='".$row["year"]."' /></td>
 <tr><td>P.J. No:</td> <td><input type='text' name='pj' id='in' value='".$row["pj"]."' required/></td></tr>
 <tr><td></td> <td> <input type='reset' size='10' value='Clear' id='submit' /> </td>
	 <td><input type='submit' size='10' value='Update' id='submit' /></td> </tr>
</tr></table></form>";}

}
else{
//When case table is empty
echo ("<script language='javascript'> window.alert('No case details to be displayed')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";}
}

}
else{
//When session is not set, go to home page directly
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}
?>
</div>

<div id="side">
<img src="images/Court.png" width="320" height="312"/>
</div>

</div>

<div id="footer">
&copy;Nyeri Law Courts:<?php echo date("Y") ?>
</div>


</body>
</html>
