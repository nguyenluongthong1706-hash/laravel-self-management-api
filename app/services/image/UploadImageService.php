<?php
namespace App\Services\Image;
use Illuminate\Http\UploadedFile;

interface UploadImageService{
    public function checkIsExists(string $public_id):bool;

    public function delete(string $public_id):bool;

    public function upload(UploadedFile $file):array;

    public function update(string $public_id, UploadedFile $file):array;
}