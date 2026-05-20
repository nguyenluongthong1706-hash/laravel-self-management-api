<?php
namespace App\Services;

use App\Repositories\ProductLinkRepository;
use App\Exceptions\BusinessException;

class ProductLinkService {
    public function __construct(private ProductLinkRepository $productLinkRepo){}

    public function find(string $id){
        return $this->productLinkRepo->find($id);
    }

    public function store( string $product_id, array $data){
        $data['product_id'] = $product_id;

        $newProductLink = $this->productLinkRepo->store($data);

        return $newProductLink;
    }

    public function update(string $id, array $data){

        $updateProductLink = $this->productLinkRepo->update($id, $data);

        return $updateProductLink;
    }

    public function destroy(string $id){
        return $this->productLinkRepo->destroy($id);
    }
}