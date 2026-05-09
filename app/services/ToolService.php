<?php
namespace App\Services;
use App\Repositories\ToolRepository;
use App\Exceptions\BusinessException;

class ToolService {
    public function __construct(private ToolRepository $toolRepo){}

    public function all(){
        return $this->toolRepo->all();
    }

    public function find(string $id){
        return $this->toolRepo->find($id);
    }

    public function store( array $data){
        $tool = $this->toolRepo->store($data);

        return $tool;
    }

    public function update(string $id, array $data){
        $tool = $this->toolRepo->update($id, $data);

        return $tool;
    }

    public function destroy(string $id){
        return $this->toolRepo->destroy($id);
    }
}