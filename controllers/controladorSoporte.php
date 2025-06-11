    <?php
    require_once './models/soporte.php';

    class ControladorSoporte
    {
        public static function enviarPQRS()
        {
            $data = json_decode(file_get_contents("php://input"), true);
            $idCliente = $data['idCliente'] ?? null;
            $fecha = $data['fecha'] ?? null;
            $pqrs = $data['pqrs'] ?? null;

            if ($idCliente && $fecha && $pqrs) {
                $soporte = new Soporte();
                $resultado = $soporte->enviarPQRS($idCliente, $fecha, $pqrs);
                if ($resultado['success'] === true) {
                    echo json_encode(['success' => true, 'mensaje' => 'PQRS enviada exitosamente']);
                } else {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'mensaje' => 'Espera respuesta a tu anterior PQRS para enviar una nueva', 'error' => $resultado['error'] ?? '']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos']);
            }
        }
    }
