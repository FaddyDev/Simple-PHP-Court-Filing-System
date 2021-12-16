
<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
if(isset($_GET['del']))
{
$num='';
$letter='';
$id=$_GET['del'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);
if($row=$result->fetch_assoc()){
$num = $row["case_num"];
$letter = $row["letter"];
}

//Since sr(serial) is unique, it will only delete the specific registry's case
$sql="DELETE FROM casedetails WHERE case_num='".$num."' AND letter='".$letter."' AND sr='".$id."' ";
//$result=mysqli_query($sql) or die("Could not delete".mysqli_error());
$result=$conn->query($sql);
echo ("<script language='javascript'> window.alert('Deleted successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=viewCases.php'> ";
}

?>