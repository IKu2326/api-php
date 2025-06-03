<?php

require_once './config/database.php';

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
                (fk_pk_Factura, fk_pk_Producto, cantidadProducto, valorUnitarioProducto, ivaProducto, totalProducto) 
                VALUES (:facturaId, :productoId, :cantidad, :unitario, :iva, :total)";
                $stmtDetalle = $this->conn->prepare($sqlDetalle);
                $stmtDetalle->execute([
                    ":facturaId" => $facturaId,
                    ":productoId" => $prod['id'],
                    ":cantidad" => $prod['cantidad'],
                    ":unitario" => $prod['precioUnitario'],
                    ":iva" => $prod['iva'],
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
            }

            return $facturaId;
        } catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

}

