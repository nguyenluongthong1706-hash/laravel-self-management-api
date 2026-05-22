<?php
namespace App\Services;

use Illuminate\Support\Arr;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;

class ProductService {
    public function __construct(
        private ProductRepository $ProductRepo, 
        private UploadImageService $imageService
    ){}

    public function all(){
        return $this->ProductRepo->all();
    }

    public function getByAccount(string $user_id){
        return $this->ProductRepo->getByAccount($user_id);
    }

    public function find(string $id){
        return $this->ProductRepo->find($id);
    }

    public function store( string $user_id, array $data){
        $result = null;

        try{
            $result = $this->imageService->upload($data['image']);
            $data['image'] = $result['url'];
            $data['image_public_id'] = $result['public_id'];

            DB::beginTransaction();

            $productData = collect($data)->only(['name','description','task','image','image_public_id','start_date','end_date','user_id'])->toArray();
            $productData['user_id']= $user_id;

            $links = $data['links']; 
            $techIds = Arr::isAssoc($data['techs'])
            ? collect($data['techs'])->pluck('tech_id')->toArray() 
            : $data['techs'];

            $newProduct = $this->ProductRepo->store($productData);

            $newProduct->links()->createMany($links);

            $newProduct->techs()->attach($techIds);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $newProduct;
    }

    public function assignTechs(string $product_id, array $data){
        $techIds = collect($data['techs'])->pluck('tech_id')->toArray();

        $product = $this->find($product_id);
        
        return DB::transaction(function() use ($product, $techIds, $product_id){
            $existingTechIds = $product->techs()
                ->whereIn('techs.id', $techIds)
                ->pluck('techs.id')
                ->toArray();

            if (!empty($existingTechIds)) {
                throw new BusinessException('Some techs already exist in product', 409);
            }

            $product->techs()->attach($techIds);

            $updatedProduct = $this->find($product_id);

            return $updatedProduct->techs;
        });    
    }

    public function unAssignTech(string $product_id, string $tech_id){
        $product = $this->find($product_id);

        if (!$product->techs()->where('techs.id', $tech_id)->exists()) {
            throw new BusinessException('This tech does not exist in product', 404);
        }

        $product->techs()->detach($tech_id);

        return true;
    }

    public function update(array $data, Product $product){
        $result = null;

        try{
            if (isset($data['image'])){
                $result = $this->imageService->update($product->image_public_id ,$data['image']);

                $data['image'] = $result['url'];
                $data['image_public_id'] = $result['public_id'];
            }
            DB::beginTransaction();
            $updateProduct = $this->ProductRepo->update($product->id, $data);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

        return $updateProduct;
    }

    public function destroy(string $id){
        return $this->ProductRepo->destroy($id);
    }
}
