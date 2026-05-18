<?php
namespace App\Services;
use App\Repositories\AccountRepository;
use App\Exceptions\BusinessException;
use Illuminate\Support\Arr;

class AccountService {
    public function __construct(private AccountRepository $accountRepo){}

    public function find(string $id){
        return $this->accountRepo->find($id);
    }

    public function update(string $id, array $data){
        $userData = collect($data)->only(['name', 'date_of_birth', 'gender', 'field','slogan','about_me','facebook_link','linkedin_link','github_link'])->toArray();

        $locationData = collect($data)->only(['level1','level2','level3','detail'])->toArray();

        $user = $this->accountRepo->update($id, $data);

        $user->location()->updateOrCreate(
            ['user_id' => $user->id],
            $locationData
        );

        return $user->load('location');
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
        info($data);

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