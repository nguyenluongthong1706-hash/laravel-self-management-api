<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductLinkService;
use App\Http\Requests\ProductLink\CreateProductLinkRequest;
use App\Http\Requests\ProductLink\UpdateProductLinkRequest;

class ProductLinkController extends Controller
{
    public function __construct(private ProductLinkService $productLinkService){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $product_id, CreateProductLinkRequest $request)
    {

        $productLink = $this->productLinkService->store($product_id, $request->validated());

        return response()->json(['message'=>"Create a product Link successfully", 'data'=>$productLink],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productLink = $this->productLinkService->find($id);

        return response()->json(['message'=>"Get product Link successfully", 'data'=>$productLink],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $product_link_id, UpdateProductLinkRequest $request)
    {
        $productLink = $this->productLinkService->find($product_link_id);
        $data = $request->validated();

        $this->productLinkService->update($product_link_id, $data);

        return response()->json(['message'=>"Update a product Link successfully"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_link_id)
    {
        $this->productLinkService->destroy($product_link_id);

        return response()->json(['message'=>"Delete a product Link successfully"],200);
    }
}
