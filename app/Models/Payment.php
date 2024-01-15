<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Attachment;

class Payment extends Model
{
    use HasFactory;

    /** 
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->payer_type = sprintf('App\Models\%s', $model->payer_type);
        });
        static::deleting(function($model) { 
            $model->attachments()->each(function($attachment) {
                $attachment->delete(); 
            });
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
     * Get all of the attachments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'morphable')->with('media');
    }
}
