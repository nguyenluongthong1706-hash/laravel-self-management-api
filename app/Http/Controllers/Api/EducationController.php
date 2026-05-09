<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EducationService;
use App\Http\Requests\Education\CreateEducationRequest;
use App\Http\Requests\Education\UpdateEducationRequest;

class EducationController extends Controller
{
    public function __construct(private EducationService $educationService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = $this->educationService->all();

        return response()->json(['message'=>"Get education list successfully", 'data'=>$education],200);
    }

    public function getByAccount(Request $request)
    {
        $education = $this->educationService->getByAccount($request->user()->id);

        return response()->json(['message'=>"Get education list successfully", 'data'=>$education],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEducationRequest $request)
    {
        $newEducation = $this->educationService->store($request->user()->id, $request->validated());

        return response()->json(['message'=>"Create a education successfully", 'data'=>$newEducation],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $education = $this->educationService->find($id);

        return response()->json(['message'=>"Get education successfully", 'data'=>$education],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $education_id, UpdateEducationRequest $request)
    {
        $newEducation = $this->educationService->update($education_id, $request->validated());

        return response()->json(['message'=>"Update a education successfully", 'data'=>$newEducation],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $education_id)
    {
        $this->educationService->destroy($education_id);

        return response()->json(['message'=>"Delete a education successfully"],200);
    }
}
