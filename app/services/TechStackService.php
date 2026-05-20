<?php
namespace App\Services;

use App\Models\Tech;
use App\Repositories\TechStackRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;

class TechStackService {
    public function __construct(
        private TechStackRepository $techStackRepo,
        private  UploadImageService $imageService
    ){}

    public function all(){
        return $this->techStackRepo->all();
    }

    public function find(string $id){
        return $this->techStackRepo->find($id);
    }

    public function store( array $data){
        $result = $this->imageService->upload($data['icon']);

        $data['icon'] = $result['url'];
        $data['logo_public_id'] = $result['public_id'];

        $newTechStack = $this->techStackRepo->store($data);

        return $newTechStack;
    }

    public function update(array $data, Tech $techStack){
        if (isset($data['icon'])){
            $result = $imageService->update($techStack->logo_public_id ,$data['icon']);

            $data['icon'] = $result['url'];
            $data['logo_public_id'] = $result['public_id'];
        }

        $updatedTechStack = $this->techStackRepo->update($techStack->id, $data);

        return $updatedTechStack;
    }

    public function destroy(string $id){
        return $this->techStackRepo->destroy($id);
    }
}