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
        Schema::table('stickers', function (Blueprint $table) {
            $table->string('link_text', 127)->nullable();
            $table->string('link_address', 255)->nullable();
            $table->longText('message')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stickers', function (Blueprint $table) {
            $table->dropColumn('link_text');
            $table->dropColumn('link_address');
            $table->string('message')->nullable(false)->change();
        });
    }
};
