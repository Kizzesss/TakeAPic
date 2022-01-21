<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        $categories = Category::all();
        $image = new Image();
        $selectedCategory = $image->category_id;

        return view('image.create', compact('categories', 'selectedCategory'));
    }

    public function save(Request $request){
        //Validaciones
        $validate = $this->validate($request, [
            'image_path' => 'required|image',
            'category_id' => 'required',
        ]);

        //Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        $category_id = $request->input('category_id');
        
        //Asignar valores al objeto image
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $description;
        $image->category_id = $category_id;

        //Subir imagen
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //Guardar en la base de datos
        $image->save();
        /*$url = "http://localhost:5000/images";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data = <<<DATA
            {
                "description":{
                    "user_id": $user->id,
                    "category_id": $category_id,
                    "image_path": "$image_path_name",
                    "description": "$description"
                }
            }
            DATA;

            \Log::error($data);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 

            $resp = curl_exec($curl);
            curl_close($curl);
            var_dump($resp);*/

        return redirect()->route('home')->with(['message' => "Imagen subida correctamente" ]);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();
        return view('image.detail', ['image'=>$image, 'comments'=>$comments, 'likes'=>$likes]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            //Borrar imagen
            Storage::disk('images')->delete($image->image_path);
            //Borrar comentarios
            foreach($comments as $comment){
                $comment->delete();
            }
            //Borrar likes
            foreach($likes as $like){
                $like->delete();
            }
            //Borrar imagen
            //$image->delete();
            $url = "http://localhost:5000/images/".$image->id;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $resp = curl_exec($curl);
            curl_close($curl);
            var_dump($resp);

            $message = array('message' => 'Imagen eliminada correctamente');
        }else{
            $message = array('message' => 'La imagen no se ha eliminado');
        }
        return redirect()->route('home')->with($message);
    }  
    
    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $categories = Category::all();
        $selectedCategory = $image->category_id;

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', ['image'=>$image, 'categories'=>$categories, 'selectedCategory'=>$selectedCategory]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        //Validaciones
        $validate = $this->validate($request, [
            'image_path' => 'image',
            'category_id' => 'required',
        ]);

        //Recoger datos
        $image_path = $request->file('image_path');
        $image_id = $request->input('image_id');
        $description = $request->input('description');
        $category_id = $request->input('category_id');

        //Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;
        $image->category_id = $category_id;

        //Subir imagen
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        };

        //Actualizar imagen
        //$image->update();
        $url = "http://localhost:5000/images/".$image->id;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data = <<<DATA
            {
                "description":{
                    "category_id": $category_id,
                    "image_path": "$image_path_name",
                    "description": "$description"
                }
            }
            DATA;

            \Log::error($data);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 

            $resp = curl_exec($curl);
            curl_close($curl);
            var_dump($resp);

        return redirect()->route('image.detail', ['id'=>$image_id])->with(['message'=>'Imagen actualizada correctamente']);
    }
}
