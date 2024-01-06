<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payer_type', 'payer_id', 'doi', 'amount', 'destination', 'created_by', 'comments'
    ];

    /**
     * Get all of the models that own payments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function payer(): MorphTo
    {
        return $this->morphTo();
    }
}
