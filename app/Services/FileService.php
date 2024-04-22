<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;

class FileService {

    const MAX_FILE_SIZE = 3150000;
    const MAX_FILE_SIZE_MB = self::MAX_FILE_SIZE/1048576;

    public static function save(UploadedFile $img){
        
        $path = $img->path();
        $ext = $img->extension();
        $name = $img->hashName();

        $data = [
            'name' => $name,
            'expansion' => $ext,
            'path' => $path, 
        ];
        // dd($data);

        $file = File::create($data);

        return $file;
    }

    static protected function generatePhotoPath($file, $mainDir){

        $salt = auth()->user()->id.'_2901';
            
        $file_name = md5($salt.'_'.$file->getClientOriginalName());
        $file_name = mb_substr($file_name, 0, 16).'.'.$file->extension();
        
        $mk_name = substr($file_name,0,3);

        $folder = public_path() . $mainDir . $mk_name;
        if (!is_dir($folder)){
            mkdir($folder, 755);
        }

        return [ 'subdir' => $mk_name, 'file_name' => $file_name ];
    }   
}
