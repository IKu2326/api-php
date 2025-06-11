<?php


require_once __DIR__ . '/../vendor/autoload.php';



class CrearPdf
{

    private $pdf;

    public function __construct()
    {
        $this->pdf = new FPDF();
    }


   public function generarPdf($ruta)
{
    $this->pdf->AddPage();
    $this->pdf->SetFont('Arial', 'B', 16);
    $this->pdf->Cell(0, 10, '¡Hola mundo desde un PDF en PHP!', 0, 1, 'C');
    $this->pdf->SetFont('Arial', '', 12);
    $this->pdf->Cell(0, 10, 'Este es un PDF generado con FPDF.', 0, 1);

    // Guardar en el servidor
    $this->pdf->Output('F', $ruta); // 'F' para File
    return true;
}
}
