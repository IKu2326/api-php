<?php
require_once './models/usuario.php';
require_once './vendor/autoload.php';

use Firebase\JWT\JWT;

class ControladorUsuario
{
    public static function registrar()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        var_dump($datos);

        if (!isset($datos['nombre'], $datos['segundoNombre'], $datos['apellido'], $datos['segundoApellido'], $datos['correo'], $datos['celular'], $datos['contrasena'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $usuario = new Usuario();

        $registro = $usuario->registrar(
            $datos['nombre'],
            $datos['segundoNombre'],
            $datos['apellido'],
            $datos['segundoApellido'],
            $datos['correo'],
            $datos['celular'],
            $datos['contrasena']
        );

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

    public static function login()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['correo'], $datos['contrasena'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $usuario = new Usuario();

        $resultado = $usuario->login($datos['correo'], $datos['contrasena']);

        if ($resultado) {
            $key = "NVS_PRUEBA_FIRMA"; 

            $payload = [
                "id" => $resultado['idUsuario'],
                "correo" => $resultado['correoUsuario'],
                "nombre" => $resultado['nombreUsuario'],
                "segundoNombre" => $resultado['senombreUsuario'],
                "apellido" => $resultado['apellidoUsuario'],
                "segundoApellido" => $resultado['seapellidoUsuario'],
                "exp" => time() + 3600 // Token válido por 1 hora
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');

            echo json_encode([
                "mensaje" => "Inicio de sesión exitoso.",
                "token" => $jwt,
                "usuario" => $resultado
            ]);
        } else {
            http_response_code(401); // No autorizado
            echo json_encode(["mensaje" => "Correo o contraseña incorrectos."]);
        }
    }
}
