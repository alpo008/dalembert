<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Attachment;

class Payment extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->payer_type = sprintf('App\Models\%s', $model->payer_type);
        });
    }

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

    /**
     * Get the attachments for the payment.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'object_id')
            ->with('media')
            ->where('object', '=', 'payments');
    }
}
