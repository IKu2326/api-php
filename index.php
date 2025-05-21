<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // o 204
    exit(0);
}
require_once './controllers/controladorUsuario.php';
require_once './controllers/controladorMostrarProducto.php';
require_once './controllers/controladorDetallesProducto.php';

$ruta = trim($_GET['ruta'] ?? '');

switch ($ruta) {
    case 'registrar':
        ControladorUsuario::registrar();
        break;
    case 'login':
        ControladorUsuario::login();
        break;
    case 'obtenerProductosDesc':
        ControladorMostrarProducto::productosMasVendidos();
        break;
    case 'obtenerProductosTendencias':
        ControladorMostrarProducto::productosTendencias();
        break;
    case 'obtenerProductosExclusivos':
        ControladorMostrarProducto::productosExclusivos();
        break;
    case 'obtenerProductosOfertas':
        ControladorMostrarProducto::productosOfertas();
        break;
    case 'obtenerDetallesProducto':
        ControladorMostrarDetallesProducto::mostrarDetallesProducto();
        break;
     case 'obtenerDetallesConsola':
        ControladorMostrarDetallesProducto::mostrarDetalleConsola();
        break;
    default:
        echo json_encode(["mensaje" => "Ruta no encontrada.", "ruta_solicitada" => $ruta]);
        break;
}
