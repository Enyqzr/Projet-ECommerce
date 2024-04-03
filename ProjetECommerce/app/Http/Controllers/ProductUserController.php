<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUserRequest;
use App\Http\Resources\ProductUserResource;
use App\Models\ProductUser;
use App\Models\User;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;

class ProductUserController extends Controller
{
    public function index()
    {

        $comments = ProductUserResource::collection(ProductUser::all());

        return response()->json([
             $comments
        ]);
    }

    public function show($id){
        $comment = new ProductUserResource(ProductUser::find($id));

        return response()->json(
            $comment
        );
    }

    public function store (ProductUserRequest $request){
        $comment = ProductUser::create($request->all());
        $comment = ProductUserResource::make($comment);

        return response()->json([
            'comment' => $comment
        ]);
    }
    public function update($id, ProductUserRequest $request){

        $comment = ProductUser::find($id);
        $comment->update($request->all());
        $comment->save();


        return response()->json(
            $comment
        );
    }

    public function destroy($id) {
        $comment = ProductUser::find($id);
        $comment->delete();

        return response()->json([
            'comments' => $this->index()
            ]);
    }
}
