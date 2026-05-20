<?php
namespace App\Services;

use App\Repositories\EducationRepository;
use App\Exceptions\BusinessException;

class EducationService {
    public function __construct(private EducationRepository $educationRepo){}

    public function all(){
        return $this->educationRepo->all();
    }

    public function getByAccount(string $user_id){
        return $this->educationRepo->getByAccount($user_id);
    }

    public function find(string $id){
        return $this->educationRepo->find($id);
    }

    public function store( string $user_id, array $data){
        $data['user_id'] = $user_id;
        
        $newEducation = $this->educationRepo->store($data);

        return $newEducation;
    }

    public function update(string $id, array $data){
        $updatedEducation = $this->educationRepo->update($id, $data);

        return $updatedEducation;
    }

    public function destroy(string $id){
        return $this->educationRepo->destroy($id);
    }
}