<?php


    namespace App\Services;


    use Illuminate\Support\Facades\Storage;

    class FileService
    {
        public function saveLogo($file, $storage = 'logo', $folder = 'logo') {
            $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = Storage::disk($storage)->putFileAs($folder, $file, $filename);

            if (Storage::disk($storage)->exists($path)) {
                $path = str_replace($folder.'/','',$path);
                return $path;
            }

            return false;
        }
    }
