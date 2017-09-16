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
        $this->role_seeder();
        $this->createUser();
        $this->seedOthers();
        $this->call(DreamSeeder::class);
    }

    private function createUser()
    {
        App\User::truncate();
        factory(App\User::class)->create([
            'first_name' => 'Superuser',
            'username' => 'superuser',
            'email' => 'superuser@superuser.com',
            'password' => bcrypt('password'),
            'is_active' => 1
        ]);

        factory(App\User::class)->create([
          'first_name' => 'Administrator',
          'username' => 'administrator',
          'email' => 'admin@admin.com',
          'password' => bcrypt('password'),
          'is_active' => 1
        ]);

        factory(App\User::class)->create([
          'first_name' => 'Customer Service',
          'username' => 'customer-service',
          'email' => 'customer@service.com',
          'password' => bcrypt('password'),
          'is_active' => 1
        ]);

        factory(App\User::class)->create([
          'first_name' => 'User',
          'username' => 'user',
          'email' => 'user@user.com',
          'password' => bcrypt('password'),
          'is_active' => 1
        ]);
    }

    private function role_seeder(){
      DB::table('roles')->truncate();
      DB::table('roles')->insert([
        'slug' => 'superuser',
        'name' => 'Superuser'
      ]);
      DB::table('roles')->insert([
        'slug' => 'administrator',
        'name' => 'Administrator'
      ]);
      DB::table('roles')->insert([
        'slug' => 'customer-service',
        'name' => 'Customer Service'
      ]);
      DB::table('roles')->insert([
        'slug' => 'user',
        'name' => 'User'
      ]);
    }

    private function seedOthers()
    {
        DB::table('role_user')->truncate();
        App\Models\Profile::truncate();
        App\Models\Activation::truncate();
        App\Models\Dream::truncate();
        App\Models\Media::truncate();

        for ($i=1; $i < 5 ; $i++) {
            DB::table('role_user')->insert([
              'user_id' => $i,
              'role_id' => $i
            ]);

            factory(App\Models\Profile::class)->create([
                'user_id' => $i
            ]);

            factory(App\Models\Activation::class)->create([
                'user_id' => $i
            ]);

            $dream = factory(App\Models\Dream::class)->create([
                'user_id' => $i
            ]);
        }

        factory(App\Models\Product::class)->create([
          'name' => 'NPP Book',
          'stock' => 50,
          'price' => 175000
        ]);
    }
}
