<?php
namespace App\Services;

use Illuminate\Support\Arr;
use App\Modals\Product;
use App\Repositories\ProductRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;

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
        $result = $this->imageService->upload($data['image']);
        $data['image'] = $result['url'];
        $data['image_public_id'] = $result['public_id'];

        $productData = collect($data)->only(['name','description','task','image','image_public_id','start_date','end_date','user_id'])->toArray();
        $productData['user_id']= $user_id;

        $links = $data['links']; 
        $techIds = Arr::isAssoc($data['techs'])
        ? collect($data['techs'])->pluck('tech_id')->toArray() 
        : $data['techs'];

        $newProduct = $this->ProductRepo->store($productData);

        $newProduct->links()->createMany($links);

        $newProduct->techs()->attach($techIds);

        return $newProduct;
    }

    public function assignTech(string $product_id, array $data){
        $techId =  $data['tech_id'];

        $product = $this->find($product_id);

        $product->techs()->attach($techId);

        return true;
    }

    public function unAssignTech(string $product_id, string $tech_id){
        $product = $this->find($product_id);

        $product->techs()->detach($tech_id);

        return true;
    }

    public function update(array $data, Product $product){
        if (isset($data['image'])){
            $result = $this->imageService->update($product->image_public_id ,$data['image']);

            $data['image'] = $result['url'];
            $data['image_public_id'] = $result['public_id'];
        }

        $updateProduct = $this->ProductRepo->update($product->id, $data);

        return $updateProduct;
    }

    public function destroy(string $id){
        return $this->ProductRepo->destroy($id);
    }
}