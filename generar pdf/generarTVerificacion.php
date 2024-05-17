<?php
require('../librerias/fpdf.php');

include("../controlador/controlador.php");
$Id = $_POST['ID'];

$Con = Conectar();

$SQL = "SELECT * FROM vverficiacionesultra WHERE mamalon = '$Id';";

$ResultSet = Ejecutar($Con,$SQL);

$Fila = mysqli_fetch_row($ResultSet);

Desconectar($Con);

$pdf = new FPDF('L','mm',array(279, 150)); 
$pdf->AddPage();

$pdf->SetXY(20, 30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,'DATOS DEL VEHICULO',0,1,'L');

$pdf->SetXY(20, 35);
$pdf->SetFont('Arial','',10);

$pdf->Cell(100,5,'TIPO DE SERVICIO',0,0);
$pdf->SetXY(80, 35);
$pdf->Cell(0,5,$Fila[6],0,1);

$marca = explode(" ", $Fila[27]);

$pdf->SetXY(20, 40);
$pdf->Cell(100,5,'MARCA',0,0);
$pdf->SetXY(80, 40);
$pdf->Cell(0,5,$marca[0],0,1);

$pdf->SetXY(20, 45);
$pdf->Cell(100,5,'SUBMARCA',0,0);
$pdf->SetXY(80, 45);
$pdf->Cell(0,5,$marca[1],0,1);


$pdf->SetXY(20, 50);
$pdf->Cell(100,5,'MODELO',0,0);
$pdf->SetXY(80, 50);
$pdf->Cell(0,5,$Fila[24],0,1);

$pdf->SetXY(20, 55);
$pdf->Cell(100,5,'PLACAS',0,0);
$pdf->SetXY(80, 55);
$pdf->Cell(0,5,$Fila[28],0,1);

// Espacio entre secciones
$pdf->Ln(5);

// Segundo dato
$pdf->SetXY(160, 35);
$pdf->Cell(0,5,'NUMERO DE SERIE:',0,0);
$pdf->SetXY(210, 35);
$pdf->Cell(0,5,$Fila[13],0,1);
$pdf->SetXY(160, 40);
$pdf->Cell(0,5,'CLASE:',0,0);
$pdf->SetXY(210, 40);
$pdf->Cell(0,5,$Fila[20],0,1);
$pdf->SetXY(160, 45);
$pdf->Cell(0,5,'TIPO COMBUSTIBLE:',0,0);
$pdf->SetXY(210, 45);
$pdf->Cell(0,5,$Fila[18],0,1);
$pdf->SetXY(160, 50);
$pdf->Cell(0,5,'NIV:',0,0);
$pdf->SetXY(210, 50);
$pdf->Cell(0,5,$Fila[25],0,1);
$pdf->SetXY(160, 55);
$pdf->Cell(0,5,'NUM CILINDRAJE:',0,0);
$pdf->SetXY(210, 55);
$pdf->Cell(0,5,$Fila[13],0,1);
$pdf->SetXY(160, 60);
$pdf->Cell(0,5,'TIPO CARROCERIA:',0,0);
$pdf->SetXY(210, 60);
$pdf->Cell(0,5,$Fila[21],0,1);
$pdf->SetXY(160, 68);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,'ENTIDAD FEDERATIVA:',0,0);
$pdf->SetXY(210, 68);
$pdf->Cell(0,5,$Fila[11],0,1);
$pdf->SetXY(160, 73);
$pdf->Cell(0,5,'MUNICIPIO:',0,0);
$pdf->SetXY(210, 73);
$pdf->Cell(0,5,$Fila[10],0,1);

// Espacio entre secciones
$pdf->Ln(5);

// Tercer dato
$pdf->SetX(20);
$pdf->Cell(0,5,'NO. DEL CENTRO:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[2],0,1);
$pdf->SetFont('Arial','',10);
$pdf->SetX(20);
$pdf->Cell(0,5,'NO. DE LINEA DE VERICACION:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,'LINEA 1',0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'TECNICO:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[3],0,1);
$pdf->SetX(20);

$fecha = date("Y-m-d");
$pdf->Cell(0,5,'FECHA:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$fecha,0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'HORA ENTRADA:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[4],0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'HORA SALIDA:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[5],0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'MOTIVO:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[29],0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'FOLIO:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[1],0,1);
$pdf->SetX(20);
$pdf->Cell(0,5,'SEMESTRE:',0,0);
$pdf->SetX(100);
$pdf->Cell(0,5,$Fila[8],0,1);

$pdf->SetXY(215,90);
$pdf->Cell(0,5,'FOLIO:',0,0);
$pdf->SetXY(215,95);
$pdf->Cell(0,5,$Fila[0],0,1);

$pdf->SetXY(215,100);
$pdf->Cell(0,5,'VIGENCIA:',0,0);
$pdf->SetXY(215,105);
$pdf->Cell(0,5,$Fila[7],0,1);

$pdf->Image('F2.png', 10, 5, 60, 15); 
$pdf->Image('letras.png', 80, 5, 140, 15); 
$pdf->Image('qr.png', 170, 80, 35, 35); 
$pdf->Image('barras1.png', 160, 120, 90, 15); 
$pdf->Image('banner.png', 0, 140, 280, 5); 
$pdf->Output('I','TarjetaVericacion.pdf');
?>
