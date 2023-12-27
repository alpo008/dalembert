<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'doi', 'description', 'size', 'uploaded_by'
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'doi' => 'datetime:Y-m-d',
    ];

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete()
    {
        Storage::disk($this->disk)->delete($this->path);
        return parent::delete();
    }

    /** 
     * Get contents of mediafile
     * 
     * @return string
     */
    public function getContents() {
        return Storage::get($this->path);
    }
}
