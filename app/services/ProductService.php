<?php
namespace App\Services;
use App\Repositories\ProductRepository;
use App\Exceptions\BusinessException;
use Illuminate\Support\Arr;

class ProductService {
    public function __construct(private ProductRepository $ProductRepo){}

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
        $productData = collect($data)->only(['name','description','task','image','image_public_id','start_date','end_date','user_id'])->toArray();
        $productData['user_id']= $user_id;

        $urls = $data['urls']; 
        $techIds = Arr::isAssoc($data['techs']) 
        ? collect($data['techs'])->pluck('tech_id')->toArray() 
        : $data['techs'];

        $product = $this->ProductRepo->store($productData);

        $product->urls()->createMany($urls);

        $product->techs()->attach($techIds);

        return $product->load(['urls', 'techs']);
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

    public function update(string $id, array $data){
        $product = $this->ProductRepo->update($id, $data);

        return $product;
    }

    public function destroy(string $id){
        return $this->ProductRepo->destroy($id);
    }
}