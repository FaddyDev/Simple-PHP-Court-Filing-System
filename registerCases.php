<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Register Cases</title>
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
<body onLoad="renderTime();">

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
  <li><a class="active" href="#">Register</a></li>
  <li><a href="viewCases.php">All Cases</a></li>
  <li><a href="viewMoved.php">Moved Cases</a></li>
<li><a href="contacts.php">Contacts</a></li>
</ul>

</div>

<div id="container">

<div id="main">
<fieldset><legend>New Case Registration</legend>
<form action="insertCases.php" method="post" > 
                  <table>
				  <tr> <td>Case Number</td> <td><input type="text" onKeyPress="return numbersonly(event)" placeholder="" id="in" name="num" value="<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//Just ensuring that we only continue if the user is logged in
if (isset($_SESSION['loggedIn']) ) 
{

//Case numbering to start with 1 (afresh) for every new year
//Check to see if there exists any cases for the current year

$reg = $_SESSION['reg'];
  $year = date("Y"); 
$sql="SELECT * FROM casedetails WHERE year='".$year."' AND registry='".$reg."' ";
$result=$conn->query($sql);
//If there exists other cases for the year
if($result->num_rows>0){
//Get the maximum serial number from the database
$sr='';
$sql="SELECT MAX(sr) FROM casedetails WHERE registry='".$reg."' ";
$result=$conn->query($sql);
if($row=$result->fetch_assoc()){
$sr = $row["MAX(sr)"];
}

$sql="SELECT case_num FROM casedetails WHERE sr='".$sr."' AND registry='".$reg."' ";
$result=$conn->query($sql);

//If there exists such rows
if($result->num_rows>0){
if($row=$result->fetch_assoc()){

//fetch previous case number then add 1 to get current number then display to user
//This will help such that the user may want to register same case number but now with a letter B
$prevNum = $row["case_num"];
$currentNum = $prevNum  + 1;
//var daym = mydate.getDate();
//If current month is January then start numbering of cases from 1
echo "  ".$currentNum." ";
}
}
else{
//When no cases at all exist
//fetch previous case number then add 1 to get current number then display to user
//This will help such that the user may want to register same case number but now with a letter B
$prevNum = 0;
$currentNum = $prevNum  + 1;
//var daym = mydate.getDate();
//If current month is January then start numbering of cases from 1
echo "  ".$currentNum." ";}

}
else{
//When no cases exist meaning that this is the first case for the year, then start with 1 with no letter
echo "1";
}


}
else{
//When session is not set, go to home page directly
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}

?>" required/></td>
 

 <td>Letter:</td><td><select  name="letter">
                  	<option value=''>--Select letter--</option>
                  	 		<option value="B">B</option>
				</select></td> </tr>
				  
				  <tr><td>Type Of Case:</td><td><select  name="case" required>
				  <option value=''>--Select case--</option>
				  
				<?php //Show different case types for different registries
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
						 ?>
						 
						 
							
							 </select></td>   <td>Date In:</td> <td> <input type="text"  class="datepicker" placeholder="case registration date" name="date" onKeyDown="return false" autocomplete="off" required/></td></tr> 
					
					<tr>
                        <td>
                            Parties
                        </td>
                        <td>
                            <input type="text" placeholder="Parties involved" id="in" name="parties" required/>
                        </td>
						
						  <td>
                            Receipt No:
                        </td>
                        <td>
                            <input type="text" onKeyPress="return numbersonly(event)" placeholder="Receipt number" id="in" name="rcpt" />
                        </td>
						</tr>
		
                    <tr>
                        <td>
                            Charge Sheet:
                        </td>
                        <td> 
							<textarea  name="charge" placeholder="Record charges here" required/></textarea>
                        </td>
                        <td>
                           Status:
                        </td>
                        <td> 
							<textarea  name="status" placeholder="Current status of the case,in brief" required/></textarea>
                        </td>
					<tr><td>Regd. By:</td><td><input type="text" placeholder="Name of officer registering the case" id="in" name="regd_by" required/></td>
					<td>P.J No:</td><td><input type="text" onKeyPress="return numbersonly(event)" placeholder="P.J. No. of the officer registering the case" id="in" name="pj" required/></td></tr>
					  <tr>
					  <td><input type="hidden"  id="in" name="reg" value="<?php echo $_SESSION['reg'] ?>" />
                        </td>
						
                        <td>
                           <input type="reset" size="10" value="Clear" id="submit" />
                        </td>
					
                        <td>
                            <input type="submit" size="10" value="Save"id="submit" />
                        </td>
                    </tr>
        </table></form></fieldset>
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