<?php
//Connect to database via another page
include_once("dbconn.php");
?>

<?php
//PDF USING MULTIPLE PAGES

require('fpdf/fpdf.php');

//Create new pdf file

$pdf=new FPDF();
if(isset($_GET['print']))
{
$pdf->SetAutoPageBreak(false);

//Add page
$pdf->AddPage("P","A4");
$year='';
$num='';
$letter='';
$mod_date='';
$status='';



$id=$_GET['print'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);

while($row=$result->fetch_assoc()){
$year = $row["year"];
$reg = $row["registry"];
$regd_by = $row["regd_by"];
$pj = $row["pj"];
$case = $row["case_type"];
$num = $row["case_num"];
$letter = $row["letter"];
$date = $row["date_in"];
$rcpt = $row["rcptno"];
$charge = $row["charge_sheet"];
$judgement = $row["judgement"];
$parties = $row["parties"];


//Covert case to uppercase
$case = strtoupper($case);

//Print heading/title
$pdf->SetFont("Times","U","14");
$pdf->SetX(90);
$pdf->Cell(10,8,"NYERI LAW COURTS",0,1,"C");
$pdf->SetX(90);
$pdf->Cell(10,8," PROCEEDINGS OF  ".$reg." REGISTRY ".$case." CASE ",0,2,"C");
$pdf->SetX(90);
$pdf->Cell(10,8,"NUMBER ".$num." ".$letter." of  ".$year.", REGISTERED ON ".$date.".",0,2,"C");

$pdf->SetX(10);
//1st row, Registered by
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Regd. By:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$regd_by."",1);

//2nd row, P.J No.
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"P.J. No:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$pj."",1);


//3rd row, Parties
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Parties:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$parties."",1);

//4th row, Charge
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Charge:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$charge."",1);

//5th row, Judgement
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Judgement:",0);
$pdf->setXY($x+30,$y);
//if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$judgement."",1);


//5 blank lines below
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setXY($x,$y+5);

$pdf->SetFont("","B","14");
$pdf->Cell(150,8,"STATUS",1,0,"C",FALSE);
$pdf->Cell(40,8,"CHANGED ON",1,1,"C",FALSE);

//initialize counter
$rowCount=0;
$sql="SELECT COUNT(*) FROM statuses WHERE case_num='".$num."' AND letter='".$letter."' AND year='".$year."' ORDER BY sr";
$result=$conn->query($sql);
while($row = mysqli_fetch_array($result))
{
$rowCount = $row["COUNT(*)"];}

//create for loop to print all rows in the table
for(($i = 0);($i < $rowCount); ($i++)){

$sql="SELECT * FROM statuses WHERE case_num='".$num."' AND letter='".$letter."' AND year='".$year."' ORDER BY sr";
$result=$conn->query($sql);


while($row = mysqli_fetch_array($result))
{
$pdf->SetFillColor(255,255,255);
$pdf->SetFont("","","11");	

$mod_date = $row["mod_date"];
$status = $row["status"];

$pdf->SetFont("","","14");

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(150,8,"".$status."",1);
$h = $pdf->GetY();
$pdf->setXY($x+150,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(40,$h,"".$mod_date."",1,"C",1);


//To force page break when cell height is larger than space left at the bottom
$height_of_cell = 20; // mm
$page_height = 286.93; // mm (portrait letter)
$bottom_margin = -5; // mm
  for($i=0;$i<=100;$i++) :
    $block=floor($i/6);
    $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
      if ($i/6==floor($i/6) && $height_of_cell > $space_left) {
        $pdf->AddPage(); // page break
      }
  endfor;

//for loop ends here
}

mysqli_close($conn);

//Send file
$pdf->Output();
//While loop ends here
}
//isset ends here
}

}
?>


