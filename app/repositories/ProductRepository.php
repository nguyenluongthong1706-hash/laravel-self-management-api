<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends Repository{
    public function __construct(Product $productModel){
        $this->model = $productModel;
    }

    public function getByAccount(string $user_id){
        return $this->model->where('user_id',$user_id)->get();
    }

    public function destroy(string $id){
        $product = $this->model->findOrFail($id);

        $product->techs()->detach();

        $product->links()->delete();

        return $product->delete();
    }
}