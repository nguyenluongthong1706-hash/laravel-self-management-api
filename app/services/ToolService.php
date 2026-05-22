<?php
namespace App\Services;

use App\Models\Tool;
use App\Repositories\ToolRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;

class ToolService {
    public function __construct(
        private ToolRepository $toolRepo, 
        private UploadImageService $imageService
    ){}

    public function all(){
        return $this->toolRepo->all();
    }

    public function find(string $id){
        return $this->toolRepo->find($id);
    }

    public function store( array $data){
        $result = null;

        DB::beginTransaction();

        try{
            $result = $this->imageService->upload($data['icon']);

            $data['icon'] = $result['url'];
            $data['logo_public_id'] = $result['public_id'];

            $newTool = $this->toolRepo->store($data);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $newTool;
    }

    public function update( array $data, Tool $tool){
        $result = null;

        DB::beginTransaction();

        try{
            if (isset($data['icon'])){
                $result = $this->imageService->update($tool->logo_public_id , $data['icon']);

                $data['icon'] = $result['url'];
                $data['logo_public_id'] = $result['public_id'];
            }

            $updatedTool = $this->toolRepo->update($tool->id, $data);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $updatedTool;
    }

    public function destroy(string $id){
        return $this->toolRepo->destroy($id);
    }
}