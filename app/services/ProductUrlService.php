<?php
namespace App\Services;
use App\Repositories\ProductUrlRepository;
use App\Exceptions\BusinessException;

class ProductUrlService {
    public function __construct(private ProductUrlRepository $productUrlRepo){}

    public function find(string $id){
        return $this->productUrlRepo->find($id);
    }

    public function store( string $product_id, array $data){
        $data['product_id'] = $product_id;

        $productUrl = $this->productUrlRepo->store($data);

        return $productUrl;
    }

    public function update(string $id, array $data){

        $productUrl = $this->productUrlRepo->update($id, $data);

        return $productUrl;
    }

    public function destroy(string $id){
        return $this->productUrlRepo->destroy($id);
    }
}