<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//create a PHP statement that gets the new contact details
$year = $_POST['year'];
$reg = $_POST['reg'];
$regd_by = $_POST['regd_by'];
$pj = $_POST['pj'];
$case = $_POST['case'];
$num = $_POST['num'];
$letter = $_POST['letter'];
$date = $_POST['date'];
$rcpt = $_POST['rcpt'];
$charge = $_POST['charge'];
$judgement = $_POST['judgement'];

$parties = $_POST['parties'];
$status = $_POST['status'];
$oriji_state = $_POST['oriji_state'];


//Confirm that all fields are set
if(isset($case) & isset($letter) & isset($date) & isset($rcpt) & isset($charge) & isset($parties) & isset($status) & isset($num) & isset($judgement) & isset($regd_by) & isset($pj) & isset($year) ) 
{

//assemble insert string that allows entry of special characters
$case=mysqli_real_escape_string($conn,$case); 
$num=mysqli_real_escape_string($conn,$num); 
$letter=mysqli_real_escape_string($conn,$letter);  
$judgement=mysqli_real_escape_string($conn,$judgement);
$charge=mysqli_real_escape_string($conn,$charge); 
$parties=mysqli_real_escape_string($conn,$parties); 
$date=mysqli_real_escape_string($conn,$date); 
$rcpt=mysqli_real_escape_string($conn,$rcpt); 
$status=mysqli_real_escape_string($conn,$status);
$oriji_state=mysqli_real_escape_string($conn,$oriji_state); 
$regd_by=mysqli_real_escape_string($conn,$regd_by); 
$pj=mysqli_real_escape_string($conn,$pj);
$year=mysqli_real_escape_string($conn,$year);


$sql = "UPDATE casedetails SET case_type='".$case."',regd_by='".$regd_by."',pj='".$pj."',case_num='".$num."',letter='".$letter."',charge_sheet='".$charge."',parties='".$parties."',date_in='".$date."',rcptno='".$rcpt."',status='".$status."',judgement='".$judgement."' WHERE case_num='".$num."' AND letter='".$letter."' AND registry='".$reg."' AND year='".$year."' ";

$query=mysqli_query($conn,$sql);

//save status in statuses table
if($oriji_state!==$status){
$date=date("d/m/Y");
$sql = "insert into statuses (registry,case_num,letter,year,mod_date,status)  values ( '".$reg."','".$num."','".$letter."','".$year."','".$date."','".$status."')";}

$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
echo ("<script language='javascript'> window.alert('Selected case details updated successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";
}

//Isset ends here
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";}

?>


