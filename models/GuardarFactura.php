<?php

require_once './config/database.php';
require_once(__DIR__ . '/emailFactura.php');
require_once(__DIR__ . '/facturaPDF.php');


class GuardarFactura
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function guardarFacturaCompleta($clienteId, $subtotal, $total, $productos)
    {
        try {

            $fecha = date("Y-m-d");

            // 1. Insertar factura
            $sqlFactura = "INSERT INTO factura (fechaFactura, base, totalCompra, idCliente, idFormaPago) 
                       VALUES (:fecha, :base, :total, :clienteId, 'PSE')"; // Asumiendo forma de pago 1 (efectivo)
            $stmt = $this->conn->prepare($sqlFactura);
            $stmt->execute([
                ":fecha" => $fecha,
                ":base" => $subtotal,
                ":total" => $total,
                ":clienteId" => $clienteId
            ]);

            // Obtener ID de la factura creada
            $facturaId = $this->conn->lastInsertId();

            // 2. Insertar detalle de cada producto
            foreach ($productos as $prod) {
                $sqlDetalle = "INSERT INTO detallefactura 
                (fk_pk_Factura, fk_pk_Producto, cantidadProducto, valorUnitarioProducto, totalProducto) 
                VALUES (:facturaId, :productoId, :cantidad, :unitario, :total)";
                $stmtDetalle = $this->conn->prepare($sqlDetalle);
                $stmtDetalle->execute([
                    ":facturaId" => $facturaId,
                    ":productoId" => $prod['id'],
                    ":cantidad" => $prod['cantidad'],
                    ":unitario" => $prod['precioUnitario'],
                    ":total" => $prod['total']
                ]);

                // 3. Actualizar stock y ventas del producto
                $sqlUpdate = "UPDATE producto 
                          SET stock = stock - :cantidad, 
                              ventaProducto = ventaProducto + :cantidad 
                          WHERE idProducto = :productoId";
                $stmtUpdate = $this->conn->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ":cantidad" => $prod['cantidad'],
                    ":productoId" => $prod['id']
                ]);

                $nombreArchivo = "factura_{$facturaId}.pdf";
                $rutaArchivo = __DIR__ . '/../assets/Facturas/' . $nombreArchivo;

                $datos = [
                    'facturaId' => $facturaId,
                    'fecha' => $fecha,
                    'clienteId' => $clienteId,
                    'productos' => $productos,
                    'subtotal' => $subtotal,
                    'total' => $total
                ];

                $pdf = new CrearPdf();
                $pdfGenerado = $pdf->generarPdf($rutaArchivo, $datos);

                if (!$pdfGenerado['success']) {
                    return [
                        "success" => false,
                        "error" => "No se pudo generar el PDF. " . $pdfGenerado['error'],
                        "logoPath" => $pdfGenerado['logoPath']
                    ];
                }

                $enviarEmail = new EnviarEmail();


                $cuerpoCorreo = "
                <h1 style='font-size: 40px; padding: 0; margin: 0; text-align: center; height: 80px;'><strong>Gracias por tu compra</h1>
                <div style=' padding: 20px;'>
                <h2>Bienvenid@ a la familia NVS, ya recibimos tu pago y estamos muy felices de que nos escogieras, podras encontar el estado de tu envio y que productos compraste en el siguiente link: <a style='color:rgb(154, 85, 250);' href='https://tuairfryerchico.com.co/'>MIRA TU ESTADO DE ENVIO</a></h2> 
                <p style='font-size: 20px'; ><strong>Recuerda que puedes contáctarnos a través de nuestro correo electrónico o desde el sopórte técnico en el apartado de PQRS en nuestro aplicativo web.</p>
                <p style='font-size: 20px'><strong>En el anexo encontrarás tu factura</p>
                <p style='font-size: 20px'><strong>¡Gracias por confiar en nosotros!\n</p>
                <p style='font-size: 18px; color:rgb(102, 37, 254);'>Equipo de NVS :3</p>
                </div>
                ";

                $enviarEmail->enviarCorreo($cuerpoCorreo, $rutaArchivo);
            }
            return [
                'success' => true,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => "Error: " . $e->getMessage()
            ];
        }
    }
}
