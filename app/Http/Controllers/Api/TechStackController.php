<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tech;
use App\Http\Requests\Tech\CreateTechStackRequest;
use App\Http\Requests\Tech\UpdateTechStackRequest;
use App\Services\TechStackService;
use App\Http\Resources\TechResource;

class TechStackController extends Controller
{
    public function __construct(private TechStackService $techStackService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Tech::class);

        $techStacks = $this->techStackService->all();

        return response()->json(['message'=>"Get tech list successfully", 'data'=>TechResource::collection($techStacks)],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTechStackRequest $request)
    {
        $this->authorize('create', Tech::class);

        $data = $request->validated();

        $newTechStack = $this->techStackService->store($data);

        return response()->json(['message'=>"Create a tech successfully", 'data'=> new TechResource($newTechStack)],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $techStack = $this->techStackService->find($id);
        $this->authorize('view', $techStack);

        return response()->json(['message'=>"Get tech successfully", 'data'=>new TechResource($techStack)],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechStackRequest $request, string $id)
    {
        $techStack = $this->techStackService->find($id);
        $this->authorize('update', $techStack);

        $data = $request->validated();

        $updatedTechStack = $this->techStackService->update($data, $techStack);

        return response()->json(['message'=>"Update a tech successfully", 'data'=> new TechResource($updatedTechStack)],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $techStack = $this->techStackService->find($id);
        $this->authorize('delete', $techStack);

        $this->techStackService->destroy($id);

        return response()->json(['message'=>"Delete a tech successfully"],200);
    }
}
