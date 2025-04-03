<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $employes = Employe::all();

        foreach ($employes as $employe) {
            User::updateOrCreate(
                ['email' => strtolower($employe->Prenom . '.' . $employe->Nom . '@bkfood.com.tn')],
                [
                    'name' => $employe->Nom . ' ' . $employe->Prenom,
                    'password' => Hash::make('12345678'), // Mot de passe par défaut
                    'role' => 'user',
                    'MLE' => $employe->MLE,
                ]
            );
        }
    }
}
