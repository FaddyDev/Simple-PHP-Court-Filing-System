<!DOCTYPE html PUBLIC ?-//W3C//DTD XHTML 1.0 Strict//EN? 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:All Cases</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>

<script type="text/javascript">
function cases_delete_id(id)
{
 if(confirm('This record will be deleted parmanently.\n Are you sure you want to continue?'))
 {
  window.location.href='deleteCases.php?del='+id;
 }
 else{window.location.href='adminViewCases.php';}
}
</script>

<script type="text/javascript">
function reloadPage()
{
 window.location.href='adminViewCases.php';
}
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
   <li><a class="active" href="#">All Cases</a></li>
   <li><a href="adminViewMoved.php">Moved Cases</a> </li>
  <li><a href="signup.php">Add Users</a></li>
  <li><a href="viewUsers.php">View Users</a></li>
   <li><a href="contacts.php">Contacts</a></li>
</ul>

</div>

<div id="container">

<div id="views">
<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//Just ensuring that we only continue if the user is logged in
if (isset($_SESSION['loggedIn']) ) 
{	
$reg = $_SESSION['reg'];
//Case searching
echo "<table id='searchtable'> <tr><td><form action='adminViewCases.php' method='post'> <input type='text' id='in' name='ValueToSearch' placeholder='value to search'/> 
<input type='submit' name='search' id='btnsearch' value='Filter'/> 
</form> </td>";

$result='';

if (isset($_POST['ValueToSearch']) && $_POST['ValueToSearch']!='' ) 
{
$ValueToSearch = $_POST['ValueToSearch'];
$sql="SELECT * FROM casedetails WHERE CONCAT(case_type,case_num,letter,year,parties,date_in,rcptno,charge_sheet,judgement,status,regd_by) LIKE '%$ValueToSearch%' ORDER BY case_num";
$result=$conn->query($sql);

      if(!($result->num_rows>0)){
       //When tno case can be found with the search value entered, terminate here
       echo ("<script language='javascript'> window.alert('No case found, Search again.')</script>");
	   exit("<meta http-equiv='refresh' content='0;url=adminViewCases.php'> ");
	          }
	   else{
       $result=$conn->query($sql); }

}         
//no search
else{
$sql="SELECT * FROM casedetails ORDER BY case_num";
$result=$conn->query($sql);
}

//Select type of case to view
echo "<td><form action='adminViewCases.php' method='post'> <select  name='case'>
                  	<option value=''>Select type of case to view</option>";
					
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
					
					
				echo"	 </select> 
<input type='submit' id='btnsearch' name='view' value='View'/> 
</form> </td>  <td><button id='btnsearch' onclick='reloadPage()'>Refresh</button></td>";
if (isset($_POST['case']) && $_POST['case']!='' ) 
{
$case = $_POST['case'];
$sql="SELECT * FROM casedetails WHERE case_type='".$case."' ORDER BY case_num";
$result=$conn->query($sql);
          if(!($result->num_rows>0)){
       //When selected case type does not exist
       echo ("<script language='javascript'> window.alert('No case details.')</script>");
	   exit("<meta http-equiv='refresh' content='0;url=adminViewCases.php'> ");
	          }
	   else{
       $result=$conn->query($sql); }
}

//Select registry to view
echo "<td><form action='adminViewCases.php' method='post'><select name='reg'><option value=''>--Select Registry--</option>
                  	 		<option value='CM CHILDREN'>CM'S Children</option>
  							<option value='CM CIVIL'>CM'S Civil</option>
  							<option value='CM CRIMINAL'>CM'S Criminal</option>
  							<option value='CM PROBATE'>CM'S Probate</option>
  							<option value='KADHI'>Kadhi</option>
							<option value='HC PROBATE'>HC Probate</option>
							<option value='HC CIVIL'>HC Civil</option>
							<option value='HC CRIMINAL'>HC Criminal</option>
							<option value='ELRC'>ELRC</option>
<input type='submit' id='btnsearch' name='view' value='View'/> 
</form> </td>  <td><button id='btnsearch' onclick='reloadPage()'>Refresh</button></td>  </tr></table>";
if (isset($_POST['reg']) && $_POST['reg']!='' ) 
{
$reg = $_POST['reg'];
$sql="SELECT * FROM casedetails WHERE registry='".$reg."' ORDER BY case_num";
$result=$conn->query($sql);
       if(!($result->num_rows>0)){
       //When the registry has no registered cases
       echo ("<script language='javascript'> window.alert('The selected registry has no registered cases.')</script>");
	   exit("<meta http-equiv='refresh' content='0;url=adminViewCases.php'> ");
	          }
	   else{
       $result=$conn->query($sql); }
}


if($result->num_rows>0){
//Set up table and table heading
echo " <table border='2' cellpadding='5'><tr> <th hwidth='15%'>Registry</th>  <th hwidth='15%'>Case Type</th> <th hwidth='5%'>Number</th> <th hwidth='10%'></th> <th hwidth='10%'>of</th> <th hwidth='10%'>Parties</th> <th hwidth='10%'>Date In</th> <th hwidth='10%'>Receipt Number</th> <th hwidth='30%' >Charge sheet</th>  <th hwidth='30%' >Judgement (Ruling)</th> <th hwidth='30%' >Status</th> <th hwidth='30%' >Regd. By</th> <th hwidth='30%'>PJ No.</th> <th hwidth='10%' colspan='3'></th>  </tr>";
//Getting case details from database and display them on table in web page
while($row=$result->fetch_assoc()){
echo "<tr>
<td> ".$row["registry"]." </td>
<td> ".$row["case_type"]."</td> 
<td> ".$row["case_num"]." </td>
<td> ".$row["letter"]." </td> 

<td> ".$row["year"]." </td> 
 <td> ".$row["parties"]." </td> 
<td> ".$row["date_in"]." </td>
<td> ".$row["rcptno"]." </td>
<td>  ".$row["charge_sheet"]."</td> 

<td> ".$row["judgement"]." </td> 
<td>  <a href='print.php?print=$row[sr]'> ".$row["status"]." </a></td>
<td>  ".$row["regd_by"]."</td>
<td>  ".$row["pj"]."</td>

<td>  <a href='#?move=$row[sr]'>Move</a></td>
<td>  <a href='#?edit=$row[sr]'>Edit</a></td>
<td>  <a href='#'>Delete</a></td>
</tr>";}
echo "</table> ";

}
else{
//When case table is empty
echo ("<script language='javascript'> window.alert('No case details to be displayed')</script>");
echo "<meta http-equiv='refresh' content='0;url=signup.php'> ";}


}
else{
//When session is not set, go to home page directly
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}

?>
</div>

</div>

<div id="footer">
&copy;Nyeri Law Courts:<?php echo date("Y") ?>
</div>


</body>
</html>
