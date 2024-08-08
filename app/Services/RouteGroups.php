<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use RuntimeException;

class RouteGroups
{
    public static function loadMenuRoutes()
    {
        // Definir el directorio de rutas de menús
        $menusDirectory = base_path('routes/menus');

        // Verificar si el directorio 'menus' existe
        if (!File::exists($menusDirectory)) {
            throw new RuntimeException("El directorio 'routes/menus' no existe.");
        }

        // Obtener todos los archivos .php en el directorio routes/menus
        $routeFiles = glob($menusDirectory . '/*.php');

        // Array para rastrear prefijos ya utilizados
        $usedPrefixes = [];

        // Iterar sobre cada archivo de rutas
        foreach ($routeFiles as $routeFile) {
            // Leer el contenido del archivo para obtener el prefijo
            $content = File::get($routeFile);
            // Extraer el prefijo del contenido
            preg_match('/\$prefix\s*=\s*\'(.*?)\'/', $content, $matches);
            $prefix = $matches[1] ?? ''; // Usar prefijo vacío si no se encuentra

            // Verificar si el prefijo ya está en uso
            if (in_array($prefix, $usedPrefixes)) {
                throw new RuntimeException("El prefijo '{$prefix}' ya está en uso.");
            }

            // Añadir el prefijo al array de prefijos utilizados
            $usedPrefixes[] = $prefix;

            // Registrar las rutas con el prefijo
            Route::middleware('web')
                ->prefix($prefix)
                ->group($routeFile);
        }
    }
}
