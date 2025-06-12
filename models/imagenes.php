<?php

require_once './models/admin/Producto.php';
class Imagenes
{
    public static function consultar($nombreCategoria, $car)
    {
        $carpeta = realpath(__DIR__ . '/../assets/' . $car . '/' . $nombreCategoria . '/');
        $urlBase = 'http://localhost:8081/api-php/assets/' . $car . '/' . $nombreCategoria . '/';
        $extensiones = ['jpg', 'jpeg', 'png', 'webp', 'jfif', 'avif'];

        $imagenes = [];

        foreach (scandir($carpeta) as $archivo) {
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $nombre = pathinfo($archivo, PATHINFO_FILENAME);

            if (in_array(strtolower($extension), $extensiones)) {
                $imagenes[$nombre] = $urlBase . $archivo;

            }
        }
        return $imagenes;
    }

    public static function consultarPorId($categoria, $car, $id)
    {
        $carpeta = realpath(__DIR__ . '/../assets/' . $car . '/' . $categoria . '/');
        $urlBase = 'http://localhost:8081/api-php/assets/' . $car . '/' . $categoria . '/';

        $visualesResult = [];
        $extensiones = ['jpg', 'jpeg', 'png', 'webp', 'jfif', 'avif'];

        try{
        if ($categoria == "visuales") {
            $visuales = ['visual1_', 'visual2_', 'visual3_'];
            foreach ($visuales as $visual) {
                $archivoT = $carpeta . '/' . $visual . $id;
                foreach ($extensiones as $ext) {
                    $archivo = $archivoT . '.' . $ext;
                    if (file_exists($archivo)) {
                        $visualesResult[$visual . $id] = $urlBase . $visual . $id . '.' . $ext;
                    }
                }
            }
            return $visualesResult;
        } else if ($categoria === "trailer") {
            $extensionesT = ['mp4', 'avi', 'mov', 'wmv', 'mkv'];
            foreach ($extensionesT as $ext) {
                $archivo = $carpeta . '/' . $id . '.' . $ext;
                if (file_exists($archivo)) {
                    return ([$id => $urlBase . $id . '.' . $ext]);
                }
            }
        } else {
            
            foreach ($extensiones as $ext) {
                $archivo = $carpeta . '/' . $id . '.' . $ext;
                if (file_exists($archivo)) {
                    return ([$id => $urlBase . $id . '.' . $ext]);
                }
            }
        }
        } catch (Throwable $e) {
            var_dump("Error en consultar " . $e->getMessage());
            return false;
        }
    }
    public static function subir($archivos, $id, $tipo, $metodo): bool
    {
        $permitidos = [".jpg", ".jpeg", ".png", ".webp", ".jfif", ".avif"];
        $permitidosTrailer = ['mp4', 'avi', 'mov', 'wmv', 'mkv'];

        $nombresCampos = ['portada', 'visual1', 'visual2', 'visual3', 'trailer', 'banner'];

        $dirTemporal = 'c:\\xampp\\htdocs\\api-php\\assets/' . ($tipo === "Videojuego" ? 'Videojuego/' : 'Consola/');

        $todoBien = true;

        foreach ($nombresCampos as $campo) {
            if (empty($archivos[$campo]) || !isset($archivos[$campo])) {
                continue;
            }

            if ($campo === 'visual1' || $campo === 'visual2' || $campo === 'visual3') {
                $dir = $dirTemporal . '/visuales';

                if ($archivos[$campo]['error'] !== UPLOAD_ERR_OK) {
                    $todoBien = false;
                    continue;
                }

                if ($metodo === "Editar") {
                    foreach($permitidos as $ext){
                        if (file_exists($dir . '/' . $campo . '_' . $id . $ext)) {
                        unlink($dir . '/' . $campo . '_' . $id . $ext);
                    }
                    }
                }

                $extension = '.' . strtolower(pathinfo($archivos[$campo]['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $permitidos)) {
                    $todoBien = false;
                    continue;
                }

                $tmpName = $archivos[$campo]['tmp_name'];
                $nombreArchivo = "{$campo}_{$id}{$extension}";
                $rutaDestino = $dir . '/' . $nombreArchivo;

                move_uploaded_file($tmpName, $rutaDestino);

            } elseif ($campo === 'trailer') {
                $dir = $dirTemporal . '/trailer';

                if ($archivos[$campo]['error'] !== UPLOAD_ERR_OK) {
                    $todoBien = false;
                    continue;
                }

                if ($metodo === "Editar") {
                    foreach($permitidosTrailer as $ext){
                        if (file_exists($dir . '/' . $id . $ext)) {
                        unlink($dir . '/' . $id . $ext);
                    }
                    }
                }

                $extension = strtolower(pathinfo($archivos[$campo]['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $permitidosTrailer)) {
                    $todoBien = false;
                    continue;
                }

                $tmpName = $archivos[$campo]['tmp_name'];
                $nombreArchivo = $id . '.' . $extension;
                $rutaDestino = $dir . '/' . $nombreArchivo;

                move_uploaded_file($tmpName, $rutaDestino);
            } else {
                if ($archivos[$campo]['error'] !== UPLOAD_ERR_OK) {
                    $todoBien = false;
                    continue;
                }

                $dir = $dirTemporal . '/' . $campo;

                if ($metodo === "Editar") {
                    foreach($permitidos as $ext){
                        if (file_exists($dir . '/' . $id . $ext)) {
                        unlink($dir . '/' . $id . $ext);
                    }
                    }
                }

                $dir = $dirTemporal.'/'.$campo;

                $extension = '.' . strtolower(pathinfo($archivos[$campo]['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $permitidos)) {
                    $todoBien = false;
                    continue;
                }

                $tmpName = $archivos[$campo]['tmp_name'];
                $nombreArchivo = $id . $extension;
                $rutaDestino = $dir . '/' . $nombreArchivo;
                
                move_uploaded_file($tmpName, $rutaDestino);
            }
        }

        return $todoBien;
    }

    public static function eliminar($id): bool{
        $permitidos = [".jpg", ".jpeg", ".png", ".webp", ".jfif", ".avif"];
        $permitidosTrailer = ['mp4', 'avi', 'mov', 'wmv', 'mkv'];

        $nombresCampos = ['portada', 'visual1', 'visual2', 'visual3', 'trailer', 'banner'];

        $Producto = (new Producto())->obtenerPorId($id, nombre1: "idProducto");
        $tipo = $Producto['idTipoProducto'];

        $dirTemporal = 'c:\\xampp\\htdocs\\api-php\\assets/' . ($tipo === "Videojuego" ? 'Videojuego/' : 'Consola/');

        $todoBien = true;

        foreach ($nombresCampos as $campo) {
            if ($campo === 'visual1' || $campo === 'visual2' || $campo === 'visual3') {
                $dir = $dirTemporal . '/visuales';
                foreach($permitidos as $ext){
                        if (file_exists($dir . '/' . $campo . '_' . $id . $ext)) {
                        unlink($dir . '/' . $campo . '_' . $id . $ext);
                    }
                }
            }else if($campo === 'trailer'){
                $dir = $dirTemporal . '/trailer';
                foreach($permitidosTrailer as $ext){
                        if (file_exists($dir . '/' .$id . $ext)) {
                        unlink($dir . '/'. $id . $ext);
                    }else {
                        continue;
                    }
                }
            }else {
                $dir = $dirTemporal . '/'.$campo;
                foreach($permitidos as $ext){
                        if (file_exists($dir . '/'. $id . $ext)) {
                        unlink($dir . '/'. $id . $ext);
                    }else {
                        continue;
                    }
                }
            }
        }
        return $todoBien;
    }   
}