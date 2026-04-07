<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AppRegistration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('device_uuid')->nullable();
            $table->string('device_serial')->nullable();
            $table->tinyInteger('app_id')->default(AppRegistration::APP_GWEATHER);
            $table->string('app_key');
            $table->bigInteger('customer_id');
            $table->timestamps();

            $table->index('app_id');
            $table->index('device_uuid');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_registrations');
    }
};
