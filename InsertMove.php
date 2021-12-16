<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//create a PHP statement that gets the new contact details
$regyear = $_POST['regyear'];
$case = $_POST['case'];
$num = $_POST['num'];
$letter = $_POST['letter'];
$dateout = $_POST['dateout'];
$reason = $_POST['reason'];

$status = $_POST['status'];
$authname = $_POST['authname'];
$rcvname = $_POST['rcvname'];
$authpj = $_POST['authpj'];
$rcvpj = $_POST['rcvpj'];
$regfrom = $_POST['regfrom'];

//Confirm that all fields are set
if(isset($case) & isset($letter) & isset($dateout) & isset($reason) & isset($status) & isset($num) & isset($regfrom)& isset($regyear) & isset($authname) & isset($authpj) & isset($rcvname)& isset($rcvpj) ) 
{
$state='';
$from='';
//When the file is being moved
if(stripos($status,'File taken by ')===false){
$state='File taken by '.$rcvname.' on '.$dateout.'  for '.$reason.' ';
$from=$regfrom;
}
//When the file is being received
else{
$state='File received from '.$authname.'  by '.$rcvname.' on '.$dateout.' ';
$from=' '.$authname.' ';
}

//assemble insert string that allows entry of special characters
$case=mysqli_real_escape_string($conn,$case); 
$num=mysqli_real_escape_string($conn,$num); 
$letter=mysqli_real_escape_string($conn,$letter); 
$state=mysqli_real_escape_string($conn,$state); 
$reason=mysqli_real_escape_string($conn,$reason);
$regyear=mysqli_real_escape_string($conn,$regyear); 

$dateout=mysqli_real_escape_string($conn,$dateout);

$regfrom=mysqli_real_escape_string($conn,$regfrom);
$authname=mysqli_real_escape_string($conn,$authname); 
$authpj=mysqli_real_escape_string($conn,$authpj); 
$rcvname=mysqli_real_escape_string($conn,$rcvname); 
$rcvpj=mysqli_real_escape_string($conn,$rcvpj); 


//Insert the file movement details in the movement database table
$sql = "insert into movement (case_type,case_num,letter,year,date_mvd,regfrom,authname,authpj,rcvname,rcvpj,reason)  values ('".$case."','".$num."','".$letter."','".$regyear."','".$dateout."','".$from."','".$authname."','".$authpj."','".$rcvname."','".$rcvpj."','".$reason."')";
$query=mysqli_query($conn,$sql);

//Update the registry from where the case file belongs and update status as file moved to recvnames'
$sql = "UPDATE casedetails SET status='".$state."' WHERE case_num='".$num."' AND letter='".$letter."' AND registry='".$regfrom."' AND year='".$regyear."' ";

$query=mysqli_query($conn,$sql);

//save status in statuses table
$sql = "insert into statuses (registry,case_num,letter,year,mod_date,status)  values ( '".$regfrom."','".$num."','".$letter."','".$regyear."','".$dateout."','".$state."')";

$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
echo ("<script language='javascript'> window.alert('Selected case Moved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";
}
//Isset ends here
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";}

?>


