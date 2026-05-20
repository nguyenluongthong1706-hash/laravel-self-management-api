<?php
namespace App\Repositories;

use App\Models\Education;

class EducationRepository extends Repository{
    public function __construct(Education $educationModel){
        $this->model = $educationModel;
    }

    public function getByAccount(string $user_id){
        return $this->model->where('user_id',$user_id)->get();
    }
}