<?php

require_once './models/CalificacionesProducto.php';

class ControladorCalificacionesProducto {

    // GET: Obtener calificaciones por producto
    public static function obtenerCalificaciones() {
        $input = json_decode(file_get_contents('php://input'), true);
        $idProducto = $input['id'] ?? null;

        if (!$idProducto) {
            http_response_code(400);
            echo json_encode(['mensaje' => 'ID de producto requerido']);
            return;
        }

        $modelo = new CalificacionesProducto();
        $calificaciones = $modelo->obtenerPorProducto($idProducto);

        echo json_encode($calificaciones);
    }

    // POST: Crear nueva calificación
    public static function crearCalificacion() {
        $input = json_decode(file_get_contents('php://input'), true);

        $idCliente = $input['idCliente'] ?? null;
        $idProducto = $input['idProducto'] ?? null;
        $numeroCalificacion = $input['numeroCalificacion'] ?? null;
        $comentarioCalificacion = $input['comentarioCalificacion'] ?? '';

        if (!$idCliente || !$idProducto || $numeroCalificacion === null) {
            http_response_code(400);
            echo json_encode(['mensaje' => 'Datos incompletos']);
            return;
        }

        $modelo = new CalificacionesProducto();
        $resultado = $modelo->crearCalificacion($idCliente, $idProducto, $numeroCalificacion, $comentarioCalificacion);

        echo json_encode(['resultado' => $resultado ? 'ok' : 'error']);
    }
}
?>
