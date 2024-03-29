<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(): JsonResponse
    {
        $products = ProductResource::collection(Product::all());
        return response()->json([
            'products' => $products
        ]);
    }
    public function store(ProductRequest $request): JsonResponse
    {
        $categoryName = $request->input('category');
        $category = Category::where('name', $categoryName)->first();

        $product = new Product;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category()->associate($category);
        $product->save();

        return response()->json([
            'product' => $product
        ]);
    }

    public function show($id){
        $product = new ProductResource(Product::find($id));

        return response()->json([
            "product" => $product
        ]);
    }

    public function update($id, ProductRequest $request): JsonResponse
    {

        $product = Product::find($id);
        $categoryName = $request->input('category');
        $category = Category::where('name', $categoryName)->first();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category()->associate($category);
        $product->save();

        return response()->json([
            'product' => $product
        ]);
    }

    public function destroy($id){

        $product = Product::find($id);
        $product->delete();
        $products = ProductResource::collection(Product::all());

        return response()->json([
            'products'=>$products
        ]);
    }
}
