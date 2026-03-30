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
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('platform');
            $table->string('uuid');
            $table->string('version');
            $table->string('manufacturer');
            $table->string('serial');
            $table->string('action');
            $table->timestamps();

            $table->index('uuid');
            $table->index('serial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_logs');
    }
};
