<?php

require_once './models/GuardarFactura.php';

class ControladorGuardarFactura {
    public static function guardarFactura() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['productos'], $data['clienteId'], $data['subtotal'], $data['total'])) {
            echo json_encode(["error" => "Datos incompletos."]);
            return;
        }

        $factura = new GuardarFactura();
        $idGenerada = $factura->guardarFacturaCompleta(
            $data['clienteId'],
            $data['subtotal'],
            $data['total'],
            $data['productos']
        );

        if ($idGenerada) {
            echo json_encode(["mensaje" => "Factura guardada correctamente", "idFactura" => $idGenerada]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al guardar la factura."]);
        }
    }
}

