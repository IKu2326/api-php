<?php
require_once './config/database.php';

class MostrarProducto
{

    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function productosMasVendidos($plataforma, $tipoProducto, $genero)
    {
        if ($tipoProducto === 'Videojuego') {
            if (!empty($plataforma) && !empty($genero)) {


                $placeholder = implode(',', array_fill(0, count($plataforma), '?'));

                $sql = "
             SELECT 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             pl.idPlataforma AS plataforma,
             ge.idGeneroJuego AS generojuego
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
             JOIN aux_plataforma ap ON j.idJuego = ap.idJuego
             JOIN plataforma pl ON ap.idPlataforma = pl.idPlataforma
             JOIN aux_genero ag ON j.idJuego = ag.fk_pk_juego
             JOIN generojuego ge ON ag.fk_pk_genero = ge.idGeneroJuego
             WHERE pl.idPlataforma IN ($placeholder)
             AND ge.idGeneroJuego = ?
             AND p.stock > 0
             ORDER BY precioProducto ASC
		     LIMIT 3 
             ";

                $stmt = $this->conn->prepare($sql);

                $params = array_merge($plataforma, [$genero]);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($plataforma)) {

                $sql = "
            SELECT 
            p.idProducto, 
            p.precioProducto, 
            p.nombreProducto, 
            pl.idPlataforma AS plataforma 
            FROM producto p 
            JOIN aux_plataforma ap ON p.idProducto = ap.idJuego 
            JOIN plataforma pl ON ap.idPlataforma = pl.idPlataforma 
            WHERE pl.idPlataforma = :plataforma
            AND p.idTipoProducto =  'Videojuego'
            AND p.stock > 0 
            ORDER BY ventaProducto DESC LIMIT 3;
            ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":plataforma", $plataforma, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($genero)) {
                $sql = "
            SELECT 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             ge.idGeneroJuego AS generojuego
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
             JOIN aux_genero ag ON j.idJuego = ag.fk_pk_juego
             JOIN generojuego ge ON ag.fk_pk_genero = ge.idGeneroJuego
             WHERE ge.idGeneroJuego = :genero
             AND p.stock > 0
             ORDER BY precioProducto ASC
		     LIMIT 3
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":genero", $genero, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "
             SELECT 
             idProducto,
             precioProducto,
             nombreProducto,
             ventaProducto
             FROM producto p
             WHERE idTipoProducto = 'videojuego'
             AND p.stock > 0
             ORDER BY ventaProducto DESC
		     LIMIT 3 
             ";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            echo "error penesote$tipoProducto";
        }
    }

    public function productosTendencias($plataforma, $tipoProducto, $genero)
    {
        if ($tipoProducto === 'Videojuego') {
            if (!empty($plataforma) && !empty($genero)) {
                echo "aqui";
            } elseif (!empty($plataforma)) {
                $sql = "
                SELECT 
                 p.idProducto, 
                 p.precioProducto, 
                 p.nombreProducto, 
                 pl.idPlataforma AS plataforma,
                 cl.totalCalificacion,
                 cl.PromedioAceptacion,
                 (cl.totalCalificacion + cl.PromedioAceptacion) AS calificacionAbsoluta

                 FROM producto p 
                 JOIN aux_plataforma ap ON p.idProducto = ap.idJuego 
                 JOIN plataforma pl ON ap.idPlataforma = pl.idPlataforma
                 JOIN calificacionfinal cl ON p.idProducto = cl.idProducto

                 WHERE pl.idPlataforma = :plataforma
                 AND p.idTipoProducto = 'Videojuego'
                 AND p.stock > 0 

                 ORDER BY calificacionAbsoluta DESC
                 LIMIT 9;
                 ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":plataforma", $plataforma, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($genero)) {
            } else {
                $sql = "
                SELECT 
                 p.idProducto, 
                 p.precioProducto, 
                 p.nombreProducto, 
                 cl.totalCalificacion,
                 cl.PromedioAceptacion,
                 (cl.totalCalificacion + cl.PromedioAceptacion) AS calificacionAbsoluta

                 FROM producto p 
                 JOIN calificacionfinal cl ON p.idProducto = cl.idProducto

                 WHERE p.idTipoProducto = 'Videojuego'
                 AND p.stock > 0 

                 ORDER BY calificacionAbsoluta DESC
                 LIMIT 9;
                 ";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            echo "algo paso";
        }
    }

    public function productosExclusivos($plataforma)
    {
        if (!empty($plataforma)) {
            $sql = "
            SELECT
			p.idProducto, 
            p.precioProducto, 
            p.nombreProducto, 
            pl.idPlataforma AS plataforma 
            FROM producto p 
            JOIN aux_plataforma ap ON p.idProducto = ap.idJuego 
            JOIN plataforma pl ON ap.idPlataforma = pl.idPlataforma 
            WHERE pl.idPlataforma = :plataforma
            AND p.idTipoProducto = 'Videojuego'
            AND (SELECT COUNT(*)
			FROM aux_plataforma ap2
			WHERE p.idProducto = ap2.idJuego
			)=1
            AND p.stock > 0 
            ORDER BY ventaProducto DESC LIMIT 3;
                 ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":plataforma", $plataforma, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            echo "error penesotepopop";
        }
    }
}
