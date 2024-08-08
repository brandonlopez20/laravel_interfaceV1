<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MenuService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{

		View::composer('layouts.partials.sidebar', function ($view) {
			$auth = auth()->user();
			$panels = MenuService::getFilteredMenus($auth);
			$arrayDuplicado = array_merge($panels);
			$view->with('panels', $arrayDuplicado);
		});

		View::composer('welcome', function ($view) {
			// MenuService::showLogo(false);
			// MenuService::showProfile(false);
			// MenuService::showInputSearch(false);
			// MenuService::setBgColor("#13033a");
			// MenuService::setTextColor("#ccc");
			$data = MenuService::getSettings('main');
			$view->with('data', $data);
		});


		View::composer('layouts.partials.logo', function ($view) {
			// MenuService::LogoURL('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtB5nfpgYTUfNlTZoZpFv3hHknh-U3Nb7Ydg&s');
			$data = MenuService::getSettings('logo');
			$view->with('data', $data);
		});

		View::composer('layouts.partials.profile', function ($view) {
			// MenuService::ProfileName('Hello World');
			// MenuService::ProfileURL('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROqLePMmMp7gPNdyb5Go2ikRCw9l0Atx1eag&s');
			$data = MenuService::getSettings('profile');
			$view->with('data', $data);
		});

		View::composer('layouts.partials.navbar', function ($view) {
			// MenuService::showTitle(false);
			// MenuService::buttonTheme(false);
			// MenuService::buttonConfig(false);
			MenuService::Options('Notifications','eva-bell-outline', 'btn-notify', 100);
			MenuService::Options('Notifications','eva-bell-outline', 'btn-notify2', 100);
			MenuService::Options('Notifications','eva-bell-outline', 'btn-notify3', 100);
			MenuService::Options('Notifications','eva-bell-outline', 'btn-notify4', 100);
			MenuService::Options('Notifications','eva-bell-outline', 'btn-notify5');
			$data = MenuService::getSettings('navbar');

			$view->with('data', $data);
		});
	}
}
