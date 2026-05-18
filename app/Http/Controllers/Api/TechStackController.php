<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TechStackService;
use App\Http\Requests\Tech\CreateTechStackRequest;
use App\Http\Requests\Tech\UpdateTechStackRequest;
use App\Services\Image\UploadImageService;

class TechStackController extends Controller
{
    public function __construct(private TechStackService $techStackService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $techStack = $this->techStackService->all();

        return response()->json(['message'=>"Get tech list successfully", 'data'=>$techStack],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTechStackRequest $request, UploadImageService $imageService)
    {
        $data = $request->validated();

        $result = $imageService->upload($request->file('icon'));

        $data['icon'] = $result['url'];
        $data['logo_public_id'] = $result['public_id'];

        $newTechStack = $this->techStackService->store($data);

        return response()->json(['message'=>"Create a tech successfully", 'data'=>$newTechStack],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $techStack = $this->techStackService->find($id);

        return response()->json(['message'=>"Get tech successfully", 'data'=>$techStack],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechStackRequest $request, string $id, UploadImageService $imageService)
    {
        $techStack = $this->techStackService->find($id);
        $data = $request->validated();

        if ($request->hasFile('icon')){
            $result = $imageService->update($techStack->logo_public_id ,$request->file('icon'));

            $data['icon'] = $result['url'];
            $data['logo_public_id'] = $result['public_id'];
        }

        $newTechStack = $this->techStackService->update($id, $data);

        return response()->json(['message'=>"Update a tech successfully", 'data'=>$newTechStack],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->techStackService->destroy($id);

        return response()->json(['message'=>"Delete a tech successfully"],200);
    }
}
