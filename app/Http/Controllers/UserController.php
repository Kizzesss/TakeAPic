<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Category;
use App\Models\User;
use App\Models\Image;
use App\Models\Like;
use App\Models\Comment;
use Auth;
use Drupal\Component\Uuid\Com;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($search = null){
        if($search == null){
            $users = User::orderBy('id', 'desc')->paginate(10);
        }else{
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
            ->orWhere('name', 'LIKE', '%'.$search.'%')
            ->orWhere('surname', 'LIKE', '%'.$search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        }
        return view('user.index', compact('users'));
    }

    public function config(){
        $categories = Category::all();
        $user = \Auth::user();
        $selectedCategory = $user->category_id;

        return View('user.config', compact('categories', 'selectedCategory'));
    }

    public function admin(){

        $datos['users'] = User::paginate(10);
        return view('user.admin', $datos);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $images = Image::where('user_id', $id)->get();
        $comments = Comment::where('user_id', $id)->get();
        $likes = Like::where('user_id', $id)->get();

        foreach ($images as $image) {
            $image->delete();
        }
        foreach ($comments as $comment) {
            $comment->delete();
        }
        foreach ($likes as $like) {
            $like->delete();
        }
        $user->delete();
        return redirect('admin')->with(['message'=>'Usuario Baneado']);
    }

    public function update(Request $request){
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;  

        //Validacion
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:20'],
            'surname' => ['required', 'string', 'max:25'],
            'nick' => ['required', 'string', 'max:15', Rule::unique('users','nick')->ignore($id, 'id')],
            
            'email' => ['required', 'string', 'email', 'max:50', Rule::unique('users', 'email')->ignore($id, 'id')],
        ]);

        //Recoger Datos del Form
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $category_id = $request->input('category_id');
        $email = $request->input('email'); 
        
        //Asignar nuevos valores al usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->category_id = $category_id;
        $user->email = $email;
       
        //Subir la imagen
        $image_path = $request->file('image_path');
        
        // Ahora guardamos la nueva imagen
        if($image_path){
            // Borramos la imagen anterior
            // Existe la imagen anterior?
            if(\Auth::user()->image) {
                // Existe, entonces la borramos
                Storage::disk('users')->delete(\Auth::user()->image);
            }
            //Poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();
            //Guardar en carpeta storage
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //Ejecutar consulta y cambios en BD
        $user->update();

        return redirect()->route('config')->with(['message'=>'Usuario actualizado correctamente']);
        
    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $categories = Category::all();
        $selectedCategory = $user->category_id;
        return view('user.edit_user', compact('user', 'categories', 'selectedCategory'));
    }

    public function updateUser(Request $request, $id)
    {
        //Conseguir id usuario
        $user = User::findOrFail($id);
        $id = $user->id;  
 
         //Validacion
        $validate = $this->validate($request, [
             'name' => ['required', 'string', 'max:20'],
             'surname' => ['required', 'string', 'max:25'],
             'nick' => ['required', 'string', 'max:15', Rule::unique('users','nick')->ignore($id, 'id')],
             
             'email' => ['required', 'string', 'email', 'max:50', Rule::unique('users', 'email')->ignore($id, 'id')],
        ]);
 
         //Recoger Datos del Form
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $category_id = $request->input('category_id');
        $email = $request->input('email'); 
         
         //Asignar nuevos valores al usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->category_id = $category_id;
        $user->email = $email;
        
         //Subir la imagen
        $image_path = $request->file('image_path');
         
         // Ahora guardamos la nueva imagen
        if($image_path){
             // Borramos la imagen anterior
             // Existe la imagen anterior?
             if($user->image) {
                 // Existe, entonces la borramos
                 Storage::disk('users')->delete($user->image);
             }
             //Poner nombre unico
             $image_path_name = time().$image_path->getClientOriginalName();
             //Guardar en carpeta storage
             Storage::disk('users')->put($image_path_name, File::get($image_path));
             //Seteo el nombre de la imagen en el objeto
             $user->image = $image_path_name;
        }
 
         //Ejecutar consulta y cambios en BD
        $user->update();
 
        return redirect()->route('admin')->with(['message'=>'Usuario actualizado correctamente']);
    }

    public function createUser()
    {
        $categories = Category::all();
        return view('user.create_user', compact('categories'));
    }

    public function insertUser(Request $request)
    {
        //Validacion
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20'],
            'surname' => ['required', 'string', 'max:25'],
            'nick' => ['required', 'string', 'max:15', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'category_id' => ['required'],
        ]);

        //Recoger datos del formulario
        $rol = 'user';
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        $password = $request->input('password');
        $category_id = $request->input('category_id');

        //Cifrar la contraseña
        $password_crypt = bcrypt($password);

        //Crear el objeto usuario
        $user = new User();
        $user->role = $rol;
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        $user->password = $password_crypt;
        $user->category_id = $category_id;

        $user->save();

        return redirect()->route('admin')->with(['message'=>'Usuario creado correctamente']);
    }
    
    public function profile($id){
        $user = User::findOrFail($id);
        $user_log = \Auth::user();
        $categories = Category::all();
        $selectedCategory = $user->category_id;
        $user_log->last_category_seen = $user->category_id;

        $user_log->update();

        return view('user.profile', compact('user', 'categories', 'selectedCategory'));
    }

}
