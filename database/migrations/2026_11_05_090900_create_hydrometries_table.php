<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydrometries', function (Blueprint $table) {
            $table->id();
            $table->integer('level_headwater_iv')->nullable();
            $table->integer('level_local')->nullable();
            $table->decimal('temp_ext', 3, 1)->nullable();
            $table->decimal('temp_local', 3, 1)->nullable();
            $table->integer('ice_thickness_ext')->nullable();
            $table->integer('ice_thickness_local')->nullable();
            $table->tinyInteger('turbulence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydrometries');
    }
};
