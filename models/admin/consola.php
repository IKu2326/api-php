<?php
require_once './models/modeloBase.php';
class Consola extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('consola');
    }

    public static function Editar($idConsola, $sobre)
    {

        $conn = Database::conectar();

        $sql = "UPDATE consola SET sobreConsola = :sobreConsola
            WHERE idConsola = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idConsola,
            'sobreConsola' => $sobre,
        ]);
    }
}