<?php
namespace App\Repositories;
use App\Models\Tool;

class ToolRepository extends Repository{
    public function __construct(Tool $toolModel){
        $this->model = $toolModel;
    }
}