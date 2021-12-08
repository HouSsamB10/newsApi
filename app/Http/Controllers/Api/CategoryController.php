<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\PostsResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
       return new CategoriesResource(Category::paginate());
    }

   
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

      public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function posts($id){
       $category = Category::find($id);
       $posts = $category->posts()->paginate();

       return new PostsResource($posts);

    }
}
