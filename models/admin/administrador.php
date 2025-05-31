<?php
require_once './models/modeloBase.php';
class Administrador extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('administrador');
    }

    public function obtenerTodosConUsuario()
    {
        $stmt = $this->db->query("SELECT a.*, u.nombreUsuario, u.apellidoUsuario 
        FROM administrador a 
        JOIN usuario u
        WHERE a.idAdministrador = u.idUsuario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function Editar($idAdministrador, $documento, $tipo)
    {

        $conn = Database::conectar();

        $sql = "UPDATE administrador SET documentoAdministrador = :doc, pf_fk_tdoc = :tipo 
            WHERE idAdministrador = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idAdministrador,
            'doc' => $documento,
            'tipo' => $tipo
        ]);
    }

}