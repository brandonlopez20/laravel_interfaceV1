<?php

use App\Models\User;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Inicia un grupo de menús llamado 'AGENDA'
// Inicia un grupo de menús
// Crear menús y submenús
// MenuService::startGroup('AGENDA')
// 	->addMenu('Agenda', '/agenda', 'vaadin-notebook')
// 	// ->addRoles('admin menu', 'guest') // Asignar roles al menú
// 	->endMenu()
// 	->addMenuCollection('Submenús de Agenda')
// 	->addSubmenu('Ver Agenda', '/agenda/view', 'vaadin-eye')
// 	->addRoles('adimguest', 'editor') // Asignar roles al submenú
// 	->endSubmenu()
// 	->addSubmenu('Editar Agenda', '/agenda/edit', 'vaadin-edit')
// 	// ->addRoles('admin submenu1', 'adin guest') // Solo 'admin' puede editar
// 	->endSubmenu()
// 	->endMenuCollection()
// 	->endGroup();

	// MenuService::startGroup('AGENDA')
	// ->addMenu('Agenda Group 2', '/agenda', 'vaadin-notebook')
	// ->endMenu()
	// ->addMenuCollection('Submenús de Agenda')
	// ->addSubmenu('Ver Agenda', '/agenda/view', 'vaadin-eye')
	// ->addRoles('213guest', 'editor') // Asignar roles al submenú
	// ->endSubmenu()
	// ->addSubmenu('Editar Agenda', '/agenda/edit', 'vaadin-edit')
	// ->addRoles('admin submenu1', 'adin guest') // Solo 'admin' puede editar
	// ->endSubmenu()
	// ->endMenuCollection()
	// ->endGroup();


MenuService::startGroup('AGENDA 2')
	->addMenu('Agenda 2','content2', 'vaadin-notebook')
	->endMenu()
	->addMenuCollection('Submenús de Agenda')
	->addSubmenu('Ver Agenda 2', 'content', 'vaadin-eye')
	->endSubmenu()
	->addSubmenu('Editar Agenda 2', 'content.dash', 'vaadin-edit')
	->endSubmenu()
	->endMenuCollection()
	->endGroup();



Route::get('/', function () {
	return view('welcome');
})->name('content2');


Route::get('/menus', function () {

	$auth = auth()->user();
	$user = User::find($auth->id - 2);
	$filteredMenus = MenuService::getFilteredMenus($auth);
	// $filteredMenus = MenuService::getAll();
	return response()->json($filteredMenus);
});

Route::get('/content', function () {
	return view('page');
});

Route::get('/content1', function () {
	return view('page2');
})->name('content');

Route::get('/dashboard', function () {
	return view('dashboard');
})->name('content.dash');


Route::get('/login', function () {
	// Verifica si el usuario existe
	$user = User::where('name', 'guest user')->first();

	if (!$user) {
		// Maneja el caso en que el usuario no se encuentra
		return response()->json(['message' => 'User not found'], 404);
	}

	// Autentica al usuario
	Auth::login($user);

	// Retorna una respuesta exitosa
	return response()->json(['message' => 'Authenticated successfully']);
});

Route::get('/logout', function () {
	Auth::logout(); // Cierra la sesión del usuario
	return response()->json(['message' => 'Logout successfully']);
});

Route::get('/user', function () {
	$auth = Auth::user();
	if (!$auth) {
		return response()->json(['User' => 'Nothing User']);
	}
	$user = User::with('roles.permissions')->find($auth->id);
	return $user;
});
