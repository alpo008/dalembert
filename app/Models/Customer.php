<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'location', 'address', 'comments'];

    public $timestamps = false;

    /**
     *
     * @var array
     */
    protected $casts = [
        'location' => 'array'
    ];
}
