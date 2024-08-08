<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;


class MenuSettings
{

	protected static $showTitle = true;
	protected static $buttonTheme = true;
	protected static $buttonConfig = true;
	protected static $showLogo = true;
	protected static $showProfile = true;
	protected static $showInputSearch = true;
	protected static $options = [];
	protected static $profileName = 'Hello World';
	protected static $profileURL = 'https://lh4.googleusercontent.com/proxy/RfaxLRKZetloM_29xXhgHCknbckYymU0KZVrf8DPn-R9Bx_AeumcexzxIIxyEJxDHo-S5cjx6CRpj0-4WTlBUdqLgbONNGX9zoK-QkbcepXJv55I36NTQDd198mczV814Gcd8n0X2Y2brVNCJeEE4fSIJncB8ix8aZok_kQc5hD6l1usM0NpOLTlUUYdqv_HvIvW1CZfGD8b72Nc_X2G3c9e37bFjXYeTg';
	protected static $logoURL = 'https://upcv.gob.gt/inicio/wp-content/uploads/2024/03/logobiernoazul.png';

	protected static $bgColor = '#333';
	protected static $textColor = '#ccc';
	protected static $hoverColor = "#0d6efd";

	public static function setBgColor($color)
	{
		// Verificar si el color es un valor hexadecimal válido
		if (self::isValidHexColor($color)) {
			self::$bgColor = $color;
		} else {
			throw new \Exception("El color proporcionado no es un valor hexadecimal válido.");
		}
	}

	// Verificar si el color es un valor hexadecimal válido
	private static function isValidHexColor($color)
	{
		return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color);
	}

	public static function setTextColor($color)
	{
		self::$textColor = $color;
	}

	public static function setHoverColor($color)
	{
		self::$hoverColor = $color;
	}

	public static function ProfileURL($ProfileURL)
	{
		self::$profileURL = $ProfileURL;
	}

	public static function ProfileName($ProfileName)
	{
		self::$profileName = $ProfileName;
	}

	public static function showLogo(bool $showLogo = true)
	{
		self::$showLogo = $showLogo;
	}
	public static function LogoURL($logoURL)
	{
		self::$logoURL = $logoURL;
	}
	public static function showInputSearch(bool $showInputSearch = true)
	{
		self::$showInputSearch = $showInputSearch;
	}
	public static function showProfile(bool $showProfile = true)
	{
		self::$showProfile = $showProfile;
	}

	public static function Options($span, $icon, $id, $value = false)
	{
		// Verificar si ya hay 6 elementos en el array
		if (count(self::$options) < 5) {
			// Si $value es un número y es mayor a 100, convertirlo a '99+'
			if ($value && is_numeric($value) && $value > 99) {
				$value = '99+';
			}

			// Agregar los parámetros al array $options
			self::$options[] = [
				'span' => $span,
				'icon' => $icon,
				'value' => $value,
				'id' => $id
			];
		} else {
			// Lanzar una excepción si se intenta agregar más de 6 elementos
			throw new \Exception("No se pueden agregar más de 6 elementos de Opciones.");
		}
	}

	public static function showTitle(bool $showTitle = true)
	{
		self::$showTitle = $showTitle;
	}

	public static function buttonTheme(bool $buttonTheme = true)
	{
		self::$buttonTheme = $buttonTheme;
	}

	public static function buttonConfig(bool $buttonConfig = true)
	{
		self::$buttonConfig = $buttonConfig;
	}

	public static function getSettings($component)

	{
		// Usar switch para manejar diferentes casos
		switch ($component) {
			case 'navbar':
				return [
					'showtitle' => self::$showTitle,
					'buttontheme' => self::$buttonTheme,
					'buttonconfig' => self::$buttonConfig,
					'options' => self::$options,
				];
			case 'logo':
				return [
					'logourl' => self::$logoURL,
				];
			case 'main':
				return [
					'showlogo' => self::$showLogo,
					'showprofile' => self::$showProfile,
					'showinput' => self::$showInputSearch,
					'bgcolor' => self::$bgColor,
					'hovercolor' => self::$hoverColor,
					'textcolor' => self::$textColor,
				];
			case 'profile':
				return [
					'profileurl' => self::$profileURL,
					'profilename' => self::$profileName,
				];
			default:
				throw new \Exception("No se pueden añadir las configuraciones por falta de directivas al MenuServiceProvider.");
				break;
		}
	}
}


class MenuService extends MenuSettings
{
	protected static $data = [];
	protected static $currentGroup = null;
	protected static $currentMenu = null;
	protected static $currentMenuCollection = null;
	protected static $currentSubmenu = null;

	// Inicia un nuevo grupo de menús
	public static function startGroup($name)
	{
		$groupName = strtoupper($name);
		self::$currentGroup = [
			'group' => $groupName,
			'menus' => []
		];
		return new static;
	}

	// Añade un menú al grupo actual
	public function addMenu($name, $path, $icon = 'eva-folder')
	{

		if (self::$currentMenuCollection !== null) {
			throw new \Exception("No se pueden añadir menús directamente a una colección de menús.");
		}

		self::$currentMenu = [
			'name' => $name,
			'path' => $path,
			'icon' => $icon,
			'submenus' => [],
			'roles' => []
		];
		return $this;
	}

	// Añade una colección de submenús al menú actual
	public function addMenuCollection($name, $icon = 'eva-folder-add')
	{
		if (self::$currentMenu !== null) {
			throw new \Exception("No se pueden añadir colecciones de submenús a un menú que ya tiene roles asignados.");
		}

		self::$currentMenuCollection = [
			'name' => $name,
			'icon' => $icon,
			'submenus' => []
		];
		return $this;
	}

	// Añade un submenú a la colección de submenús
	public function addSubmenu($name, $path, $icon = 'vaadin-dot-circle')
	{
		if (self::$currentMenuCollection === null) {
			throw new \Exception("No se puede añadir un submenú fuera de una colección de submenús.");
		}

		self::$currentSubmenu = [
			'name' => $name,
			'path' => $path,
			'icon' => $icon,
			'roles' => []
		];
		return $this;
	}

	// Añade roles al menú o submenú actual
	public function addRoles(...$roles)
	{
		if (self::$currentSubmenu !== null) {
			self::$currentSubmenu['roles'] = array_merge(self::$currentSubmenu['roles'], $roles);
		} elseif (self::$currentMenu !== null) {
			self::$currentMenu['roles'] = array_merge(self::$currentMenu['roles'], $roles);
		} else {
			throw new \Exception("No hay un menú o submenú actual definido para añadir roles.");
		}
		return $this;
	}

	// Finaliza el submenú actual y lo añade a la colección de submenús
	public function endSubmenu()
	{
		if (self::$currentSubmenu !== null) {
			self::$currentMenuCollection['submenus'][] = self::$currentSubmenu;
			self::$currentSubmenu = null; // Resetear el submenú actual después de agregarlo
		}
		return $this;
	}

	// Finaliza la colección de submenús y la añade al grupo
	public function endMenuCollection()
	{
		if (self::$currentMenuCollection !== null) {
			self::$currentGroup['menus'][] = self::$currentMenuCollection;
			self::$currentMenuCollection = null; // Resetear la colección de submenús después de agregarla
		}
		return $this;
	}

	// Finaliza el menú actual y lo añade al grupo
	public function endMenu()
	{
		if (self::$currentMenu !== null) {
			self::$currentGroup['menus'][] = self::$currentMenu;
			self::$currentMenu = null; // Resetear el menú actual después de agregarlo
		}
		return $this;
	}

	// Finaliza el grupo actual y lo añade a la colección
	public function endGroup()
	{
		if (self::$currentGroup !== null) {
			self::$data[] = self::$currentGroup;
			self::$currentGroup = null; // Resetear el grupo actual después de agregarlo
		}
		return $this;
	}

	// Devuelve toda la estructura de menús
	public static function getAll()
	{
		return self::$data;
	}

	public static function getFilteredMenus($user)
	{
		$filteredGroups = [];

		foreach (self::$data as $group) {
			$filteredMenus = [];

			foreach ($group['menus'] as $menu) {
				// Filtra el menú basado en roles del usuario
				if (self::checkAccess($menu, $user)) {
					$filteredMenu = $menu;
					// Filtra los submenús del menú actual
					if (isset($filteredMenu['submenus'])) {
						$filteredSubmenus = [];
						foreach ($filteredMenu['submenus'] as $submenu) {
							if (self::checkAccess($submenu, $user)) {
								$filteredSubmenus[] = $submenu;
							}
						}

						// Solo añadir submenús accesibles
						if (!empty($filteredSubmenus)) {
							$filteredMenu['submenus'] = $filteredSubmenus;
						} else {
							// Elimina la clave 'submenus' si no hay submenús accesibles
							unset($filteredMenu['submenus']);
						}
					}

					// Solo añadir el menú si tiene submenús visibles o si el menú en sí mismo es accesible
					if (isset($filteredMenu['submenus']) || !empty($filteredMenu['path'])) {
						$filteredMenus[] = $filteredMenu;
					}
				}
			}

			// Solo añadir el grupo si tiene menús visibles
			if (!empty($filteredMenus)) {
				$group['menus'] = $filteredMenus;
				$filteredGroups[] = $group;
			}
		}

		return $filteredGroups;
	}

	// Verifica acceso basado en roles
	protected static function checkAccess($menuItem, $user)
	{
		// Verifica si el usuario tiene alguno de los roles requeridos para el menú o submenú
		if (!empty($menuItem['roles'])) {
			$userRoles = $user->roles->pluck('name')->toArray();
			$requiredRoles = $menuItem['roles'];
			if (empty(array_intersect($userRoles, $requiredRoles))) {
				return false; // No tiene acceso si no tiene los roles requeridos
			}
		}

		// Si el menú no tiene submenús, su visibilidad depende únicamente de los roles
		return true;
	}
}
