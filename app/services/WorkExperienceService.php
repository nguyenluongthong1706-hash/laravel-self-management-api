<?php
namespace App\Services;

use App\Repositories\WorkExperienceRepository;
use App\Exceptions\BusinessException;

class WorkExperienceService {
    public function __construct(private WorkExperienceRepository $workExperienceRepo){}

    public function all(){
        return $this->workExperienceRepo->all();
    }

    public function getByAccount(string $user_id){
        return $this->workExperienceRepo->getByAccount($user_id);
    }

    public function find(string $id){
        return $this->workExperienceRepo->find($id);
    }

    public function store( string $user_id,  array $data){
        $data['user_id'] = $user_id;
        
        $newWorkExperience = $this->workExperienceRepo->store($data);

        return $newWorkExperience;
    }

    public function update(string $id, array $data){
        $updatedWorkExperience = $this->workExperienceRepo->update($id, $data);

        return $updatedWorkExperience;
    }

    public function destroy(string $id){
        return $this->workExperienceRepo->destroy($id);
    }
}