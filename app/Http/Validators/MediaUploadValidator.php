
<?php

namespace App\Http\Validators;

use Illuminate\Validation\Rules\File;

class MediaUploadValidator
{
    public function documents(): array
    {
        return [
            'required',
            File::types(['png', 'jpg', 'pdf'])->max(1 * 1024)
        ];
    }
}