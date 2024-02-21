<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Фрекен Бок',
            'email' => env('MAIL_FROM_ADDRESS'),
            'phone' => '492267851111',
            'location' => '{"lat":"59.31517136256422","lng":"17.779141100895014"}'
        ]);
    }
}
