<?php

use Illuminate\Database\Seeder;
use App\Models\DreamComment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DreamComment::truncate();
        for ($i=1; $i < 6; $i++) {
            factory(DreamComment::class)->create([
              'user_id' => rand(5,6),
              'dream_id' => 5,
              'parent_id' => 0
            ]);
        }

        for ($i=1; $i < 21; $i++) {
            factory(DreamComment::class)->create([
              'user_id' => rand(5,6),
              'dream_id' => 5,
              'parent_id' => rand(1,20)
            ]);
        }
        // $comments = factory(DreamComment::class, 5)->create([
        //   'user_id' => rand(5,6),
        //   'dream_id' => 5,
        // ])->each(function($c){
        //   factory(DreamComment::class, 3)->create([
        //     'user_id' => rand(5,6),
        //     'dream_id' => 5,
        //     'parent_id' => $c->id
        //   ]);
        // });
    }
}
