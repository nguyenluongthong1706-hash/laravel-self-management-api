<?php
namespace App\Services;
use App\Repositories\LocationRepository;
use App\Exceptions\BusinessException;

class LocationService {
    public function __construct(private LocationRepository $locationRepo){}

    public function all(){
        return $this->locationRepo->all();
    }

    public function find(string $id){
        return $this->locationRepo->find($id);
    }

    public function store( string $user_id, array $data){
        $data['user_id'] = $user_id;
        
        $location = $this->locationRepo->store($data);

        return $location;
    }

    protected function update(string $id, array $data){
        $location = $this->locationRepo->update($id, $data);

        return $location;
    }

    public function updateOrCreate(string $user_id, array $data){
        $location = $this->locationRepo->updateOrCreate($user_id, $data);

        return $location;
    }

    public function destroy(string $id){
        return $this->locationRepo->destroy($id);
    }
}