<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // Folosim modeul Category
use App\Http\Requests\AddCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function showCategories() {
        $categories = Category::all()->sortBy('title')->sortBy('position');
        return view('admin.categories.categories')->with('categories', $categories);
    }
    
    public function newCategoryForm() {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            // abort(403); //Nu vrem să ne afișeze o pagină cu o eroare 403.
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }
        return view('admin.categories.new-category-form');
    }

    public function createNewCategory(AddCategoryRequest $request) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }

        $this->validate(
            $request, 
            [
                'slug' => 'unique:categories,slug'
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],
        );
        $category = new Category;

        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;
        $category->position = $request->position;
        $category->published = $request->published;

        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('images/categories', $photoName);

            $category->image = $photoName;
        }

        $confirmationAddMessage = "Categoria " . '<strong>' . $request->title . '</strong>' . " a fost adăugată cu succes!";
        
        $category->save();
        
        return redirect(route('admin.categories'))->with('success', $confirmationAddMessage);
    }

    public function editCategoryForm($categoryId) {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit-category-form')->with('category', $category);
    }

    public function updateCategory(AddCategoryRequest $request, $categoryId) {
        $this->validate(
            $request, 
            [
                'slug' => 'unique:categories,slug,' . $categoryId
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],
        );

        $category = Category::findOrFail($categoryId);

        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;
        $category->position = $request->position;
        $category->published = $request->published;

        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            if ($category->image != 'category.png') {
                File::delete('images/categories/' . $category->image);
            }
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('images/categories', $photoName);

            $category->image = $photoName;
        }

        $confirmationUpdateMessage = "Categoria " . '<strong>' . $request->title . '</strong>' . " a fost actualizată cu succes!";
        
        $category->save();
        
        return redirect(route('admin.categories'))->with('success', $confirmationUpdateMessage);
    }

    public function deleteCategory($categoryId) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }
        $category = Category::findOrFail($categoryId);
        if ($category->image != 'category.png') {
            File::delete('images/categories/' . $category->image);
        }
        $category->posts()->detach(); //Aceasta este linia de cod necesară detașării postărilor.
        $category->delete();
        return redirect(route('admin.categories'))->with('success', 'Categoria ' . '<strong>' . $category->title . '</strong>' . ' a fost stearsă definitiv din baza de date!');
    }
}
