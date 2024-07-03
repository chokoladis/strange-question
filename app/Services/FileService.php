<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileService {

    const MAX_FILE_SIZE = 3150000;
    const MAX_FILE_SIZE_MB = self::MAX_FILE_SIZE/1048576;

    public static function createThumbWebp(string $filePath){

        $imgManager = new ImageManager(new Driver());

        $realPath = public_path().Storage::url($filePath);

        $image = $imgManager->read($realPath);

        $size = filesize($realPath); // bites
        $kbSize = $size / 1024;
        if ($kbSize > 100){

            $pathInfo = pathinfo($filePath);

            $newFilepath = $pathInfo['dirname'].$pathInfo['filename'].'.webp';
            
            $image->resize(300)->toWebp(80)->save($newFilepath);
        }
        
        dd($newFilepath, $image, $kbSize);
    }

    public static function save(UploadedFile $img, $mainDir = 'main'){
        
        $root = public_path() . '/storage/' . $mainDir;

        $subDir = substr($img->hashName(), 0, 3 );
        
        try {
            if (!is_dir($root)){
                mkdir($root, 755);
            }
    
            $folder = $root.'/'.$subDir.'/';
            if (!is_dir($folder)){
                mkdir($folder, 755);
            }
            
            $ext = $img->extension();
            $name = $img->hashName();
            $filePath = $subDir.'/'.$img->hashName();
    
            $img->move($folder, $img->hashName());        
    
            $data = [
                'name' => $name,
                'expansion' => $ext,
                'path' => $filePath, 
            ];
    
            $file = File::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

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
