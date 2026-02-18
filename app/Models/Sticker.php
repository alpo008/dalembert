<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
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

    public static function getActive()
    {
        $today = date('Y-m-d', time());
        return self::with('attachments')->where('valid_until', '>=', $today)->get();
    }
}
