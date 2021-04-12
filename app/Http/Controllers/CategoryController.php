<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function store(){
        return Category::create($this->validateCategory());
    }

    public function getItemsByCategory(Category $category){
        if(request()->ajax()){
            $view = View::make('item.itemsbycategory', [
                'category' => $category, 
                'items' => $category->items()->where('sold', false)->paginate(10),
                'contentHeader' => "Searching by category: ".$category->name]);
            $sections = $view->renderSections();
            return $sections['content'];
        }
    }

    private function validateCategory(){
        return request()->validate([
            'name' => 'required|string|min:1',
        ]);
    }
}
