<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    /** 
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) { 
            Storage::disk($model->disk)->delete($model->path);
        });
    }

    protected $file;

    public function setFile($file)
    {
        $this->file = $file;
    }
    
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
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        return ($this->saveFile() && parent::save());
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
        //Storage::disk($this->disk)->delete($this->path);
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

    /**
     * Save the file in storage.
     *
     * @param  array  $options
     * @return bool
     */
    private function saveFile()
    {
        if($this->file instanceof \Illuminate\Http\UploadedFile) {
            $name = $this->file->hashName();
            $dir = $this->path;
            if ($this->disk === 'public') {
                $storagePath = 'app/public/';
                $this->path = 'public/' . $this->path . '/' . $name;
            } else {
                $storagePath = 'app/';
                $this->path .= '/' . $name;
            }
            Storage::disk($this->disk)->put($dir, $this->file);
            $storagePath = $this->disk === 'public' ? 'app/public/' : 'app/';
            $this->file_hash = hash_file('sha256', 
                storage_path(path: $storagePath . $dir . "/{$name}")
            );
            return true;
        }
        return false;
    }
}
