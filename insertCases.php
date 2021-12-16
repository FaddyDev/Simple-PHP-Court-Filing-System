<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//create a PHP statement that gets the new contact details
$reg = $_POST['reg'];
$regd_by = $_POST['regd_by'];
$pj = $_POST['pj'];
$case = $_POST['case'];
$letter = $_POST['letter'];
$date = $_POST['date'];
$rcpt = $_POST['rcpt'];
$charge = $_POST['charge'];
$year=date("Y");
$parties = $_POST['parties'];
$status = $_POST['status'];
$month = date("M");


//Confirm that all fields are set
if(isset($case) & isset($letter) & isset($date) & isset($rcpt) & isset($charge) & isset($parties) & isset($status) & isset($month) & isset($year) & isset($regd_by) & isset($pj) ) 
{

//Confirm that a case has been selected
if(!(empty($case))){

//confirm that receipt number is in integer form only
if(!is_numeric($rcpt) & !is_numeric($pj) )
{ 
echo ("<script language='javascript'> window.alert('Enter integers only for receipt number and pj number fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";}

else{
$casenum='';
$caseletter='';

$num='';
$prevNum='';
$currentNum='';
$sr='';
$sql="SELECT MAX(sr) FROM casedetails WHERE registry='".$reg."'";
$result=$conn->query($sql);
if($row=$result->fetch_assoc()){
$sr = $row["MAX(sr)"];
}

$sql="SELECT case_num FROM casedetails WHERE sr='".$sr."' AND registry='".$reg."' ";
$result=$conn->query($sql);

//If there exists such rows
if($result->num_rows>0){
if($row=$result->fetch_assoc()){

//fetch previous case number then add 1 to get current number
//This will help such that the user may want to register same case number but now with a letter B
$prevNum = $row["case_num"];
$currentNum = $prevNum  + 1;
}
}
else{
//When no cases at all exist
//fetch previous case number then add 1 to get current number then display to user
//This will help such that the user may want to register same case number but now with a letter B
$prevNum = 0;
$currentNum = $prevNum  + 1;
}

//If letter is not selected then increment the case number, otherwise (if letter is selected e.g as B) then use the letter and retain the previous case number.
if($letter==''){$num=$currentNum;}
else{$num=$prevNum;}



//Case numbering to start with 1 (afresh) for every new year
//Check to see if there exists any cases for the current year
$sql="SELECT * FROM casedetails WHERE year='".$year."' AND registry='".$reg."' ";
$result=$conn->query($sql);
//If there exists other cases for the year
if($result->num_rows>0){
$casenum=$num;
$caseletter=$letter;
}
else{
//When no cases exist meaning that this is the first case for the year, then start with 1 with no letter
$casenum=1;
$caseletter='';
}

//Prevent duplicate entry of cases
$sql="SELECT * FROM casedetails WHERE year='".$year."' AND registry='".$reg."' AND case_num='".$casenum."' AND letter='".$caseletter."' ";
$result=$conn->query($sql);
//If there exists other cases for the year
if($result->num_rows>0){
echo ("<script language='javascript'> window.alert('Case Number already in use.')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";
}
else{
//When no other similar case exists for the year

//assemble insert string that allows entry of special characters
$case=mysqli_real_escape_string($conn,$case); 
$casenum=mysqli_real_escape_string($conn,$casenum); 
$caseletter=mysqli_real_escape_string($conn,$caseletter); 
$year=mysqli_real_escape_string($conn,$year); 
$month=mysqli_real_escape_string($conn,$month); 
$charge=mysqli_real_escape_string($conn,$charge); 
$parties=mysqli_real_escape_string($conn,$parties); 
$date=mysqli_real_escape_string($conn,$date); 
$rcpt=mysqli_real_escape_string($conn,$rcpt); 
$status=mysqli_real_escape_string($conn,$status); 
$regd_by=mysqli_real_escape_string($conn,$regd_by);
$pj=mysqli_real_escape_string($conn,$pj); 


//If letter is selected, i.e B, we set the previous case to be letter A
if($caseletter!=''){$sql = "update casedetails set letter='A' where registry='".$reg."' and case_num='".$prevNum."' and year='".$year."' and sr='".$sr."' ";
$query=mysqli_query($conn,$sql);}


//Save info in case details table
$sql = "insert into casedetails (registry,regd_by,pj,case_type,case_num,letter,year,month,charge_sheet,parties,date_in,rcptno,status)  values ( '".$reg."','".$regd_by."','".$pj."','".$case."','".$casenum."','".$caseletter."','".$year."','".$month."','".$charge."','".$parties."','".$date."','".$rcpt."','".$status."')";

$query=mysqli_query($conn,$sql);

//save status in statuses table
$sql = "insert into statuses (registry,case_num,letter,year,mod_date,status)  values ( '".$reg."','".$casenum."','".$caseletter."','".$year."','".$date."','".$status."')";

$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
echo ("<script language='javascript'> window.alert('New case details saved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";
}

//Anti-duplicate checker ends here
}

//Integer checker ends here
}

//Empty checker ends here-that ensures a case is selected
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";}

//Isset ends here
}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=registerCases.php'> ";}

?>


