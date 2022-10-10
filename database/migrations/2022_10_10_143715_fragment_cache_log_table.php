<?php

use Illuminate\Database\Migrations\Migration;

class FragmentCacheLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('log_cache_fragments', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('key')->index();
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->integer('status')->default(0)->index(); //0 = not found, 1 = found, 2 = forced
            $table->integer('timing')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('log_cache_fragments');
    }
}
