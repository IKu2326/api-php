<?php

require_once './models/ObtenerProductosPorIds.php';

class ControladorObtenerProductosPorIds {

    public static function obtenerProductosDelCarrito() {
        // Leer el cuerpo del request (espera JSON)
        $input = json_decode(file_get_contents('php://input'), true);
        $ids = $input['ids'] ?? [];

        $modelo = new ObtenerProductosPorIds();
        
        $productos = $modelo->obtenerPorIds($ids);

        echo json_encode($productos);
    }

}
