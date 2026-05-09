<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WorkExperienceService;
use App\Http\Requests\Work\CreateWorkExperienceRequest;
use App\Http\Requests\Work\UpdateWorkExperienceRequest;

class WorkExperienceController extends Controller
{
    public function __construct(private WorkExperienceService $workExperienceService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workExperience = $this->workExperienceService->all();

        return response()->json(['message'=>"Get work experience list successfully", 'data'=>$workExperience],200);
    }

    public function getByAccount(Request $request)
    {
        $education = $this->workExperienceService->getByAccount($request->user()->id);

        return response()->json(['message'=>"Get work experience list successfully", 'data'=>$education],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWorkExperienceRequest $request)
    {
        $newWorkExperience = $this->workExperienceService->store($request->user()->id, $request->validated());

        return response()->json(['message'=>"Create a work experience successfully", 'data'=>$newWorkExperience],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workExperience = $this->workExperienceService->find($id);

        return response()->json(['message'=>"Get work experience successfully", 'data'=>$workExperience],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $work_experience_id, UpdateWorkExperienceRequest $request)
    {
        $newWorkExperience = $this->workExperienceService->update($work_experience_id, $request->validated());

        return response()->json(['message'=>"Update a work experience successfully", 'data'=>$newWorkExperience],200);
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
