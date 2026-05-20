<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Work\CreateWorkExperienceRequest;
use App\Http\Requests\Work\UpdateWorkExperienceRequest;
use App\Services\WorkExperienceService;
use App\Http\Resources\WorkExperienceResource;

class WorkExperienceController extends Controller
{
    public function __construct(private WorkExperienceService $workExperienceService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workExperiences = $this->workExperienceService->all();

        return response()->json(['message'=>"Get work experience list successfully", 'data'=>WorkExperienceResource::collection($workExperiences)],200);
    }

    public function getByAccount(Request $request)
    {
        $workExperiences = $this->workExperienceService->getByAccount($request->user()->id);

        return response()->json(['message'=>"Get work experience list successfully", 'data'=>WorkExperienceResource::collection($workExperiences)],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWorkExperienceRequest $request)
    {
        $newWorkExperience = $this->workExperienceService->store($request->user()->id, $request->validated());

        return response()->json(['message'=>"Create a work experience successfully", 'data'=> new WorkExperienceResource($newWorkExperience)],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workExperience = $this->workExperienceService->find($id);

        return response()->json(['message'=>"Get work experience successfully", 'data'=>new WorkExperienceResource($workExperience)],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $work_experience_id, UpdateWorkExperienceRequest $request)
    {
        $updatedWorkExperience = $this->workExperienceService->update($work_experience_id, $request->validated());

        return response()->json(['message'=>"Update a work experience successfully", 'data'=>new WorkExperienceResource($updatedWorkExperience)],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $work_experience_id)
    {
        $this->workExperienceService->destroy($work_experience_id);

        return response()->json(['message'=>"Delete a work experience successfully"],200);
    }
}
