<?php
require_once './models/soporte.php';

class ControladorSoporte {
    public static function enviarPQRS() {
        $data = json_decode(file_get_contents("php://input"), true);
        $idCliente = $data['idCliente'] ?? null;
        $fecha = $data['fecha'] ?? null;
        $pqrs = $data['pqrs'] ?? null;

        if ($idCliente && $fecha && $pqrs) {
            $soporte = new Soporte();
            $resultado = $soporte->enviarPQRS($idCliente, $fecha, $pqrs);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        }
    }
}
