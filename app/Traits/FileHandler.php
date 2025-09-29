<?php

namespace App\Traits;

use upload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


trait FileHandler
{

    private $generateThumbStatus = true;
    private $thumbsize = 160;
    private $thumbspath = "attachments/thumbs/";

    public function download_file($path = '', $title  = '')
    {
        $arr = explode('.', $path);
        $mimetype = $arr[count($arr) - 1];
        return response()->download($path, $title . '.' . $mimetype);
    }

    public function upload_file($file, $path = '', $key = "")
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'pdf'];
        $extension = $file->extension();
        if (!in_array($extension, $allowedExtensions)) {
            return 'Invalid file type. Please upload an image or PDF.';
        }
        $imageName = time() . $key . '.' . $extension;
        $path = "attachments/" . $path;
        $image = $file->storeAs($path, $imageName, 'public');

        if($image && $this->generateThumbStatus && $extension !== 'pdf'){
            $thumbnailPath = $this->createThumbnail($image, $path);
        }
        return $image;
    }

    private function createThumbnail($imagepath, $file)
    {
        $image = Image::make(storage_path('app/public/' . $imagepath));
        $thumbnail = $image->resize($this->thumbsize, $this->thumbsize);
        $thumbspath = $this->thumbspath . $file . '/' ;
        $thumbnailPath = $thumbspath .  pathinfo($imagepath)['basename'];
        // if (!file_exists(storage_path('app/public/'. $thumbspath), storage_path('app/public/' . $thumbnailPath))) { 
            @mkdir(storage_path('app/public/'. $thumbspath), 666, true); 
        // }
        $thumbnail->save(storage_path('app/public/' . $thumbnailPath));
        return $thumbnailPath;
    }

    public function delete_file($path = '')
    {
        $thumb_path = str_replace("attachments/", $this->thumbspath, $path);
        if($thumb_path)@Storage::disk('public')->delete($thumb_path);
        if($path)@Storage::disk('public')->delete($path);
    }
    public function delete_dir($path = '')
    {
        File::deleteDirectory($path);
    }
    public function loadArrayFromFile($path)
    {
        return File::getRequire($path);
    }
    public function CopyFileContent($src, $target)
    {
        if ($this->FileExists($src))
            File::copy($src, $target);
    }

    public function PutFileContent($path, $content)
    {
        File::put($path, $content);
    }

    public function GetFileContent($path)
    {
        return File::get($path);
    }

    public function FileExists($path)
    {
        return File::exists($path);
    }
}
