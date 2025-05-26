<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // o 204
    exit(0);
}
require_once './controllers/controladorUsuario.php';
require_once './controllers/controladorMostrarProducto.php';
require_once './controllers/controladorDetallesProducto.php';
require_once './controllers/controladorObtenerProductosPorIds.php';
require_once './controllers/ControladorCalificacionesProducto.php';
//admin
require_once './controllers/admin/controladorFormaPago.php';
require_once './controllers/admin/controladorCalificacionCliente.php';
require_once './controllers/admin/controladorCliente.php';
require_once './controllers/admin/controladorProducto.php';
require_once './controllers/admin/controladorFactura.php';
require_once './controllers/admin/controladorUsuarioAdmin.php';
require_once './controllers/admin/controladorAdministrador.php';
require_once './controllers/admin/controladorRol.php';
require_once './controllers/admin/controladorTipoDoc.php';

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
    case 'obtenerCarrito':
        ControladorObtenerProductosPorIds::obtenerProductosDelCarrito();
        break;
    case 'obtenerCalificacionesProducto':
        ControladorCalificacionesProducto::obtenerCalificaciones();
        break;
    case 'crearCalificacionProducto':
        ControladorCalificacionesProducto::crearCalificacion();
        break;
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
        controladorUsuarioAdmin::crear();
        break;
    case 'Editar_UsuarioAdmin':
        controladorUsuarioAdmin::editar();
        break;
    case 'Eliminar_UsuarioAdmin':
        controladorUsuarioAdmin::eliminar();
        break;
    case 'Consultar_Administrador':
        controladorAdministrador::consultar();
        break;
    case 'ConsultarPorID_Administrador':
        controladorAdministrador::consultar_Id();
        break;
    case 'Editar_Administrador':
        controladorAdministrador::editar();
        break;
    case 'Eliminar_Administrador':
        controladorAdministrador::eliminar();
        break;
    case 'Consultar_Rol':
        controladorRoles::consultar();
        break;
    case 'ConsultarPorID_Rol':
        controladorRoles::consultar_Id();
        break;
    case 'Eliminar_Rol':
        controladorRoles::eliminar();
        break;
    case 'Consultar_TipoDoc':
        controladorTipoDoc::consultar();
        break;
    case 'ConsultarPorID_TipoDoc':
        controladorTipoDoc::consultar_Id();
        break;
    case 'Eliminar_TipoDoc':
        controladorTipoDoc::eliminar();
        break;
    default:
        echo json_encode(["mensaje" => "Ruta no encontrada.", "ruta_solicitada" => $ruta]);
        break;
}
