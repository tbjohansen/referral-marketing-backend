<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper{

    /**
     * UPLOAD File
     * @param mixed $path
     * @param mixed $file
     * @param mixed $fileName
     */
    static public function uploadFile($path, $file, $prefix = ""){
        $fileName = $prefix.$file->hashName();
        $upload = Storage::putFileAs($path, $file, $fileName);
        if (!$upload) {
            return false;
        }
        return $fileName;
    }

    /**
     * DELETE file
     * @param mixed $path
     * @return bool
     */
    static public function deleteFile($path){
        $delete = Storage::delete('/public/'.$path);
        if (!$delete) {
            return false;
        }
        return true;
    }
    
    /**
     * DELETE directory
     * @param mixed $path
     * @return bool
     */
    static public function deleteDirectory($path){
        $delete = Storage::deleteDirectory('/public/'.$path);
        if (!$delete) {
            return false;
        }
        return true;
    }

    /**
     * storagePath
     * @param mixed $file
     * @param mixed $path
     * @return string
     */
    static function storagePath($file, $path){
        $storage_path = "/storage/".$path.'/'.$file;
        return asset($storage_path);
    }

}