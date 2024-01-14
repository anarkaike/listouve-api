<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Upload
{
    static public function uploadFile($file)
    {
        // Generate a unique name for the file
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

        // Store the file in the 'public' disk (you can configure other disks as needed)
        $link = Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        // return public link
        return asset(Storage::url($link));
    }
}
