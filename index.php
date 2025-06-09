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
require_once './controllers/controladorImagenes.php';
require_once './controllers/ControladorGuardarFactura.php';
require_once './controllers/controladorSoporte.php';
require_once './controllers/controladorPerfil.php';
//admin
require_once './controllers/admin/controladorFormaPago.php';
require_once './controllers/admin/controladorCalificacionCliente.php';
require_once './controllers/admin/controladorCliente.php';
require_once './controllers/admin/controladorProducto.php';
require_once './controllers/admin/controladorFactura.php';
require_once './controllers/admin/controladorGenero.php';
require_once './controllers/admin/controladorDetallesFactura.php';
require_once './controllers/admin/controladorUsuarioAdmin.php';
require_once './controllers/admin/controladorAdministrador.php';
require_once './controllers/admin/controladorRol.php';
require_once './controllers/admin/controladorTipoDoc.php';
require_once './controllers/admin/controladorPlataforma.php';
require_once './controllers/admin/controladorJuego.php';
require_once './controllers/admin/controladorConsola.php';
require_once './controllers/admin/controladorMarca.php';
require_once './controllers/admin/controladorAuxMarca.php';
require_once './controllers/admin/controladorAuxPlataforma.php';
require_once './controllers/admin/controladorAuxGenero.php';
require_once './controllers/admin/controladorCaracteristicasConsola.php';
require_once './controllers/admin/controladorSoporte.php';
require_once './controllers/admin/controladorEstadoEnvio.php';
require_once './controllers/admin/controladorEnvio.php';


$ruta = trim($_GET['ruta'] ?? '');

switch ($ruta) {
    case 'registrar':
        ControladorUsuario::registrar();
        break;
    case 'login':
        ControladorUsuario::login();
        break;
    case 'actualizarPerfil':
        ControladorPerfil::actualizarPerfil();
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
    case 'Crear_DetalleFacturaCompleto':
        ControladorGuardarFactura::guardarFactura();
        break;
    case 'EnviarPQRS':
        ControladorSoporte::enviarPQRS();
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
    case 'Consultar_CalificacionClienteFiltrados':
        controladorCalificacionCliente::filtroCalificacion();
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
    case 'Consultar_ClienteConUsuario':
        controladorCliente::consultarConUsuario();
        break;
    case 'ConsultarPorID_Cliente':
        controladorCliente::consultar_Id();
        break;
    case 'Consultar_Producto':
        controladorProducto::consultar();
        break;
    case 'ConsultarPorID_Producto':
        controladorProducto::consultar_Id();
        break;
    case 'Consultar_ProductosFiltrados':
        controladorProducto::filtroProductos();
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
    case 'Consultar_FacturasFiltrados':
        controladorFactura::filtroFactura();
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
    case 'Consultar_UsuarioAdminFiltrados':
        ControladorUsuarioAdmin::filtroUsuarioAdmin();
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
    case 'Consultar_AdministradorConUsuario':
        controladorAdministrador::consultarConUsuario();
        break;
    case 'ConsultarPorID_Administrador':
        controladorAdministrador::consultar_Id();
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
    case 'Consultar_DetalleFactura':
        controladorDetallesFactura::consultar();
        break;
    case 'ConsultarPorID_DetalleFactura':
        controladorDetallesFactura::consultar_Id();
        break;
    case 'Consultar_DetallesFacturaFiltrados':
        controladorDetallesFactura::filtroDetallesFactura();
        break;
    case 'Crear_DetalleFactura':
        controladorDetallesFactura::crear();
        break;
    case 'Editar_DetalleFactura':
        controladorDetallesFactura::editar();
        break;
    case 'Eliminar_DetalleFactura':
        controladorDetallesFactura::eliminar();
        break;
    case 'Consultar_Genero':
        controladorGenero::consultar();
        break;
    case 'ConsultarPorID_Genero':
        controladorGenero::consultar_Id();
        break;
    case 'Consultar_GeneroFiltrados':
        controladorGenero::filtroGenero();
        break;
    case 'Crear_Genero':
        controladorGenero::crear();
        break;
    case 'Editar_Genero':
        controladorGenero::editar();
        break;
    case 'Eliminar_Genero':
        controladorGenero::eliminar();
        break;
    case 'Consultar_Plataforma':
        controladorPlataforma::consultar();
        break;
    case 'ConsultarPorID_Plataforma':
        controladorPlataforma::consultar_Id();
        break;
    case 'Consultar_PlataformaFiltrados':
        controladorPlataforma::filtroPlataforma();
        break;
    case 'Crear_Plataforma':
        controladorPlataforma::crear();
        break;
    case 'Editar_Plataforma':
        controladorPlataforma::editar();
        break;
    case 'Eliminar_Plataforma':
        controladorPlataforma::eliminar();
        break;
    case 'Consultar_Juego':
        controladorJuego::consultar();
        break;
    case 'ConsultarPorID_Juego':
        controladorJuego::consultar_Id();
        break;
    case 'Editar_Juego':
        controladorJuego::editar();
        break;
    case 'Eliminar_Juego':
        controladorJuego::eliminar();
        break;
    case 'Consultar_Consola':
        controladorConsola::consultar();
        break;
    case 'ConsultarPorID_Consola':
        controladorConsola::consultar_Id();
        break;
    case 'Editar_Consola':
        controladorConsola::editar();
        break;
    case 'Eliminar_Consola':
        controladorConsola::eliminar();
        break;
    case 'Consultar_ImagenesCategoria':
        ControladorImagenes::consultar();
        break;
    case 'ConsultarPorId_Imagenes':
        ControladorImagenes::consultarPorId();
        break;
    case 'Consultar_Marca':
        controladorMarca::consultar();
        break;
    case 'ConsultarPorID_Marca':
        controladorMarca::consultar_Id();
        break;
    case 'Consultar_AuxPlataforma':
        controladorAuxiliarPlataforma::consultar();
        break;
    case 'ConsultarPorID_AuxPlataforma':
        controladorAuxiliarPlataforma::consultar_Id();
        break;
    case 'Eliminar_AuxPlataforma':
        controladorAuxiliarPlataforma::eliminar();
        break;
    case 'Consultar_AuxGenero':
        controladorAuxiliarGenero::consultar();
        break;
    case 'ConsultarPorID_AuxGenero':
        controladorAuxiliarGenero::consultar_Id();
        break;
    case 'Eliminar_AuxGenero':
        controladorAuxiliarGenero::eliminar();
        break;
    case 'Consultar_AuxMarca':
        controladorAuxiliarMarca::consultar();
        break;
    case 'ConsultarPorID_AuxMarca':
        controladorAuxiliarMarca::consultar_Id();
        break;
    case 'Eliminar_AuxMarca':
        controladorAuxiliarMarca::eliminar();
        break;
    case 'Consultar_CaracteristicasConsola':
        controladorCaracteristicasConsola::consultar();
        break;
    case 'ConsultarPorID_CaracteristicasConsola':
        controladorCaracteristicasConsola::consultar_Id();
        break;
    case 'Eliminar_CaracteristicasConsola':
        controladorCaracteristicasConsola::eliminar();
        break;
    case 'Consultar_Soporte':
        controladorSoporteAdmin::consultar();
        break;
    case 'ConsultarPorID_Soporte':
        controladorSoporteAdmin::consultar_Id();
        break;
    case 'Consultar_SoporteFiltrados':
        controladorSoporteAdmin::filtroSoporte();
        break;
    case 'Editar_Soporte':
        controladorSoporteAdmin::editar();
        break;
    case 'Responder_Soporte':
        controladorSoporteAdmin::responder();
        break;
    case 'Eliminar_Soporte':
        controladorSoporteAdmin::eliminar();
        break;
    case 'Consultar_EstadoEnvio':
        controladorEstadoEnvio::consultar();
        break;
    case 'ConsultarPorID_EstadoEnvio':
        controladorEstadoEnvio::consultar_Id();
        break;
    case 'Eliminar_EstadoEnvio':
        controladorEstadoEnvio::eliminar();
        break;
    case 'Consultar_EnvioAdmin':
        controladorEnvioAdmin::consultar();
        break;
    case 'ConsultarPorID_EnvioAdmin':
        controladorEnvioAdmin::consultar_Id();
        break;
    case 'Consultar_EnvioAdminFiltrados':
        controladorEnvioAdmin::filtroEnvioAdmin();
        break;
    case 'Consultar_EnvioAdminDetalles':
        controladorEnvioAdmin::consultarDetalles();
        break;
    case 'Crear_EnvioAdmin':
        controladorEnvioAdmin::crear();
        break;
    case 'Editar_EnvioAdmin':
        controladorEnvioAdmin::editar();
        break;
    case 'Eliminar_EnvioAdmin':
        controladorEnvioAdmin::eliminar();
        break;

    default:
        echo json_encode(["mensaje" => "Ruta no encontrada.", "ruta_solicitada" => $ruta]);
        break;
}
