<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'collection', 'file_name', 'mime_type', 'path', 'disk', 'file_hash',
        'description', 'size', 'uploaded_by'
    ];
}
