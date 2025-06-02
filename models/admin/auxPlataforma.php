<?php
require_once './models/modeloBase.php';
class AuxiliarPlataforma extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('aux_plataforma');
    }

    public static function crear(array|string $Plataforma, int $id)
    {

        $conn = Database::conectar();
        $Aux_Plataforma = new AuxiliarPlataforma();
        $resultado = $Aux_Plataforma->obtenerPorId(id1: $id, nombre1: "idJuego", tipo: "Aux");

        if (!empty($resultado)) {
            return "Aux_Plataforma_duplicado";
        }

        if (is_string($Plataforma)) {
            $sql = "INSERT INTO aux_plataforma (idJuego, idPlataforma) 
        VALUES (:id, :Plataforma)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':Plataforma' => $Plataforma
            ]);
            return true;
        } else {
            $sql = "INSERT INTO aux_plataforma (idJuego, idPlataforma) 
                VALUES (:id, :Plataforma)";
            $stmt = $conn->prepare($sql);

            foreach ($Plataforma as $Pla) {
                $ok = $stmt->execute([
                    ':id' => $id,
                    ':Plataforma' => $Pla
                ]);

                if (!$ok) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function editar(array|string $Plataforma, int $id)
    {

        $conn = Database::conectar();
        $Aux_Plataforma = new AuxiliarPlataforma();
        $Eliminar = $Aux_Plataforma->eliminar(id1: $id, nombre1: "idJuego");

        if ($Eliminar == true) {

            if (is_string($Plataforma)) {
                $sql = "INSERT INTO aux_plataforma (idJuego, idPlataforma) 
                VALUES (:id, :Plataforma)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':id' => $id,
                    ':Plataforma' => $Plataforma
                ]);
                return true;
            } else {


                $sql = "INSERT INTO aux_plataforma (idJuego, idPlataforma) 
                VALUES (:id, :Plataforma)";
                $stmt = $conn->prepare($sql);

                foreach ($Plataforma as $mar) {
                    $ok = $stmt->execute([
                        ':id' => $id,
                        ':Plataforma' => $mar
                    ]);

                    if (!$ok) {
                        return false;
                    }
                }
            }

            return true;
        }
    }
}