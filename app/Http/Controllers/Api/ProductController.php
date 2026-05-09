<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\AssignTechRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use App\Services\Image\UploadImageService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = $this->productService->all();

        return response()->json(['message'=>"Get product list successfully", 'data'=>$product],200);
    }

    public function getByAccount(Request $request)
    {
        $education = $this->productService->getByAccount($request->user()->id);

        return response()->json(['message'=>"Get education list successfully", 'data'=>$education],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request, UploadImageService $imageService)
    {
        $data = $request->validated();

        $result = $imageService->upload($request->file('image'));

        $data['image'] = $result['url'];
        $data['image_public_id'] = $result['public_id'];

        $newProduct = $this->productService->store($request->user()->id, $data);

        return response()->json(['message'=>"Create a product successfully", 'data'=>$newProduct],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->find($id);

        return response()->json(['message'=>"Get product successfully", 'data'=>$product],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $product_id, UpdateProductRequest $request, UploadImageService $imageService)
    {
        $product = $this->productService->find($product_id);
        $data = $request->validated();

        if ($request->hasFile('image')){
            $result = $imageService->update($product->image_public_id ,$request->file('image'));

            $data['image'] = $result['url'];
            $data['image_public_id'] = $result['public_id'];
        }

        $newProduct = $this->productService->update($product_id, $data);

        return response()->json(['message'=>"Update a product successfully", 'data'=>$newProduct],200);
    }

    public function assignTech(string $product_id, AssignTechRequest $request){
        $this->productService->assignTech($product_id, $request->validated());

        return response()->json(['message'=>"Assign a tech to a product successfully"],200);
    }

    public function unAssignTech(string $product_id, string $tech_id){
        $this->productService->unAssignTech($product_id, $tech_id);

        return response()->json(['message'=>"UnAssign a tech to a product successfully"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $this->productService->destroy($product_id);

        return response()->json(['message'=>"Delete a product successfully"],200);
    }
}
