<?php
namespace App\Services;

use App\Models\Tech;
use App\Repositories\TechStackRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;

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
        $result = null;

        
        try{
            $result = $this->imageService->upload($data['icon']);

            $data['icon'] = $result['url'];
            $data['logo_public_id'] = $result['public_id'];

            DB::beginTransaction();

            $newTechStack = $this->techStackRepo->store($data);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $newTechStack;
    }

    public function update(array $data, Tech $techStack){
        $result = null;

        try{
            if (isset($data['icon'])){
                $result = $this->imageService->update($techStack->logo_public_id ,$data['icon']);

                $data['icon'] = $result['url'];
                $data['logo_public_id'] = $result['public_id'];
            }
            
            DB::beginTransaction();

            $updatedTechStack = $this->techStackRepo->update($techStack->id, $data);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $updatedTechStack;
    }

    public function destroy(string $id){
        return $this->techStackRepo->destroy($id);
    }
}
