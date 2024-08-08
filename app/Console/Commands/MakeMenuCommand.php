<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeMenuCommand extends Command
{
    protected $signature = 'menu:make {name} {--role=admin} {--prefix=}';
    protected $description = 'Create a new menu route file with specified role and optional prefix';

    public function handle()
    {
        $name = $this->argument('name');
        $role = $this->option('role');
        $prefix = $this->option('prefix');
        $nameGroup = strtoupper($name);

        // Generar prefijo por defecto si no se proporciona
        if (empty($prefix)) {
            $prefix = substr(strtolower($name), 0, 5);
        }

        $directoryPath = base_path('routes/menus');
        $fileName = strtolower($name) . '.php';
        $filePath = $directoryPath . '/' . $fileName;

        // Verificar si la carpeta 'menus' existe, si no, crearla
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        $template = $this->getTemplate($name, $role, $prefix, $nameGroup);

        if (File::exists($filePath)) {
            $this->error("File {$fileName} already exists.");
            return;
        }

        File::put($filePath, $template);
        $this->info("File {$fileName} created successfully.");
    }

    protected function getTemplate($name, $role, $prefix, $nameGroup)
    {
        return <<<EOT
<?php

use App\Services\MenuService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| $name Routes
|--------------------------------------------------------------------------
|
*/
/Recuerda que todos loas archivos van presedidos de una palabra clave
\$prefix = '$prefix';

// Inicia un grupo de menús 
MenuService::startGroup('$nameGroup')

->endGroup();

//Agrega un Middleware para un Grupo de Rutas 
//Recuerda nombrar las rutas
Route::middleware(['role:$role'])->group(function () {
    Route::get('/', function () {
        // Uses first & second middleware...
    })->name('$role');

    Route::get('/user/', function () {
        // Uses first & second middleware...
    })->name('$role.name');;
});
EOT;
    }
}
