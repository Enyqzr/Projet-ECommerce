<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {

        $categories = CategoryResource::collection(Category::all());

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function show($id)
    {

        $category = new CategoryResource(Category::find($id));

        return response()->json([
            'category' => $category

        ]);
    }

    public function store(CategoryRequest $request)
    {

        $arrayRequest = $request->all();

        $category = new Category();
        $category->name = $arrayRequest['name'];

        $category->save();

        return response()->json([
            'category' => $category
        ]);
    }

    public function update($id, CategoryRequest $request){

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();

        return response()->json([
            'category'=>$category
        ]);
    }
    public function destroy($id){
        $category = Category::find($id);
        $category->delete();

        return response()->json([
            'categories' => $this->index()
        ]);
    }
}
