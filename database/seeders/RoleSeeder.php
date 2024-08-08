<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$roles = [
			'admin',
			'user',
			'guest',
		];

		foreach ($roles as $roleName) {
			$role = Role::create(['name' => $roleName]);

			switch ($roleName) {
				case 'guest':
					$role->givePermissionTo('guest.permission');
					break;

				case 'user':
					$role->syncPermissions(['guest.permission', 'user.permission']);
					break;

				case 'admin':
					$role->syncPermissions(['guest.permission', 'user.permission', 'admin.permission']);
					break;
			}
		}
	}
}
