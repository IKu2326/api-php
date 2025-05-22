<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // o 204
    exit(0);
}
require_once './controllers/controladorUsuario.php';
require_once './controllers/controladorMostrarProducto.php';
require_once './controllers/controladorDetallesProducto.php';
//admin
require_once './controllers/admin/controladorFormaPago.php';
require_once './controllers/admin/controladorCalificacionCliente.php';
require_once './controllers/admin/controladorCliente.php';
require_once './controllers/admin/controladorProducto.php';
require_once './controllers/admin/controladorFactura.php';
require_once './controllers/admin/controladorUsuarioAdmin.php';

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

    case 'Consultar_FormaPago':
        controladorFormaPago::consultar();
        break;
    case 'ConsultarPorID_FormaPago':
        controladorFormaPago::consultar_Id();
        break;
    case 'Crear_FormaPago':
        controladorFormaPago::crear();
        break;
    case 'Editar_FormaPago':
        controladorFormaPago::editar();
        break;
    case 'Eliminar_FormaPago':
        controladorFormaPago::eliminar();
        break;
    case 'Consultar_CalificacionCliente':
        controladorCalificacionCliente::consultar();
        break;
    case 'ConsultarPorID_CalificacionCliente':
        controladorCalificacionCliente::consultar_Id();
        break;
    case 'Crear_CalificacionCliente':
        controladorCalificacionCliente::crear();
        break;
    case 'Editar_CalificacionCliente':
        controladorCalificacionCliente::editar();
        break;
    case 'Eliminar_CalificacionCliente':
        controladorCalificacionCliente::eliminar();
        break;
    case 'Consultar_Cliente':
        controladorCliente::consultar();
        break;
    case 'ConsultarPorID_Cliente':
        controladorCliente::consultar_Id();
        break;
    case 'Crear_Cliente':
        controladorCliente::crear();
        break;
    case 'Editar_Cliente':
        controladorCliente::editar();
        break;
    case 'Eliminar_Cliente':
        controladorCliente::eliminar();
        break;
    case 'Consultar_Producto':
        controladorProducto::consultar();
        break;
    case 'ConsultarPorID_Producto':
        controladorProducto::consultar_Id();
        break;
    case 'Crear_Producto':
        controladorProducto::crear();
        break;
    case 'Editar_Producto':
        controladorProducto::editar();
        break;
    case 'Eliminar_Producto':
        controladorProducto::eliminar();
        break;
    case 'Consultar_Factura':
        controladorFactura::consultar();
        break;
    case 'ConsultarPorID_Factura':
        controladorFactura::consultar_Id();
        break;
    case 'Crear_Factura':
        controladorFactura::crear();
        break;
    case 'Editar_Factura':
        controladorFactura::editar();
        break;
    case 'Eliminar_Factura':
        controladorFactura::eliminar();
        break;
    case 'Consultar_UsuarioAdmin':
        ControladorUsuarioAdmin::consultar();
        break;
    case 'ConsultarPorID_UsuarioAdmin':
        ControladorUsuarioAdmin::consultar_Id();
        break;
    case 'Crear_UsuarioAdmin':
        ControladorUsuarioAdmin::crear();
        break;
    case 'Editar_UsuarioAdmin':
        controladorUsuarioAdmin::editar();
        break;
    case 'Eliminar_UsuarioAdmin':
        controladorUsuarioAdmin::eliminar();
        break;
    default:
        echo json_encode(["mensaje" => "Ruta no encontrada.", "ruta_solicitada" => $ruta]);
        break;
}
