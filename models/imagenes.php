<?php

class Imagenes
{
    public static function subir($archivos)
    {
        $permitidos = ["image/jpg", "image/jpeg", "image/png", "image/webp", "image/jfif", "image/avif"];
        $dir = realpath(__DIR__ . '../assets/');
        $nombresCampos = ['portada', 'visual2', 'visual3'];

        foreach ($nombresCampos as $campo) {
            if (!isset($archivos[$campo])) {
                continue; // O manejar error si es obligatorio
            }

            $archivo = $archivos[$campo];

            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                continue; // O manejar error
            }

            if (!in_array($archivo['type'], $permitidos)) {
                continue; // O manejar error
            }

            $info_img = pathinfo($archivo['name']);
            $extension = $info_img['extension'];
            $tmpName = $archivo['tmp_name'];

            $nombreArchivo = $campo . "_1." . $extension;
            $rutaDestino = $dir . '/' . $nombreArchivo;

            if (!move_uploaded_file($tmpName, $rutaDestino)) {
                return false;
            }
        }

        return true;
    }

    public static function consultar($nombreCategoria)
    {
        $carpeta = realpath(__DIR__ . '/../assets/' . $nombreCategoria . '/');
        $urlBase = 'http://localhost/api-php/assets/' . $nombreCategoria . '/';
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

    public static function consultarPorId($categoria, $id)
    {
        $carpeta = realpath(__DIR__ . '/../assets/' . $categoria . '/');
        $urlBase = 'http://localhost/api-php/assets/' . $categoria . '/';

        $visualesResult = [];
        $extensiones = ['jpg', 'jpeg', 'png', 'webp', 'jfif', 'avif'];

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
        } else {
            foreach ($extensiones as $ext) {
                $archivo = $carpeta . '/' . $id . '.' . $ext;
                if (file_exists($archivo)) {
                    return ([$id => $urlBase . $id . '.' . $ext]);
                }
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Imagen no encontrada"]);
    }
}