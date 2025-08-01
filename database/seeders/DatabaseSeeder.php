<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
  public function run()
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);

        // Create permissions
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        // Get the first user, or create one
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign role
        $user->assignRole('admin');
    }
}
