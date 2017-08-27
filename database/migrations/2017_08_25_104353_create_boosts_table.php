<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boostable_id', 36);
            $table->string('boostable_type', 255);
            $table->string('user_id', 36)->index();
            $table->timestamps();
            $table->unique(['boostable_id', 'boostable_type', 'user_id']);
        });

        // Schema::create('boost_counters', function(Blueprint $table) {
    		// 	$table->increments('id');
    		// 	$table->string('boostable_id', 36);
    		// 	$table->string('boostable_type', 255);
    		// 	$table->unsignedInteger('count')->default(0);
    		// 	$table->unique(['boostable_id', 'boostable_type'], 'boost_counters');
    		// });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boosts');
    }
}
