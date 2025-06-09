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
        $id1,
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

        $sql = "UPDATE Usuario SET nombreUsuario = :nombre, senombreUsuario = :senombre, apellidoUsuario = :apellido,
         seapellidoUsuario = :seapellido, correoUsuario = :correo, celularUsuario = :celular, contrasenaUsuario = :contra,
         idRol = :rol WHERE idUsuario = :id1";
        $stmt = $conn->prepare($sql);
        if (
            $stmt->execute([
                ':id1' => $id1,
                ':nombre' => $nombreUsuario,
                ':senombre' => $seNombreUsuario,
                ':apellido' => $apellidoUsuario,
                ':seapellido' => $seApellidoUsuario,
                ':correo' => $correoUsuario,
                ':celular' => $celularUsuario,
                ':contra' => $contrasenaUsuario,
                ':rol' => $idRol,
            ])
        ) {
            if ($idRol == 1) {
                $sql = "UPDATE cliente SET direccion = :direccion, complemento = :complemento
                WHERE idCliente = :id1";
                $stmt = $conn->prepare($sql);
                return $stmt->execute([
                    ':id1' => $id1,
                    ':direccion' => $direccion,
                    ':complemento' => $complemento,
                ]);
            } else {
                $sql = "UPDATE administrador SET documentoAdministrador = :doc, pf_fk_tdoc = :tipo
                WHERE idAdministrador = :id1";
                $stmt = $conn->prepare($sql);
                return $stmt->execute([
                    ':id1' => $id1,
                    ':doc' => $documento,
                    ':tipo' => $tipo,
                ]);
            }
        } else {
            $error = $stmt->errorInfo();
            echo "❌ Error en INSERT usuario: " . $error[2];
        }

    }

    public function filtrarUsuarios($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM usuario WHERE 1=1";
        $params = [];

        if (!empty($filtros['idUsuario'])) {
            $sql .= " AND idUsuario = :idU";
            $params[':idU'] = $filtros['idUsuario'];
        }

        if (!empty($filtros['nombreUsuario'])) {
            $sql .= " AND nombreUsuario LIKE :nombreUsuario";
            $params[':nombreUsuario'] = '%' . $filtros['nombreUsuario'] . '%';
        }

        if (!empty($filtros['apellidoUsuario'])) {
            $sql .= " AND apellidoUsuario LIKE :apellidoUsuario";
            $params[':apellidoUsuario'] = '%' . $filtros['apellidoUsuario'] . '%';
        }

        if (!empty($filtros['correoUsuario'])) {
            $sql .= " AND correoUsuario LIKE :correoUsuario";
            $params[':correoUsuario'] = '%' . $filtros['correoUsuario'] . '%';
        }

        if (!empty($filtros['celularUsuario'])) {
            $sql .= " AND celularUsuario LIKE :celularUsuario";
            $params[':celularUsuario'] = '%' . $filtros['celularUsuario'] . '%';
        }

        if (!empty($filtros['idRol'])) {
            $sql .= " AND idRol = :idRol";
            $params[':idRol'] = $filtros['idRol'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}