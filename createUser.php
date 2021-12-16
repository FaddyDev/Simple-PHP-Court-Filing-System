<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//Confirm that all fields are set
if(isset($_POST['reg']) & isset($_POST['username']) & isset($_POST['pass']) & isset($_POST['pass2']) ) 
{
//Confirm that all fields are filled (Not empty)
if(!(empty($_POST['reg']) || empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['pass2']) )){


//create an IF statement that ensures that the two password entries are equal

if(($_POST['pass'])!= ($_POST['pass2']))
{
echo ("<script language='javascript'> window.alert('Passwords do not match')</script>");
echo "<meta http-equiv='refresh' content='0;url=signup.php'> ";
	}	
else{
//create a PHP statement that gets the new user details
$usertype = $_POST['reg'];
$username = $_POST['username'];
$pass = $_POST['pass2'];

//assemble insert string 
$usertype=mysqli_real_escape_string($conn,$usertype);
$username=mysqli_real_escape_string($conn,$username);
$pass=mysqli_real_escape_string($conn,$pass);

$sql = "insert into users (usertype,username,password)  values ( '".$usertype."','".$username."','".$pass."')";

$query=mysqli_query($conn,$sql);

if(!$query) {die("Not submitted, Try again      ".mysqli_error($conn));}
else{

echo ("<script language='javascript'> window.alert('New User Added Successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=signup.php'> ";
}


}

}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=signup.php'> ";}
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=signup.php'> ";}

?>


