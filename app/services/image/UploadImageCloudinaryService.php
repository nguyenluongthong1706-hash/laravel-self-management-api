<?php
namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Cloudinary\Cloudinary;

class UploadImageCloudinaryService implements UploadImageService{
    protected Cloudinary $cloudinary;

    public function __construct(){
        $this->cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    }

    public function checkIsExists(string $public_id):bool{
        try{
            $this->cloudinary->adminApi()->asset($public_id);
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function delete(string $public_id):bool{
        try{
            $this->cloudinary->uploadApi()->destroy($public_id);
            return ($result['result'] ?? '') === 'ok';
        }catch(Exception $e){
            report($e);
            return false;
        }
    }

    public function upload(UploadedFile $file):array{
        $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(),['folder'=>'upload']);
        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id']
        ];
    }

    public function update(?string $public_id, UploadedFile $file):array{
        if($public_id){
            $this->delete($public_id);
        }
        return $this->upload($file);
    }
}