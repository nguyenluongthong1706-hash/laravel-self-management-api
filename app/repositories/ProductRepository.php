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
}