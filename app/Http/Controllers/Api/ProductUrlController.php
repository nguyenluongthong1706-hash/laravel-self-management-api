<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductUrlService;
use App\Http\Requests\Product_Url\CreateProductUrlRequest;
use App\Http\Requests\Product_Url\UpdateProductUrlRequest;

class ProductUrlController extends Controller
{
    public function __construct(private ProductUrlService $productUrlService){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $product_id, CreateProductUrlRequest $request)
    {

        $productUrl = $this->productUrlService->store($product_id, $request->validated());

        return response()->json(['message'=>"Create a product url successfully", 'data'=>$productUrl],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productUrl = $this->productUrlService->find($id);

        return response()->json(['message'=>"Get product url successfully", 'data'=>$productUrl],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $product_url_id, UpdateProductUrlRequest $request)
    {
        $productUrl = $this->productUrlService->find($product_url_id);
        $data = $request->validated();

        $newProductUrl = $this->productUrlService->update($product_url_id, $data);

        return response()->json(['message'=>"Update a product url successfully", 'data'=>$newProductUrl],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_url_id)
    {
        $this->productUrlService->destroy($product_url_id);

        return response()->json(['message'=>"Delete a product url successfully"],200);
    }
}
