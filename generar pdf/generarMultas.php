<?php
require('../librerias/fpdf.php');
include('../controlador/controlador.php');
$Id = $_POST['ID'];

$Con = Conectar();

$SQL = "SELECT * FROM vmultas WHERE folio = '$Id';";

$ResultSet = Ejecutar($Con,$SQL);

$Fila = mysqli_fetch_row($ResultSet);

// Clase extendida de FPDF
class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Logo
        // $this->Image('https://example.com/path/to/logo.png', 10, 6, 20);
        // Arial bold 12
        $this->SetFont('Arial', 'B', 12);
        // Título
        $this->Cell(0, 6, 'SECRETARIA DE SEGURIDAD CIUDADANA', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 6, 'SUBSECRETARIA DE POLICIA ESTATAL', 0, 1, 'C');
        $this->Ln(3);
    }

}

// Datos dinámicos (combinación de datos originales y nuevos)
$data = [
    'fecha' => $Fila[0],
    'hora' => $Fila[1],
    'folio' => $Fila[2],
    'velocimetro' => $Fila[3],
    'via' => $Fila[5],
    'km' => $Fila[6],
    'carretera' => $Fila[4],
    'nombre' => $Fila[7],
    'apellido' => $Fila[8],
    'licencia' => $Fila[9],
    'vehiculo' => $Fila[10],
    'modelo' => $Fila[12],
    'color' => $Fila[11],
    'placas' => $Fila[13],
    'infraccion' => $Fila[14],
    'leyes' => '48',
    'observaciones' => $Fila[15],
    'oficial' => $Fila[26],
    'firma' => $Fila[27],
    'pagos' => $Fila[25],
    'reporte_seccion' => $Fila[16],
    'fundamento' => $Fila[22],
    'motivo' => $Fila[17],
    'garantia_retenida' => $Fila[23],
    'no_parte_accidente' => $Fila[18],
    'convenio' => $Fila[24],
    'puesto_disposicion' => $Fila[19],
    'deposito_oficial' => $Fila[25],
    'observa_operativo' => $Fila[20],
    'observa_conductor' => '1',
    'calificacion_boleta' => $Fila[21]
];

// Crea una instancia de la clase PDF con tamaño personalizado
$pdf = new PDF('P', 'mm', array(150, 210));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);

// Colores y estilo
$pdf->SetDrawColor(50, 60, 100);
$pdf->SetFillColor(230, 230, 250);

// Sección 1: Datos Generales
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Datos Generales", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$cellWidth = 65;

$pdf->Cell($cellWidth, 6, "Fecha: {$data['fecha']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Hora: {$data['hora']}", 1, 1);
$pdf->Cell($cellWidth, 6, "No. de Folio: {$data['folio']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Velocímetro: {$data['velocimetro']}", 1, 1);
$pdf->Cell($cellWidth, 6, "Vía: {$data['via']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Km: {$data['km']}", 1, 1);
$pdf->Cell(0, 6, "Carretera: {$data['carretera']}", 1, 1);

// Sección 2: Datos del Infractor
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Datos del Infractor", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell($cellWidth, 6, "Nombre: {$data['nombre']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Apellido: {$data['apellido']}", 1, 1);
$pdf->Cell(0, 6, "Licencia: {$data['licencia']}", 1, 1);

// Sección 3: Datos del Vehículo
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Datos del Vehículo", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell($cellWidth, 6, "Vehículo: {$data['vehiculo']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Modelo: {$data['modelo']}", 1, 1);
$pdf->Cell($cellWidth, 6, "Color: {$data['color']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Placas: {$data['placas']}", 1, 1);

// Sección 4: Descripción de la Infracción
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Descripción de la Infracción", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->MultiCell(0, 6, "Infracción: {$data['infraccion']}", 1);
$pdf->Cell(0, 6, "Artículo/Leyes: {$data['leyes']}", 1, 1);
$pdf->MultiCell(0, 6, "Observaciones: {$data['observaciones']}", 1);

// Sección 5: Información adicional de la multa
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Información adicional de la multa", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell($cellWidth, 6, "Reporte Sección: {$data['reporte_seccion']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Fundamento: {$data['fundamento']}", 1, 1);
$pdf->Cell($cellWidth, 6, "Motivo: {$data['motivo']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Garantía Retenida: {$data['garantia_retenida']}", 1, 1);
$pdf->Cell($cellWidth, 6, "No. Parte Accidente: {$data['no_parte_accidente']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Convenio: {$data['convenio']}", 1, 1);
$pdf->Cell($cellWidth, 6, "Puesto Disposición: {$data['puesto_disposicion']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Total a pagar en MXN: {$data['deposito_oficial']}", 1, 1);
$pdf->MultiCell(0, 6, "Observaciones Operativo: {$data['observa_operativo']}", 1);
$pdf->MultiCell(0, 6, "Calificación Boleta: {$data['calificacion_boleta']}", 1);

// Sección 6: Datos del Oficial
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Datos del Oficial", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell($cellWidth, 6, "Nombre del Oficial: {$data['oficial']}", 1, 0);
$pdf->Cell($cellWidth, 6, "Firma: {$data['firma']}", 1, 1);

// Sección 7: Información de Pago
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Información de Pago", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(0, 6, "Horarios de Pago: {$data['pagos']}", 1, 1);

// Salida del PDF
$pdf->Output('I', 'multa_mexicana.pdf');
?>
