<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Attachment;

class Sticker extends Model
{
    use HasFactory;

    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;

    /** 
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
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
        'doi', 'valid_until', 'priority', 'message', 'contact_email', 'contact_phone', 'contact_name', 
        'created_by'
    ];

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
