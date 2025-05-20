<?php
require_once './config/database.php';

class MostrarProducto
{

    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function productosMasVendidos($plataforma, $tipoProducto, $genero, $generosJuegos)
    {
        if ($tipoProducto === 'Videojuego') {
            if (!empty($plataforma) && !empty($genero)) {
                $sql = "
             SELECT 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             p.descuentoProducto,
             p.totalProducto,
             pl.idPlataforma AS plataforma,
             ge.idGeneroJuego AS generojuego
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
             JOIN aux_plataforma ap ON j.idJuego = ap.idJuego
             JOIN plataforma pl ON ap.idPlataforma = pl.idPlataforma
             JOIN aux_genero ag ON j.idJuego = ag.fk_pk_juego
             JOIN generojuego ge ON ag.fk_pk_genero = ge.idGeneroJuego
             WHERE pl.idPlataforma = :plataforma
             AND ge.idGeneroJuego = :genero
             AND p.stock > 0
             ORDER BY precioProducto ASC
		     LIMIT 12
             ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":plataforma", $plataforma, PDO::PARAM_STR);
                $stmt->bindParam(":genero", $genero, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($plataforma)) {

                $sql = "
            SELECT 
            p.idProducto, 
            p.precioProducto, 
            p.totalProducto,
            p.nombreProducto, 
            p.descuentoProducto,
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
             p.totalProducto,
             p.nombreProducto,
             p.descuentoProducto,
             ge.idGeneroJuego AS generojuego
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
             JOIN aux_genero ag ON j.idJuego = ag.fk_pk_juego
             JOIN generojuego ge ON ag.fk_pk_genero = ge.idGeneroJuego
             WHERE ge.idGeneroJuego = :genero
             AND p.stock > 0
             ORDER BY p.ventaProducto DESC
		     LIMIT 12
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":genero", $genero, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($generosJuegos)) {
                $sql = "
                    SELECT idGeneroJuego  
                    FROM generojuego 
                    WHERE estadoGeneroJuego = 1 
                    Limit 8
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "
             SELECT 
             idProducto,
             precioProducto,
             p.totalProducto,
             nombreProducto,
             p.descuentoProducto,
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
        } elseif ($tipoProducto === 'Consola') {
            $sql = "
                SELECT 
                idProducto,
                precioProducto,
                totalProducto,
                nombreProducto,
                p.descuentoProducto,
                ventaProducto
                FROM producto p
                WHERE idTipoProducto = 'Consola'
                AND p.stock > 0
                ORDER BY ventaProducto DESC
                LIMIT 3
                ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function productosTendencias($plataforma, $tipoProducto, $genero)
    {
        if ($tipoProducto === 'Videojuego') {
            if (!empty($plataforma)) {
                $sql = "
                SELECT 
                 p.idProducto, 
                 p.precioProducto, 
                 totalProducto,
                 p.nombreProducto, 
                 p.descuentoProducto,
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
            } else {
                $sql = "
                SELECT 
                 p.idProducto, 
                 p.precioProducto, 
                 p.totalProducto,
                 p.nombreProducto, 
                 p.descuentoProducto,
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
        } elseif ($tipoProducto === 'Consola') {
            $sql = "
                 SELECT 
                 p.idProducto, 
                 p.precioProducto, 
                 p.totalProducto,
                 p.nombreProducto, 
                 p.descuentoProducto,
                 cl.totalCalificacion,
                 cl.PromedioAceptacion,
                 (cl.totalCalificacion + cl.PromedioAceptacion) AS calificacionAbsoluta

                 FROM producto p 
                 JOIN calificacionfinal cl ON p.idProducto = cl.idProducto

                 WHERE p.idTipoProducto = 'Consola'
                 AND p.stock > 0 

                 ORDER BY calificacionAbsoluta DESC
                 LIMIT 9;
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function productosExclusivos($plataforma)
    {
        if (!empty($plataforma)) {
            $sql = "
            SELECT
			p.idProducto, 
            p.precioProducto, 
            p.totalProducto,
            p.nombreProducto, 
            p.descuentoProducto,
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
        } else {
            echo "error";
        }
    }
    public function productosOfertas($tipoProducto)
    {
        if (!empty($tipoProducto === 'Videojuego')) {
            $sql = "
             SELECT 
             idProducto,
             descuentoProducto,
             totalProducto,
             precioProducto,
             nombreProducto,
             p.descuentoProducto,
             ventaProducto
             FROM producto p
             WHERE idTipoProducto = 'videojuego'
             AND p.stock > 0
             ORDER BY descuentoProducto DESC
		     LIMIT 3 
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (!empty($tipoProducto === 'Consola')) {
            $sql = "
             SELECT 
             idProducto,
             descuentoProducto,
             totalProducto,
             precioProducto,
             nombreProducto,
             p.descuentoProducto,
             ventaProducto
             FROM producto p
             WHERE idTipoProducto = 'Consola'
             AND p.stock > 0
             ORDER BY descuentoProducto DESC
             LIMIT 3
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
