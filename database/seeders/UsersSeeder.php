<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'userid'=>'superadmin',
            'name'=>'superadmin',
            'password'=>bcrypt('password'),
            'email'=>'admin@admin.com',
            'id_akses'=>1,
            'isActive'=>0,
            'created_by'=>'superadmin',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
