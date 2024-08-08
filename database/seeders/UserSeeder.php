<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Roles disponibles
		$roles = Role::all()->pluck('name')->toArray();

		// Crear usuarios
		$users = [
			['name' => 'Admin User', 'role' => 'admin', 'email' => 'admin@gmail.com'],
			['name' => 'Regular User', 'role' => 'user', 'email' => 'user@gmail.com'],
			['name' => 'Guest User', 'role' => 'guest', 'email' => 'guest@gmail.com'],
		];

		foreach ($users as $userData) {
			$user = User::create([
				'name' => $userData['name'],
				'email' => $userData['email'],
				'password' => Hash::make('123456'),
				'email_verified_at' => now(),
				'remember_token' => Str::random(10),
			]);

			// Verifica si el rol existe antes de asignar
			if (in_array($userData['role'], $roles)) {
				$user->assignRole($userData['role']);
			}
		}
	}
}
