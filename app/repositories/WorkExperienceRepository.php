<?php
namespace App\Repositories;
use App\Models\WorkExperience;

class WorkExperienceRepository extends Repository{
    public function __construct(WorkExperience $workExperienceModel){
        $this->model = $workExperienceModel;
    }

    public function getByAccount(string $user_id){
        return $this->model->where('user_id',$user_id)->get();
    }
}