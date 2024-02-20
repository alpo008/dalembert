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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('Work title');
            $table->decimal('price', $precision = 8, $scale = 2)->comment('Work price');
            $table->string('unit')->comment('Work unit');
            $table->string('category')->default('generic')->comment('Work category');
            $table->text('comments')->nullable()->comment('Comments');
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
        Schema::dropIfExists('works');
    }
};
