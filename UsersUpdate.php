<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//create a PHP statement that gets the new contact details
$sr = $_POST['sr'];
$reg = $_POST['reg'];
$username = $_POST['username'];
$password = $_POST['password'];

//Confirm that all fields are set
if(isset($reg) & isset($username) & isset($password) & isset($sr) ) 
{

//Confirm that a case has been selected
if(!(empty($reg))){

//assemble insert string that allows entry of special characters
$reg=mysqli_real_escape_string($conn,$reg); 
$username=mysqli_real_escape_string($conn,$username); 
$password=mysqli_real_escape_string($conn,$password); 
$sr=mysqli_real_escape_string($conn,$sr); 

$sql = "UPDATE users SET usertype='".$reg."',username='".$username."',password='".$password."' WHERE sr='".$sr."' ";
$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
echo ("<script language='javascript'> window.alert('Selected user details updated successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewUsers.php'> ";
}

//Empty checker ends here-that ensures a case is selected
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewUsers.php'> ";}

//Isset ends here
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewUsers.php'> ";}

?>


