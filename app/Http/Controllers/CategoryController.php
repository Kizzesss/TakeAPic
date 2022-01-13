<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){

        $datos['categories'] = Category::paginate(50);
        return view('category.category', $datos);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $images = Image::where('category_id', $id)->get();
        $users = User::where('category_id', $id)->get();

        foreach ($images as $image) {
            $image->delete();
        }
        foreach ($users as $user) {
            $user->delete();
        }

        $category->delete();
        return back()->with('message', 'Categoria eliminada correctamente');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20'],
        ]);
        $category->name = $request->name;
        $category->save();
        return redirect('category')->with(['message'=>'Categoria actualizada correctamente']);
    }

    public function createCategory()
    {
        return view('category.create_category');
    }

    public function insertCategory(Request $request)
    {
        $category = new Category();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20'],
        ]);
        $category->name = $request->name;
        $category->save();
        return redirect('category')->with(['message'=>'Categoria creada correctamente']);
    }
}
