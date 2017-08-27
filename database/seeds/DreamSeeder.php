<?php

use Illuminate\Database\Seeder;

class DreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->dreamSeed();
        $this->seedBoost();
    }

    private function dreamSeed()
    {
        for ($i=1; $i < 51; $i++) {
            $user = factory(App\User::class)->create([
              'is_active' => 1
            ]);

            factory(App\Models\Profile::class)->create([
              'user_id' => $user->id
            ]);

            factory(App\Models\Activation::class)->create([
              'user_id' => $user->id
            ]);

            $dream = factory(App\Models\Dream::class)->create([
              'user_id' => $user->id
            ]);

            DB::table('role_user')->insert([
              'user_id' => $user->id,
              'role_id' => 4,
            ]);

            App\Models\Media::create([
              'mediable_id' => $dream->id,
              'mediable_type' => 'App\Models\Dream',
              'folder' => 'public/defaults/',
              'filename' => 'default_dream.jpg',
              'mime' => 'image/jpg',
              'size' => '1000',
              'extension' => 'jpg',
              'caption' => str_slug($dream->dream)
            ]);
        }
    }

    private function seedBoost()
    {
        for ($i=1; $i < 50; $i++) {
            factory(App\Models\Boost::class)->create([
              'boostable_id' => 5,
              'user_id' => $i
            ]);
        }
    }
}
