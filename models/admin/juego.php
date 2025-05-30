<?php
require_once './models/modeloBase.php';
class Juego extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('juego');
    }

    public static function Editar($idJuego, $Lanzamiento, $Descripcion)
    {

        $conn = Database::conectar();

        $sql = "UPDATE juego SET anoLanzamiento = :Lanzamiento, descripcionJuego = :descripcionJuego 
            WHERE idJuego = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idJuego,
            'Lanzamiento' => $Lanzamiento,
            'descripcionJuego' => $Descripcion
        ]);
    }
}