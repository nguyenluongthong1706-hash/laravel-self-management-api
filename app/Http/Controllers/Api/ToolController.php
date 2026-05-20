<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tool\CreateToolRequest;
use App\Http\Requests\Tool\UpdateToolRequest;
use App\Services\ToolService;
use App\Http\Resources\ToolResource;

class ToolController extends Controller
{
    public function __construct(private ToolService $toolService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = $this->toolService->all();

        return response()->json(['message'=>"Get tool list successfully", 'data'=>ToolResource::collection($tools)],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateToolRequest $request)
    {
        $data = $request->validated();

        $newTool = $this->toolService->store($data);

        return response()->json(['message'=>"Create a tool successfully", 'data'=>new ToolResource($newTool)],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tool = $this->toolService->find($id);

        return response()->json(['message'=>"Get tool successfully", 'data'=> new ToolResource($tool)],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolRequest $request, string $id)
    {
        $tool = $this->toolService->find($id);
        $data = $request->validated();

        $updatedTool = $this->toolService->update($data, $tool);

        return response()->json(['message'=>"Update a tool successfully", 'data'=> new ToolResource($updatedTool)],200);
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
