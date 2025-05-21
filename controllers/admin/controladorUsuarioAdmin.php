<?php
require_once './models/admin/usuarioAdmin.php';

class ControladorUsuarioAdmin
{
    public static function consultar() {
        $Usuario = new UsuarioAdmin();
        $Usuarios = $Usuario->obtenerTodos();
        
        echo json_encode($Usuarios);
    }

    public static function consultar_Id() {
        
        $id1 = $_GET['id1'] ?? null;
        $id2 = $_GET['id2'] ?? null;
        $nombre1 = $_GET['nombre1'] ?? null;
        $nombre2 = $_GET['nombre2'] ?? null;


        if(!isset($id1, $nombre1)) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $Usuario = new UsuarioAdmin();
        $Usuarios = $Usuario->obtenerPorId($id1, $id2,$nombre1, $nombre2);
        
        echo json_encode($Usuarios);
    }
    public static function crear()
    {

        $datos = json_decode(file_get_contents("php://input"), true);
        $usuario = new UsuarioAdmin();

        if (!isset($datos['idRol'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        } else {
            if ($datos['idRol'] == 1) {
                if (
                    !isset(
                    $datos['nombre'],
                    $datos['segundoNombre'],
                    $datos['apellido'],
                    $datos['segundoApellido'],
                    $datos['correo'],
                    $datos['celular'],
                    $datos['contrasena'],
                    $datos['direccion'],
                    $datos['complemento']
                )
                ) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                    return;
                } else {
                    $registro = $usuario->Crear(
                        $datos['nombre'],
                        $datos['segundoNombre'],
                        $datos['apellido'],
                        $datos['segundoApellido'],
                        $datos['correo'],
                        $datos['celular'],
                        $datos['contrasena'],
                        $datos['idRol'],
                        $datos['direccion'],
                        $datos['complemento'],
                    );
                }
            } else {
                if (
                    !isset(
                    $datos['nombre'],
                    $datos['segundoNombre'],
                    $datos['apellido'],
                    $datos['segundoApellido'],
                    $datos['correo'],
                    $datos['celular'],
                    $datos['contrasena'],
                    $datos['documentoAdministrador'],
                    $datos['tipoDoc']
                )
                ) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                    return;
                } else {
                    $registro = $usuario::Crear(
                        $datos['nombre'],
                        $datos['segundoNombre'],
                        $datos['apellido'],
                        $datos['segundoApellido'],
                        $datos['correo'],
                        $datos['celular'],
                        $datos['contrasena'],
                        $datos['idRol'],
                        documento: $datos['documentoAdministrador'],
                        tipo: $datos['tipoDoc'],
                    );
                }
            }
        }

        if ($registro === "correo_duplicado") {
            http_response_code(409);
            echo json_encode(["mensaje" => "El correo ya está registrado."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => "Usuario registrado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar el usuario."]);
        }
    }
    public static function editar(){

        $datos = json_decode(file_get_contents("php://input"), true);
        $usuario = new UsuarioAdmin();

        if (!isset($datos['idRol'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        } else {
            if ($datos['idRol'] == 1) {
                if (
                    !isset(
                    $datos['nombre'],
                    $datos['segundoNombre'],
                    $datos['apellido'],
                    $datos['segundoApellido'],
                    $datos['correo'],
                    $datos['celular'],
                    $datos['contrasena'],
                    $datos['direccion'],
                    $datos['complemento']
                )
                ) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                    return;
                } else {
                    $registro = $usuario->Editar(
                        $datos['nombre'],
                        $datos['segundoNombre'],
                        $datos['apellido'],
                        $datos['segundoApellido'],
                        $datos['correo'],
                        $datos['celular'],
                        $datos['contrasena'],
                        $datos['direccion'],
                        $datos['complemento'],
                    );
                }
            } else {
                if (
                    !isset(
                    $datos['nombre'],
                    $datos['segundoNombre'],
                    $datos['apellido'],
                    $datos['segundoApellido'],
                    $datos['correo'],
                    $datos['celular'],
                    $datos['contrasena'],
                    $datos['documentoAdministrador'],
                    $datos['tipoDoc']
                )
                ) {
                    http_response_code(400);
                    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                    return;
                } else {
                    $registro = $usuario->Editar(
                        $datos['nombre'],
                        $datos['segundoNombre'],
                        $datos['apellido'],
                        $datos['segundoApellido'],
                        $datos['correo'],
                        $datos['celular'],
                        $datos['contrasena'],
                        $datos['direccion'],
                        $datos['complemento'],
                    );
                }
            }
        }

        if ($registro === true) {
            echo json_encode(["mensaje" => "Usuario registrado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar el usuario."]);
        }
    }

    public static function eliminar() {

        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['id1'], $datos['id2'], $datos['nombre1'], $datos['nombre2'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;

        $Usuario = new UsuarioAdmin();
        $resultado = $Usuario->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => " eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Usuario ."]);
        }
    }
}