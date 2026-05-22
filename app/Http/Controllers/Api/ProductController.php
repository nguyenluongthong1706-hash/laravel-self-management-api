<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\AssignTechRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TechResource;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService){}

    /**
     * Display a listing of the resource.
     */
    public function getByAccount(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        
        $products = $this->productService->getByAccount($request->user()->id);

        return response()->json(['message'=>"Get education list successfully", 'data'=>ProductResource::collection($products)],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $data = $request->validated();

        $newProduct = $this->productService->store($request->user()->id, $data);

        return response()->json(['message'=>"Create a product successfully", 'data'=>new ProductResource($newProduct)],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->find($id);
        $this->authorize('view', $product);

        return response()->json(['message'=>"Get product successfully", 'data'=>new ProductResource($product)],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $product_id, UpdateProductRequest $request)
    {
        $product = $this->productService->find($product_id);
        $this->authorize('update', $product);

        $data = $request->validated();

        $updatedProduct = $this->productService->update($data, $product);

        return response()->json(['message'=>"Update a product successfully", 'data'=>new ProductResource($updatedProduct)],200);
    }

    public function assignTechs(string $product_id, AssignTechRequest $request){
        $product = $this->productService->find($product_id);
        $this->authorize('update', $product);
        
        $techs = $this->productService->assignTechs($product_id, $request->validated());

        return response()->json(['message'=>"Assign techs to a product successfully", 'data' => TechResource::collection($techs)],200);
    }

    public function unAssignTech(string $product_id, string $tech_id){
        $product = $this->productService->find($product_id);
        $this->authorize('update', $product);

        $this->productService->unAssignTech($product_id, $tech_id);

        return response()->json(['message'=>"UnAssign a tech to a product successfully"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = $this->productService->find($product_id);
        $this->authorize('delete', $product);

        $this->productService->destroy($product_id);

        return response()->json(['message'=>"Delete a product successfully"],200);
    }
}
