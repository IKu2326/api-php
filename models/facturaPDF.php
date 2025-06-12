<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';


class CrearPdf
{

    private $conn;
    private $pdf;
    public $logoPath;

    public function __construct()
    {
        $this->conn = Database::conectar();
        $this->pdf = new FPDF();
        $this->logoPath = __DIR__ . '/../assets/logoNVS.png';
    }


    private function txt($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    }

    public function generarPdf($ruta, $datos)
    {
        if (!file_exists($this->logoPath)) {
            return [
                "success" => false,
                "error" => "No se encontró el logo en la ruta: " . $this->logoPath,
                "logoPath" => $this->logoPath
            ];
        } else {

            $sqlFactura = "SELECT 
             p.nombreProducto,
             p.idTipoProducto,
             df.cantidadProducto,
             p.precioProducto,
             p.descuentoProducto,
             p.totalProducto,
             df.totalProducto AS totalDetalle
            FROM producto p
            JOIN detallefactura df ON p.idProducto = df.fk_pk_Producto
            WHERE df.fk_pk_Factura = :idFactura;
        ";
            $stmt = $this->conn->prepare($sqlFactura);
            $stmt->bindParam(':idFactura', $datos['facturaId'], PDO::PARAM_INT);
            $stmt->execute();

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->pdf->AddPage();

            $this->pdf->Image($this->logoPath, 10, 10, 30);
            $this->pdf->SetFont('Arial', 'B', 16);
            $this->pdf->Cell(0, 10, $this->txt('New Vision Store NVS'), 0, 1, 'C');

            $this->pdf->SetFont('Arial', '', 12);
            $this->pdf->Cell(0, 10, $this->txt("Factura No: {$datos['facturaId']} - Fecha: {$datos['fecha']}"), 0, 1, 'C');

            // Datos del cliente
            $this->pdf->Ln(5);
            $x = $this->pdf->GetX();
            $y = $this->pdf->GetY();

            // -------------------- TÍTULO COLUMNA IZQUIERDA --------------------
            $this->pdf->SetXY($x, $y);
            $this->pdf->SetFont('Arial', 'B', 12);
            $this->pdf->Cell(90, 6, 'Datos del Cliente', 0, 0, 'L');

            // -------------------- TÍTULO COLUMNA DERECHA --------------------
            $this->pdf->SetXY($x + 100, $y); // Desplaza más a la derecha
            $this->pdf->SetFont('Arial', 'B', 12);
            $this->pdf->Cell(90, 6, 'Datos de la Factura', 0, 1, 'L');
            // -------------------- CUERPO COLUMNA IZQUIERDA --------------------
            $this->pdf->SetFont('Arial', '', 11);
            $this->pdf->SetXY($x, $y + 8); // Baja después del título
            $this->pdf->MultiCell(90, 6, $this->txt("ID Cliente: {$datos['clienteId']}\nNombre: Carlos Ramírez\nCorreo: carlos@email.com | Teléfono: 3112345678\nDirección: Calle maple 123"), 0, 'L');

            // -------------------- CUERPO COLUMNA DERECHA --------------------
            $this->pdf->SetXY($x + 100, $y + 8);
            $this->pdf->MultiCell(90, 6, $this->txt("Empresa de Envio: Mensajeros Urbanos\nMétodo de pago: PayPal"), 0, 'L');

            $this->pdf->Ln(10);
            // Tabla de productos
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial', 'B', 12);
            $this->pdf->Cell(0, 8, $this->txt('Productos'), 0, 1);

            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->Cell(45, 8, $this->txt('Nombre'), 1);
            $this->pdf->Cell(30, 8, $this->txt('Tipo'), 1);
            $this->pdf->Cell(10, 8, $this->txt('Cant'), 1);
            $this->pdf->Cell(30, 8, $this->txt('Vlr. Unit.'), 1);
            $this->pdf->Cell(20, 8, $this->txt('Desc.'), 1);
            $this->pdf->Cell(30, 8, $this->txt('Vlr. c/desc.'), 1);
            $this->pdf->Cell(25, 8, $this->txt('Total'), 1);
            $this->pdf->Ln();

            $this->pdf->SetFont('Arial', '', 10);

            foreach ($productos as $producto) { 

                $this->pdf->Cell(45, 8, $this->txt($producto['nombreProducto']), 1);
                $this->pdf->Cell(30, 8, $this->txt($producto['idTipoProducto']), 1);
                $this->pdf->Cell(10, 8, $producto['cantidadProducto'], 1);
                $this->pdf->Cell(30, 8, '$' . number_format($producto['precioProducto'], 0, ',', '.'), 1);
                $this->pdf->Cell(20, 8, $producto['descuentoProducto'] . '%', 1);
                $this->pdf->Cell(30, 8, '$' . number_format($producto['totalProducto'], 0, ',', '.'), 1);
                $this->pdf->Cell(25, 8, '$' . number_format($producto['totalDetalle'], 0, ',', '.'), 1);
                $this->pdf->Ln();
            }
            // Totales
            $this->pdf->Ln(5);
            $this->pdf->SetFont('Arial', '', 11);

            $this->pdf->Cell(0, 8, $this->txt('Base Imponible: $1.842.000'), 0, 1, 'R');
            $this->pdf->Cell(0, 8, $this->txt('IVA (19%): $349.980'), 0, 1, 'R');
            $this->pdf->Cell(0, 8, $this->txt('Costo de envío: $12.000'), 0, 1, 'R');
            $this->pdf->SetFont('Arial', 'B', 11);
            $this->pdf->Cell(0, 8, $this->txt('Total a pagar: $2.049.980'), 0, 1, 'R');

            // Guardar en el servidor
            $this->pdf->Output('F', $ruta); // 'F' para File
            return [
                "success" => true,
                "rutaPDF" => $ruta,
                "logoPath" => $this->logoPath
            ];
        }
    }
}
