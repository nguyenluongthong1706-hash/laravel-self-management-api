<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Account\UploadAvatarRequest;
use App\Http\Requests\Account\AssignToolRequest;
use App\Http\Requests\Account\AssignTechRequest;
use App\Services\AccountService;
use App\Services\LocationService;
use App\Service\UploadImageService;

class AccountController extends Controller
{
    public function __construct(private AccountService $accountService){}

    /**
     * Display the specified resource.
     */
    public function me(Request $request)
    {
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('view', $user);

        return response()->json(['message'=>"Get profile successfully", 'data'=>auth('api')->user()],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, LocationService $locationService)
    {
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $user = $this->accountService->update($request->user()->id, $request->validated());

        return response()->json(['message'=>"Update profile successfully", 'data'=>$user],200);
    }

    public function uploadAvatar(UploadAvatarRequest $request, UploadImageService $imageService){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $result = $imageService->update($user->avatar_public_id, $request->file('avatar'));

        $user = $this->accountService->update($request->user()->id, [
            'avatar' => $result['url'],
            'avatar_public_id'=> $result['public_id']
        ]);

        return response()->json(['message'=>"Upload Avatar successfully", 'data'=>$user],200);
    }

    public function assignTool(AssignToolRequest $request){
        $this->accountService->assignTool($request->user()->id, $request->validated());

        return response()->json(['message'=>"Assign a tool to a user successfully"],200);
    }

    public function unAssignTool(string $tool_id){
        $this->accountService->unAssignTool($request->user()->id, $tool_id);

        return response()->json(['message'=>"Unassign a tool to a user successfully"],200);
    }

    public function assignTech(AssignTechRequest $request){
        $this->accountService->assignTech($request->user()->id, $request->validated());

        return response()->json(['message'=>"Assign a tech to a user successfully"],200);
    }

    public function unAssignTech(string $tech_id){
        $this->accountService->unAssignTech($request->user()->id, $tech_id);

        return response()->json(['message'=>"Unassign a tech to a user successfully"],200);
    }
}
