<?php
namespace App\Repositories;

use App\Models\Tech;

class TechStackRepository extends Repository{
    public function __construct(Tech $TechModel){
        $this->model = $TechModel;
    }
}