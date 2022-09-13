<?php
namespace App\Traits;
use Storage;

trait Uploader {
  public function fileUpload($base64, $dir){
    $extension = explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];   // .jpg .png .pdf
    $replace = substr($base64, 0, strpos($base64, ',')+1); 
    $file = str_replace($replace, '', $base64); 
    $file = str_replace(' ', '+', $file); 
    $name = strtotime("now").'.'.$extension;

    $path = $dir.$name;
    $storage = Storage::disk('local');
    if (!is_dir($storage->path($dir))){ $storage->makeDirectory($dir, 0775, true); }
    if ($storage->exists($path)) { $storage->delete($path); }
    $storage->put($path, base64_decode($file));
    return $name;
  }
}
