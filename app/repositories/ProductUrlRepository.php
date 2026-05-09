<?php
namespace App\Repositories;
use App\Models\ProductUrl;

class ProductUrlRepository extends Repository{
    public function __construct(ProductUrl $productUrlModel){
        $this->model = $productUrlModel;
    }
}