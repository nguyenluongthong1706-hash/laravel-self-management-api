<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Account\AssignToolRequest;
use App\Http\Requests\Account\AssignMultipleToolRequest;
use App\Http\Requests\Account\AssignMultipleTechRequest;
use App\Http\Requests\Account\AssignTechRequest;
use App\Http\Requests\Account\UploadAvatarRequest;
use App\Services\AccountService;
use App\Services\LocationService;
use App\Http\Resources\UserResource;
use App\Http\Resources\ToolResource;
use App\Http\Resources\TechResource;

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

        return response()->json(['message'=>"Get profile successfully", 'data'=> new UserResource(auth('api')->user())],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, LocationService $locationService)
    {
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $user = $this->accountService->update($request->user()->id, $request->validated());

        return response()->json(['message'=>"Update profile successfully", 'data'=> new UserResource($user)],200);
    }

    public function uploadAvatar(UploadAvatarRequest $request){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $updatedUser = $this->accountService->uploadAvatar($request->validated(), $user);

        return response()->json(['message'=>"Upload Avatar successfully", 'data'=>new UserResource($updatedUser)],200);
    }

    public function getToolByAccount(Request $request){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('view', $user);

        $tools = $this->accountService->getToolByAccount($request->user()->id);

        return response()->json(['message'=>"Get current user's tool list successfully", 'data'=>ToolResource::collection($tools)],200);
    }

    public function assignMultipleTools(AssignMultipleToolRequest $request){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $tools = $this->accountService->assignMultipleTools($request->user()->id, $request->validated());
        return response()->json(['message'=>"Assign tools to a user successfully", 'data'=> ToolResource::collection($tools)],200);
    }

    public function unAssignTool(Request $request, string $tool_id){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $this->accountService->unAssignTool($request->user()->id, $tool_id);

        return response()->json(['message'=>"Unassign a tool to a user successfully"],200);
    }

    public function getTechByAccount(Request $request){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('view', $user);

        $techs = $this->accountService->getTechByAccount($request->user()->id);

        return response()->json(['message'=>"Get current user's tech list successfully", 'data'=> TechResource::collection($techs)],200);
    }

    public function assignMultipleTechs(AssignMultipleTechRequest $request){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $techs = $this->accountService->assignMultipleTechs($request->user()->id, $request->validated());

        return response()->json(['message'=>"Assign techs to a user successfully", 'data' => TechResource::collection($techs)],200);
    }

    public function unAssignTech(Request $request, string $tech_id){
        $user = $this->accountService->find($request->user()->id);
        $this->authorize('update', $user);

        $this->accountService->unAssignTech($request->user()->id, $tech_id);

        return response()->json(['message'=>"Unassign a tech to a user successfully"],200);
    }
}
