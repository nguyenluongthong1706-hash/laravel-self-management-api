<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tool\CreateToolRequest;
use App\Http\Requests\Tool\UpdateToolRequest;
use App\Services\ToolService;
use App\Services\Image\UploadImageService;


class ToolController extends Controller
{
    public function __construct(private ToolService $toolService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tool = $this->toolService->all();

        return response()->json(['message'=>"Get tool list successfully", 'data'=>$tool],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateToolRequest $request, UploadImageService $imageService)
    {
        $data = $request->validated();

        $result = $imageService->upload($request->file('icon'));

        $data['icon'] = $result['url'];
        $data['icon_public_id'] = $result['public_id'];

        $newTool = $this->toolService->store($data);

        return response()->json(['message'=>"Create a tool successfully", 'data'=>$newTool],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tool = $this->toolService->find($id);

        return response()->json(['message'=>"Get tool successfully", 'data'=>$tool],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolRequest $request, string $id, UploadImageService $imageService)
    {
        $tool = $this->toolService->find($id);
        $data = $request->validated();

        if ($request->hasFile('image')){
            $result = $imageService->update($tool->logo_public_id ,$request->file('icon'));

            $data['icon'] = $result['url'];
            $data['logo_public_id'] = $result['public_id'];
        }

        $newTool = $this->toolService->update($id, $data);

        return response()->json(['message'=>"Update a tool successfully", 'data'=>$newTool],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->toolService->destroy($id);

        return response()->json(['message'=>"Delete a tool successfully"],200);
    }
}
