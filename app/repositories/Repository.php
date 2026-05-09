<?php
namespace App\Repositories;

abstract class Repository {
    public $model;

    public function all(){
        return $this->model->all();
    }

    public function find(string $id){
        return $this->model->findOrFail($id);
    }

    public function update(string $id, array $data){
        $currentModel = $this->model->findOrFail($id);

        $currentModel->updateOrFail($data);   
        
        return $currentModel;
    }

    public function store(array $data){
        return $this->model->create($data);
    }

    public function destroy(string $id){
        $model = $this->model->findOrFail($id);
        $model->delete();

        return true;
    }
}