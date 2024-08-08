<?php

use App\Services\MenuService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| welcome Routes
|--------------------------------------------------------------------------
|
*/

$prefix = '/welcome2';

// Inicia un grupo de menús 
MenuService::startGroup('WELCOME')
    ->addMenu("Welcome Route", 'hola')
    ->endMenu()
    ->addMenuCollection('Welcome Menu')
    ->addSubmenu('submenu', 'content.welcome')
    ->addRoles('guest')
    ->endSubmenu()
    ->endMenuCollection()
->endGroup();


Route::get('/hola', function () {
    return view('page');
})->name('hola');

Route::get('/', function () {
    return view('page');
})->name('content.welcome');

