<?php
require_once './models/modeloBase.php';
class AuxiliarMarca extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('aux_marca');
    }

    public static function crear(array|string $marca, int $id)
    {

        $conn = Database::conectar();
        $Aux_Marca = new AuxiliarMarca();
        $resultado = $Aux_Marca->obtenerPorId(id1: $id, nombre1: "fk_pk_producto", tipo: "Aux");

        if (!empty($resultado)) {
            return "Aux_Marca_duplicado";
        }

        if (is_string($marca)) {
            $sql = "INSERT INTO aux_marca (fk_pk_producto, fk_pk_marca) 
        VALUES (:id, :marca)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':marca' => $marca
            ]);
            return true;
        } else {
            $sql = "INSERT INTO aux_marca (fk_pk_producto, fk_pk_marca) 
                VALUES (:id, :marca)";
            $stmt = $conn->prepare($sql);

            foreach ($marca as $mar) {
                $ok = $stmt->execute([
                    ':id' => $id,
                    ':marca' => $mar
                ]);

                if (!$ok) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function editar(array|string $marca, int $id)
    {
        $conn = Database::conectar();
        $Aux_Marca = new AuxiliarMarca();
        $Eliminar = $Aux_Marca->eliminar(id1: $id, nombre1: "fk_pk_producto");

        if ($Eliminar == true) {
            if (is_string($marca)) {
                $sql = "INSERT INTO aux_marca (fk_pk_producto, fk_pk_marca) 
                VALUES (:id, :marca)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':id' => $id,
                    ':marca' => $marca
                ]);
                return true;
            } else {
                $sql = "INSERT INTO aux_marca (fk_pk_producto, fk_pk_marca) 
                VALUES (:id, :marca)";
                $stmt = $conn->prepare($sql);

                foreach ($marca as $mar) {
                    $ok = $stmt->execute([
                        ':id' => $id,
                        ':marca' => $mar
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