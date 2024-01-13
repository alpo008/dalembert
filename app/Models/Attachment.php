<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    /** 
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->morphable_type = sprintf('App\Models\%s', $model->morphable_type);
        });
        static::deleting(function($model) { 
            $model->media->delete();
        });
    }

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'morphable_type', 'morphable_id', 'media_id'
    ];

    /**
     * Get the related media file.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    /**
     * Get all of the models that own media.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function morphable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete()
    {
        return parent::delete();
    }
}
