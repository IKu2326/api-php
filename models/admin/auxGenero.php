<?php
require_once './models/modeloBase.php';
class AuxiliarGenero extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('aux_genero');
    }

    public static function crear(array|string $Genero, int $id)
    {
        $conn = Database::conectar();
        $auxGenero = new AuxiliarGenero();
        $resultado = $auxGenero->obtenerPorId($id, "fk_pk_juego", tipo: "Aux");

        if (!empty($resultado)) {
            return "Aux_Genero_duplicado";
        }

        $sql = "INSERT INTO aux_genero (fk_pk_juego, fk_pk_genero) 
                VALUES (:id, :Genero)";
        $stmt = $conn->prepare($sql);

        if (is_string($Genero)) {
            $ok = $stmt->execute([
                ':id' => $id,
                ':Genero' => $Genero
            ]);
            return $ok;
        } else {
            foreach ($Genero as $gen) {
                $ok = $stmt->execute([
                    ':id' => $id,
                    ':Genero' => $gen
                ]);
                if (!$ok) {
                    return false;
                }
            }
            return true;
        }
    }

    public static function editar(array|string $Genero, int $id)
    {

        $conn = Database::conectar();
        $Aux_Genero = new AuxiliarGenero();
        $Eliminar = $Aux_Genero->eliminar(id1: $id, nombre1: "fk_pk_juego");

        if ($Eliminar == true) {
            if (is_string($Genero)) {
                $sql = "INSERT INTO aux_genero (fk_pk_juego, fk_pk_genero) 
                VALUES (:id, :Genero)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':id' => $id,
                    ':Genero' => $Genero
                ]);
                return true;
            } else {
                $sql = "INSERT INTO aux_genero (fk_pk_juego, fk_pk_genero) 
                VALUES (:id, :Genero)";
                $stmt = $conn->prepare($sql);

                foreach ($Genero as $mar) {
                    $ok = $stmt->execute([
                        ':id' => $id,
                        ':Genero' => $mar
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