<?php
namespace App\Services;

use Illuminate\Support\Arr;
use App\Models\User;
use App\Repositories\AccountRepository;
use App\Services\Image\UploadImageService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;

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

        $updatedUser = DB::transaction(function() use ($id, $userData, $locationData){
            $updatedUser = $this->accountRepo->update($id, $userData);

            $updatedUser->location()->updateOrCreate(
                ['user_id' => $updatedUser->id],
                $locationData
            );

            return $updatedUser;
        });    

        return $updatedUser;
    }

    public function uploadAvatar(array $data, User $user){
        $result = null;

        try{
            $result = $this->imageService->update($user->avatar_public_id, $data['avatar']);

            DB::beginTransaction();

            $updatedUser = $this->accountRepo->update($user->id, [
                'avatar' => $result['url'],
                'avatar_public_id'=> $result['public_id']
            ]);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();

            if($result){
                $this->imageService->delete($result['public_id']);
            }
            throw $e;
        }

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

        return DB::transaction(function () use ($toolIds, $user) {
            $existingToolIds = $user->tools()
                ->whereIn('tools.id', $toolIds)
                ->pluck('tools.id')
                ->toArray();

            if (!empty($existingToolIds)) {
                throw new BusinessException('Some tools already exist in user profile', 409);
            }

            $user->tools()->attach($toolIds);

            $user->load('tools');

            return $user->tools;
        });
    }

    public function unAssignTool(string $user_id, string $tool_id){
        $user = $this->find($user_id);

        if (!$user->tools()->where('tools.id', $tool_id)->exists()) {
            throw new BusinessException('This tool does not exist in user profile', 404);
        }

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

        return DB::transaction(function () use ( $techIds, $user) {
            $existingTechIds = $user->techs()
                ->whereIn('techs.id', $techIds)
                ->pluck('techs.id')
                ->toArray();

            if (!empty($existingTechIds)) {
                throw new BusinessException('Some techs already exist in user profile', 409);
            }

            $user->techs()->attach($techIds);

            $user->load('techs');

            return $user->techs;
        });
    }

    public function unAssignTech(string $user_id, string $tech_id){
        $user = $this->find($user_id);

        if (!$user->techs()->where('techs.id', $tech_id)->exists()) {
            throw new BusinessException('This tech does not exist in user profile', 404);
        }

        $user->techs()->detach($tech_id);

        return true;
    }
}
