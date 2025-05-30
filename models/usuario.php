<?php
require_once './config/database.php';

class Usuario
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function registrar($nombre, $segundoNombre, $apellido, $segundoApellido, $correo, $celular, $contrasena, $direccion, $complemento)
    {
        $clave_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $correo = trim(strtolower($correo));

        $sqlVerificar = "SELECT COUNT(*) FROM usuario WHERE correoUsuario = :correo";
        $stmt = $this->conn->prepare($sqlVerificar);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $existeCorreo = $stmt->fetchColumn();

        if ($existeCorreo > 0) {
            return 'correo_duplicado';
        }

        $sql = "INSERT INTO usuario (nombreUsuario, senombreUsuario, apellidoUsuario, 
        seapellidoUsuario, correoUsuario, celularUsuario, contrasenaUsuario, idRol) 
        VALUES (:nombreUsuario, :senombreUsuario, :apellidoUsuario, :seapellidoUsuario, 
        :correoUsuario, :celularUsuario, :contrasenaUsuario, :idRol)";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nombreUsuario' => $nombre,
            ':senombreUsuario' => $segundoNombre,
            ':apellidoUsuario' => $apellido,
            ':seapellidoUsuario' => $segundoApellido,
            ':correoUsuario' => $correo,
            ':celularUsuario' => $celular,
            ':contrasenaUsuario' => $clave_hash,
            ':idRol' => 1
        ]);

         $ultimo_id = $this->conn->lastInsertId();

         $sql = "INSERT INTO cliente (idCliente, direccion, complemento) 
         VALUES (:id, :direccion, :complemento)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $ultimo_id);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':complemento', $complemento);
        return $stmt->execute();
    }

    public function login($correo, $contrasena)
    {

        $correo = trim(strtolower($correo));
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE correoUsuario = :correo");
        $stmt->execute([':correo' => $correo]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return null; // Usuario no encontrado
        }

        // Verifica la contraseña antes de continuar
        if (!password_verify($contrasena, $usuario['contrasenaUsuario'])) {
            return null; // Contraseña incorrecta
        }


        if ($usuario['idRol'] == 1) {
            $stmt = $this->conn->prepare("SELECT u.idUsuario, u.nombreUsuario, u.senombreUsuario, u.apellidoUsuario, 
            u.seapellidoUsuario, u.correoUsuario, u.celularUsuario, u.contrasenaUsuario, u.idRol, c.direccion
            FROM usuario u 
            JOIN cliente c ON u.idUsuario = c.idCliente
            WHERE correoUsuario = :correo");
            $stmt->execute([':correo' => $correo]);

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$usuario) {
                return null; // No se encontró el cliente
            }

            return [
                'idUsuario' => $usuario['idUsuario'],
                'nombreUsuario' => $usuario['nombreUsuario'],
                'senombreUsuario' => $usuario['senombreUsuario'],
                'apellidoUsuario' => $usuario['apellidoUsuario'],
                'seapellidoUsuario' => $usuario['seapellidoUsuario'],
                'correoUsuario' => $usuario['correoUsuario'],
                'celularUsuario' => $usuario['celularUsuario'],
                'direccion' => $usuario['direccion'],
                'complemento' => $usuario['complemento'] ?? null,
                'idRol' => $usuario['idRol'],
            ];
        } else {
            $stmt = $this->conn->prepare("SELECT u.idUsuario, u.nombreUsuario, u.senombreUsuario, u.apellidoUsuario, 
            u.seapellidoUsuario, u.correoUsuario, u.celularUsuario, u.contrasenaUsuario, u.idRol, a.documentoAdministrador, a.pf_fk_tdoc
            FROM usuario u 
            JOIN administrador a ON u.idUsuario = a.idAdministrador
            WHERE correoUsuario = :correo");
            $stmt->execute([':correo' => $correo]);

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return null; // No se encontró el administrador
            }

            return [
                'idUsuario' => $usuario['idUsuario'],
                'nombreUsuario' => $usuario['nombreUsuario'],
                'senombreUsuario' => $usuario['senombreUsuario'],
                'apellidoUsuario' => $usuario['apellidoUsuario'],
                'seapellidoUsuario' => $usuario['seapellidoUsuario'],
                'correoUsuario' => $usuario['correoUsuario'],
                'celularUsuario' => $usuario['celularUsuario'],
                'documentoAdministrador' => $usuario['documentoAdministrador'] ?? null,
                'tipoDocumento' => $usuario['pf_fk_tdoc'] ?? null,
                'idRol' => $usuario['idRol'],
            ];
        }


        return false;
    }
}
