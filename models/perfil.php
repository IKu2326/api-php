<?php

require_once './config/database.php';

class Perfil
{

    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function actualizarPerfil($idUsuario, $nombre, $segundoNombre, $apellido, $segundoApellido, $correo, $celular, $contrasena, $nuevaContrasena, $direccion, $complemento)
    {
        $sqlVerificar = "SELECT contrasenaUsuario FROM usuario WHERE idUsuario = :idUsuario";
        $stmt = $this->conn->prepare($sqlVerificar);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['contrasenaUsuario']) && password_verify($contrasena, $resultado['contrasenaUsuario'])) {

            // Actualiza nombre, apellido, celular si vienen
            if (!empty($nombre) || !empty($segundoNombre) || !empty($apellido) || !empty($segundoApellido) || !empty($celular)) {
                $sql = "UPDATE usuario SET 
                        nombreUsuario = :nombreUsuario,
                        senombreUsuario = :senombreUsuario,
                        apellidoUsuario = :apellidoUsuario,
                        seapellidoUsuario = :seapellidoUsuario, 
                        celularUsuario = :celularUsuario
                    WHERE idUsuario = :idUsuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nombreUsuario', $nombre);
                $stmt->bindParam(':senombreUsuario', $segundoNombre);
                $stmt->bindParam(':apellidoUsuario', $apellido);
                $stmt->bindParam(':seapellidoUsuario', $segundoApellido);
                $stmt->bindParam(':celularUsuario', $celular);
                $stmt->bindParam(':idUsuario', $idUsuario);
                $stmt->execute();
            }

            // Actualiza correo si viene
            if (!empty($correo)) {
                $sql = "UPDATE usuario SET correoUsuario = :correoUsuario WHERE idUsuario = :idUsuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correoUsuario', $correo);
                $stmt->bindParam(':idUsuario', $idUsuario);
                $stmt->execute();
            }

            // Actualiza contraseña si viene
            if (!empty($nuevaContrasena)) {
                $contrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
                $sql = "UPDATE usuario SET contrasenaUsuario = :contrasenaUsuario WHERE idUsuario = :idUsuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':contrasenaUsuario', $contrasenaHash);
                $stmt->bindParam(':idUsuario', $idUsuario);
                $stmt->execute();
            }

            if(!empty($direccion) ){
                $sql = "UPDATE cliente SET direccion = :direccion, complemento = :complemento WHERE idCliente = :idUsuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':complemento', $complemento);
                $stmt->bindParam(':idUsuario', $idUsuario);
                $stmt->execute();
            }

            return $this->obtenerUsuarioPorId($idUsuario);
        } else {
            return false;
        }
    }

    public function obtenerUsuarioPorId($idUsuario)
    {
        $stmt = $this->conn->prepare("SELECT u.nombreUsuario, u.senombreUsuario, u.apellidoUsuario, 
        u.seapellidoUsuario, u.correoUsuario, u.celularUsuario, c.direccion, c.complemento
        FROM usuario u 
        LEFT JOIN cliente c ON u.idUsuario = c.idCliente
        WHERE u.idUsuario = :idUsuario");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
