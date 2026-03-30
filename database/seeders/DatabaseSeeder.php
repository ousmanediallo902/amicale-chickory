<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Utilisateur admin par défaut pour la connexion
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            // Mot de passe: password
            'password' => '1234',
        ]);
    }
}
