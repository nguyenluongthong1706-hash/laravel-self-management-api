<?php
namespace App\Services;

use Illuminate\Support\Arr;
use App\Modals\User;
use App\Repositories\AccountRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;

class AccountService {
    public function __construct(
        private AccountRepository $accountRepo,
        private UploadImageService $imageService
    ){}

    public function find(string $id){
        return $this->accountRepo->find($id);
    }

    public function update(string $id, array $data){
        $userData = collect($data)->except(['location'])->toArray();

        $locationData = $data['location'];

        $updatedUser = $this->accountRepo->update($id, $userData);

        $updatedUser->location()->updateOrCreate(
            ['user_id' => $updatedUser->id],
            $locationData
        );

        return $updatedUser;
    }

    public function uploadAvatar(array $data, User $user){
        $result = $this->imageService->update($user->avatar_public_id, $data['avatar']);

        $updatedUser = $this->accountRepo->update($user()->id, [
            'avatar' => $result['url'],
            'avatar_public_id'=> $result['public_id']
        ]);

        return $updatedUser;
    }

    public function getToolByAccount(string $user_id){
        $user = $this->find($user_id);

        $user = $user->load('tools');

        return $user->tools;
    }

    public function assignTool(string $user_id, array $data){
        $toolId =  $data['tool_id'];

        $user = $this->find($user_id);

        $user->tools()->attach($toolId);

        return true;
    }

    public function assignMultipleTools(string $user_id, array $data){

        $toolIds = collect($data['tools'])->pluck('tool_id')->toArray();

        $user = $this->find($user_id);

        $user->tools()->attach($toolIds);

        $user->load('tools');

        return $user->tools;
    }

    public function unAssignTool(string $user_id, string $tool_id){
        $user = $this->find($user_id);

        $user->tools()->detach($tool_id);

        return true;
    }

    public function getTechByAccount(string $user_id){
        $user = $this->find($user_id);

       $user = $user->load('techs');

        return $user->techs;
    }

    public function assignTech(string $user_id, array $data){
        $techId =  $data['tech_id'];

        $user = $this->find($user_id);

        $user->techs()->attach($techId);

        return true;
    }

    public function assignMultipleTechs(string $user_id, array $data){
        $techIds = collect($data['techs'])->pluck('tech_id')->toArray();

        $user = $this->find($user_id);

        $user->techs()->attach($techIds);

        $user->load('techs');

        return $user->techs;
    }

    public function unAssignTech(string $user_id, string $tech_id){
        $user = $this->find($user_id);

        $user->techs()->detach($tech_id);

        return true;
    }
}