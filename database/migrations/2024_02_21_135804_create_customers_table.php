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
        if ( !Schema::hasTable('customers') ) {
            Schema::create('customers', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_unicode_ci';
                $table->comment('Customers');
                $table->id();
                $table->string('name', 100);
                $table->string('email', 100)->nullable($value = true)->unique();
                $table->string('phone', 30)->nullable($value = true)->unique();
                $table->json('location')->nullable($value = true);
                $table->string('address')->nullable();
                $table->text('comments')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
