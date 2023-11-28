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
        Schema::create('airmax_clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->comment('Airmax clients');
            $table->id();
            $table->string('place', 30)->unique();
            $table->json('location')->nullable($value = true);
            $table->string('name', 100);
            $table->string('email', 100)->nullable($value = true)->unique();
            $table->string('phone', 30)->nullable($value = true);
            $table->string('ap_model', 30)->nullable($value = true);
            $table->macAddress('wlan_mac')->nullable($value = true);
            $table->macAddress('lan_mac')->nullable($value = true);
            $table->macAddress('ap_mac')->nullable($value = true);
            $table->ipAddress('ip_address')->unique();
            $table->string('router_model', 30)->nullable($value = true);
            $table->macAddress('router_mac')->nullable($value = true);
            $table->ipAddress('router_ip_address')->nullable($value = true);
            $table->string('ssid', 30)->unique();
            $table->string('password', 100)->unique();
            $table->timestampTz('installed_on', $precision = 0);
            $table->string('admin', 50)->nullable($value = true);
            $table->timestamps();
            $table->index(['place', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airmax');
    }
};
