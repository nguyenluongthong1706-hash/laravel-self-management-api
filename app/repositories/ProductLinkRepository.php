<?php
namespace App\Repositories;

use App\Models\ProductLink;

class ProductLinkRepository extends Repository{
    public function __construct(ProductLink $productLinkModel){
        $this->model = $productLinkModel;
    }
}