<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NLC:Users</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>

<script type="text/javascript">
function users_delete_id(id)
{
 if(confirm('This record will be deleted parmanently.\n Are you sure you want to continue?'))
 {
  window.location.href='deleteUsers.php?del='+id;
 }
 else{window.location.href='viewUsers.php';}
}

</script>
<script type="text/javascript">
function reloadPage()
{
 window.location.href='viewUsers.php';
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
  <li><a class="active" href="#">View Users</a></li>
  <li><a href="signup.php">Add Users</a></li>
   <li class="dropdown">
    <a href="#" class="dropbtn">Cases</a>
    <div class="dropdown-content">
      <a href="adminViewCases.php">All Cases</a>
     <a href="adminViewMoved.php">Moved Cases</a>
    </div>
  </li>
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
//Heading
echo "<center><h3>USERS DETAILS</h3></center>";

//User searching
echo "<table> <tr><td><form action='viewUsers.php' method='post'> <input type='text' id='in' name='ValueToSearch' placeholder='value to search'/> 
<input type='submit' name='search' id='btnsearch' value='Filter'/> 
</form> </td>";

$result='';

if (isset($_POST['ValueToSearch']) && $_POST['ValueToSearch']!='' ) 
{
$ValueToSearch = $_POST['ValueToSearch'];
$sql="SELECT * FROM users WHERE CONCAT(usertype,username,password) LIKE '%$ValueToSearch%' ORDER BY usertype";
$result=$conn->query($sql);

      if(!($result->num_rows>0)){
       //When no user details are found
       echo ("<script language='javascript'> window.alert('No users found, Search again.')</script>");
	   exit("<meta http-equiv='refresh' content='0;url=viewUsers.php'> ");
	          }
	   else{
       $result=$conn->query($sql); }

}         
//no search
else{
$sql="SELECT * FROM users ORDER BY usertype";
$result=$conn->query($sql);
}

//view by registry/usertype
echo "<td><form action='viewUsers.php' method='post'><select name='reg'><option value=''>--Select Registry--</option>
                  	 		<option value='CM CHILDREN'>CM'S Children</option>
  							<option value='CM CIVIL'>CM'S Civil</option>
  							<option value='CM CRIMINAL'>CM'S Criminal</option>
  							<option value='CM PROBATE'>CM'S Probate</option>
  							<option value='KADHI'>Kadhi</option>
  							<option value='CM TRAFFIC'>CM'S Traffic</option>
							<option value='HC PROBATE'>HC Probate</option>
							<option value='HC CIVIL'>HC Civil</option>
							<option value='HC CRIMINAL'>HC Criminal</option>
							<option value='ELRC'>ELRC</option>
							<option value='ADMIN'>ADMIN</option>
<input type='submit' id='btnsearch' name='view' value='View'/> 
</form> </td>  <td><button id='btnsearch' onclick='reloadPage()'>Refresh</button></td>  </tr></table>";
if (isset($_POST['reg']) && $_POST['reg']!='' ) 
{
$reg = $_POST['reg'];
$sql="SELECT * FROM users WHERE usertype='".$reg."' ORDER BY usertype";
$result=$conn->query($sql);
       if(!($result->num_rows>0)){
       //When the registry has no registered cases
       echo ("<script language='javascript'> window.alert('The selected registry has no registered users details.')</script>");
	   exit("<meta http-equiv='refresh' content='0;url=viewUsers.php'> ");
	          }
	   else{
       $result=$conn->query($sql); }
}
 
if($result->num_rows>0){

//Set up table and table heading
echo " <table border='2' id='userstable' cellpadding='5'><tr>  <th hwidth='15%'>Registry</th> <th hwidth='5%'>UserName</th> <th hwidth='10%'>Password</th> <th colspan='2' hwidth='10%'></th> </tr>";
//Getting case details from database and display them on table in web page
while($row=$result->fetch_assoc()){
echo "<tr> 
<td> ".$row["usertype"]."</td> 
<td> ".$row["username"]." </td>
<td> ".$row["password"]." </td> 

<td>  <a href='editUsers.php?edit=$row[sr]'>Edit</a></td>
<td>  <a href='javascript:users_delete_id($row[sr])'>Delete</a></td> 
</tr>";}
echo "</table> ";

}
else{
//When case table is empty
echo ("<script language='javascript'> window.alert('No Users In The Database')</script>");
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
