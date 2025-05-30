<?php

require_once './models/perfil.php';

class ControladorPerfil
{

    public static function actualizarPerfil()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        $perfil = new Perfil();

        $actualizacion = $perfil->actualizarPerfil(
            $datos['idUsuario'],
            $datos['nombre'] ?? null,
            $datos['segundoNombre'] ?? null,
            $datos['apellido'] ?? null,
            $datos['segundoApellido'] ?? null,
            $datos['correo'] ?? null,
            $datos['celular'] ?? null,
            $datos['contrasena'] ?? null,
            $datos['nuevaContrasena'] ?? null,
            $datos['direccion'] ?? null,
            $datos['complemento'] ?? null,
        );


        if ($actualizacion && is_array($actualizacion)) {
            http_response_code(200);
            echo json_encode([
                "mensaje" => "Perfil actualizado exitosamente.",
                "usuario" => $actualizacion
            ]);
        } elseif ($actualizacion === false) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Contraseña Incorrecta."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error interno del servidor."]);
        }
    }
}
