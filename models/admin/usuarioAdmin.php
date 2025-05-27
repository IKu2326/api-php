<?php
require_once './models/modeloBase.php';
class UsuarioAdmin extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('usuario');
    }

    public static function Crear(
        $nombreUsuario,
        $seNombreUsuario,
        $apellidoUsuario,
        $seApellidoUsuario,
        $correoUsuario,
        $celularUsuario,
        $contrasenaUsuario,
        $idRol,
        ?string $direccion = null,
        ?string $complemento = null,
        ?string $documento = null,
        ?string $tipo = null
    ) {
        $conn = Database::conectar();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $clave_hash = password_hash($contrasenaUsuario, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuario ( nombreUsuario, seNombreUsuario, apellidoUsuario, seapellidoUsuario, correoUsuario, celularUsuario, contrasenaUsuario, idRol ) 
        VALUES (:nombreUsuario, :senombreUsuario, :apellidoUsuario, :seapellidoUsuario, 
        :correoUsuario, :celularUsuario, :contrasenaUsuario, :idRol)";
        $stmt = $conn->prepare($sql);
        if (
            $stmt->execute([
                ':nombreUsuario' => $nombreUsuario,
                ':senombreUsuario' => $seNombreUsuario,
                ':apellidoUsuario' => $apellidoUsuario,
                ':seapellidoUsuario' => $seApellidoUsuario,
                ':correoUsuario' => $correoUsuario,
                ':celularUsuario' => $celularUsuario,
                ':contrasenaUsuario' => $clave_hash,
                ':idRol' => $idRol
            ])
        ) {
            $ultimo_id = $conn->lastInsertId();
            var_dump($ultimo_id);

            if ($idRol == 1) {
                $sql = "INSERT INTO cliente (idCliente, direccion, complemento) 
            VALUES (:id, :direccion, :complemento)";
                $stmt = $conn->prepare($sql);
                return $stmt->execute([
                    ':id' => $ultimo_id,
                    ':direccion' => $direccion,
                    ':complemento' => $complemento,
                ]);
            } else {
                $sql = "INSERT INTO administrador (idAdministrador, documentoAdministrador, pf_fk_tdoc) 
            VALUES (:id, :doc, :tdoc)";
                $stmt = $conn->prepare($sql);
                return $stmt->execute([
                    ':id' => $ultimo_id,
                    ':doc' => $documento,
                    ':tdoc' => $tipo,
                ]);
            }
        } else {
            $error = $stmt->errorInfo();
            echo "❌ Error en INSERT usuario: " . $error[2];
        }

    }

    public static function Editar(
        $idProducto,
        $nombreProducto,
        $precioProducto,
        $garantiaProducto,
        $idTipoProducto,
        $idAdministrador,
        $stock,
        $cantidad
    ) {

        $conn = Database::conectar();

        $sql = "UPDATE Producto SET nombreProducto = :nombre, precioProducto = :precio, garantiaProducto = :garantia,
         idTipoProducto = :tipo, idAdministrador_crear = :administrador, stock = :stock, cantidad = :cantidad, 
            WHERE idProducto = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id1' => $idProducto,
            ':nombre' => $nombreProducto,
            ':precio' => $precioProducto,
            ':garantia' => $garantiaProducto,
            ':tipo' => $idTipoProducto,
            ':administrador' => $idAdministrador,
            ':stock' => $stock,
            ':cantidad' => $cantidad,
        ]);
    }

}