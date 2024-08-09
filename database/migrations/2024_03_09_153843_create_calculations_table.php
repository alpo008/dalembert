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
        if ( !Schema::hasTable('calculations') ) {
            Schema::create('calculations', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('name')->comment('Text identifier');
                $table->bigInteger('customer_id');
                $table->decimal('sum', $precision = 8, $scale = 2)->comment('Total sum');
                $table->json('works')->comment('Works list');
                $table->integer('days')->comment('Works duration')->nullable();
                $table->text('comments')->comment('Comments')->nullable();
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
        Schema::dropIfExists('calculations');
    }
};
