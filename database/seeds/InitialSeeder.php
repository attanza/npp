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
    private $roles = ['Superuser', 'Administrator', 'Customer Service', 'User'];

    public function run()
    {
        for ($i=0; $i < count($this->roles); $i++) {
          $slug = str_slug($this->roles[$i]);
          // Create Roles
          DB::table('roles')->insert([
            'name' => $this->roles[$i],
            'slug' => $slug,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          // Create Users
          DB::table('users')->insert([
            'first_name' => $this->roles[$i],
            'username' => $slug,
            'email' => $slug.'@negeriparapemimpi.com',
            'gender' => 'Male',
            'dob' => Carbon::now(),
            'password' => bcrypt($slug.'@negeriparapemimpi.com'),
            'is_active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          // Create Role User
          DB::table('role_user')->insert([
            'user_id' => $i+1,
            'role_id' => $i+1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          // Activation
          DB::table('activations')->insert([
            'user_id' => $i+1,
            'code' => str_random(60),
            'completed' => 1,
            'completed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          // Profile
          DB::table('profiles')->insert([
            'user_id' => $i+1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          // Dream
          DB::table('dreams')->insert([
            'user_id' => $i+1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        }
    }
}
