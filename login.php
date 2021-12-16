<?php
//Connect to database via another page
include_once("dbconn.php");

?>
<?php
$reg=$_POST['reg'];
$usernm=$_POST['username'];
$pass=$_POST['pass'];

//Confirm that all fields are set
if(isset($reg) & isset($usernm) & isset($pass) ) 
{
if(!(empty($reg))){

$sql="SELECT COUNT(*) FROM users WHERE(usertype='".$reg."' AND 	username='".$usernm."' AND password='".$pass."') ";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

if($result[0]>0){

session_start();
//session will stay alive for 180 seconds (3 mins)  if user stays idle
$duration=180;
$_SESSION['duration']=$duration;
$_SESSION['startTime']=time();  //Get the current time
$_SESSION['loggedIn']=$usernm;
$_SESSION['reg']=$reg;

if($reg=='ADMIN'){
header('Location:signup.php');}

else{
header('Location:registerCases.php');}

}
else{
echo ("<script language='javascript'> window.alert('Login failed, check username and password then try again')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
}


}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}

}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}

?>