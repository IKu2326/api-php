<?php 
    require_once './models/mostrarProducto.php';

    class ControladorMostrarProducto {

        public static function productosMasVendidos() {

            $producto = new MostrarProducto();

            $plataforma = $_GET['plataforma'] ?? null;
            $genero = $_GET['genero'] ?? null;
            $tipoProducto = trim($_GET['tipoProducto'] ?? null);

            $producto = $producto->productosMasVendidos($plataforma, $tipoProducto, $genero,);

            echo json_encode($producto);
        }

        public static function productosTendencias() {

            $producto = new MostrarProducto();

            $plataforma = $_GET['plataforma'] ?? null;
            $genero = $_GET['genero'] ?? null;
            $tipoProducto = trim($_GET['tipoProducto'] ?? null);

            $producto = $producto->productosTendencias($plataforma, $tipoProducto, $genero);
            echo json_encode($producto);
        } 

        public static function productosExclusivos() {

            $producto = new MostrarProducto();

            $plataforma = $_GET['plataforma'] ?? null;
        
            $producto = $producto->productosExclusivos($plataforma);
            echo json_encode($producto);
        }


    }


?>