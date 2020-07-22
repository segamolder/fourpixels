<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@test.loc',
            'password' => Hash::make('password'),
        ]);
        $users = factory(App\Models\User::class, 15)->create();
        $users = factory(App\Models\Department::class, 15)->create();
    }
}
