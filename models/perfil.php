<?php

require_once './config/database.php';

class Perfil
{

    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function actualizarPerfil($idUsuario, $nombre, $segundoNombre, $apellido, $segundoApellido, $correo, $celular, $contrasena, $nuevaContrasena)
    {

        $sqlVerificar = "
            SELECT `contrasenaUsuario` 
            FROM `usuario` 
            WHERE idUsuario = :idUsuario
            ";

        $stmt = $this->conn->prepare($sqlVerificar);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($contrasena, $resultado['contrasenaUsuario'])) {

            if (!empty($nombre) || !empty($segundoNombre) || !empty($apellido) || !empty($segundoApellido) || !empty($celular)) {
                $sql = "
                     UPDATE `usuario` SET 
                     `nombreUsuario`= :nombreUsuario,
                     `senombreUsuario`= :senombreUsuario,
                     `apellidoUsuario`= :apellidoUsuario,
                     `seapellidoUsuario`= :seapellidoUsuario, 
                     `celularUsuario`= :celularUsuario
                     WHERE idUsuario = :idUsuario
                     ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nombreUsuario', $nombre);
                $stmt->bindParam(':senombreUsuario', $segundoNombre);
                $stmt->bindParam(':apellidoUsuario', $apellido);
                $stmt->bindParam(':seapellidoUsuario', $segundoApellido);
                $stmt->bindParam(':celularUsuario', $celular);
                $stmt->bindParam(':idUsuario', $idUsuario);
                return $stmt->execute();
            }
        } else {
            return false;
        }
    }
}
