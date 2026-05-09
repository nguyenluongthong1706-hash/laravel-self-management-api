<?php
namespace App\Services;
use App\Repositories\TechStackRepository;
use App\Exceptions\BusinessException;

class TechStackService {
    public function __construct(private TechStackRepository $techStackRepo){}

    public function all(){
        return $this->techStackRepo->all();
    }

    public function find(string $id){
        return $this->techStackRepo->find($id);
    }

    public function store( array $data){
        $techStack = $this->techStackRepo->store($data);

        return $techStack;
    }

    public function update(string $id, array $data){
        $techStack = $this->techStackRepo->update($id, $data);

        return $techStack;
    }

    public function destroy(string $id){
        return $this->techStackRepo->destroy($id);
    }
}