<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sticker;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stickers', function (Blueprint $table) {
            $table->id();
            $table->date('doi')->default(DB::raw('CURRENT_DATE'));
            $table->date('valid_until');
            $table->tinyInteger('priority')->default(Sticker::PRIORITY_LOW);
            $table->string('message');
            $table->string('contact_email', 100)->nullable($value = true);
            $table->string('contact_phone', 30)->nullable($value = true);
            $table->string('contact_name', 50)->nullable($value = true);
            $table->bigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->index('priority');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stickers');
    }
};
