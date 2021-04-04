<?php
require('../fpdf/fpdf.php');
include_once'../db/connect_db.php';

$identificacion = $_GET['ci'];
$select = $pdo->prepare("SELECT * FROM tbl_user WHERE identificacion='$identificacion'");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P','mm', array(100,150));

$pdf->AddPage();
//
$pdf->SetFont('Arial','B',16);
$pdf->Cell(100,10,'CUENTA',0,1,'C');
//
$pdf->Line(10,18,100,18);
$pdf->Line(10,19,100,19);

$pdf->SetY(31);

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'Usuario:      ',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,4 ,$row->username,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'correo:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->correo,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'numerodecuenta:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->numerodecuenta,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'identificacion:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->identificacion,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'nombre:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->nombre,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'apellido:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->apellido,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'tipodecuenta:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->tipodecuenta,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'direccion:',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,10 ,$row->direccion,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'Fecha : ',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(21,10 ,$row->fecha,0,0,'C');
//////////////////////////////////////////////
$pdf->SetY(55);
$pdf->Line(10,18,100,18);
$pdf->SetY(120);
$pdf->SetX(7);
$pdf->SetFont('Arial','BU',5);
$pdf->Cell(10,4 ,'FIRMA del ciente',10,1,'C');

$pdf->SetY(120);
$pdf->SetX(7);
$pdf->SetFont('Arial','BU',5);
$pdf->Cell(100,4 ,'FIRMA del gerente',10,1,'C');




$pdf->Output();

