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
        if ( !Schema::hasTable('airmax_activities') ) {
            Schema::create('airmax_activities', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('airmax_client_id');
                $table->timestamp('changed_at');
                $table->boolean('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airmax_activities');
    }
};
