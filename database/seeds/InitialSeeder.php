<?php

use Illuminate\Database\Seeder;
use App\Models\Activation;
use Carbon\Carbon;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUser();
        $this->role_seeder();
    }

    private function createUser()
    {
        App\User::truncate();
        DB::table('role_user')->truncate();

        factory(App\User::class)->create([
            'first_name' => 'Superuser',
            'username' => 'superuser',
            'email' => 'superuser@superuser.com',
            'password' => bcrypt('password'),
        ]);

        factory(App\User::class)->create([
          'first_name' => 'Administrator',
          'username' => 'administrator',
          'email' => 'admin@admin.com',
          'password' => bcrypt('password'),
        ]);

        factory(App\User::class)->create([
          'first_name' => 'User',
          'username' => 'user',
          'email' => 'user@user.com',
          'password' => bcrypt('password'),
        ]);

        DB::table('role_user')->insert([
          'user_id' => 1,
          'role_id' => 1
        ]);
        DB::table('role_user')->insert([
          'user_id' => 2,
          'role_id' => 2
        ]);
        DB::table('role_user')->insert([
          'user_id' => 3,
          'role_id' => 3
        ]);

        for ($i=1; $i < 4 ; $i++) {
            factory(App\Models\Activation::class)->create([
                'user_id' => $i
            ]);
        }

        for ($i=1; $i < 4 ; $i++) {
            factory(App\Models\Profile::class)->create([
                'user_id' => $i
            ]);
        }
    }

    private function role_seeder(){
      DB::table('roles')->truncate();
      DB::table('roles')->insert([
        'slug' => 'superuser',
        'name' => 'Superuser'
      ]);
      DB::table('roles')->insert([
        'slug' => 'admin',
        'name' => 'Administrator'
      ]);
      DB::table('roles')->insert([
        'slug' => 'user',
        'name' => 'User'
      ]);
    }
}
