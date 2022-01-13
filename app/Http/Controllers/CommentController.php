<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function comment(){

        $datos['comments'] = Comment::paginate(50);
        return view('comment', $datos);
    }

    public function save(Request $request){

        // Validate the request
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);
        //Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asignar valores al objeto comment
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Guardar en la base de datos
        $comment->save();

        //Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])->with(['message' => 'Comentario añadido correctamente']);
    }

    public function delete($id){
        //Conseguir datos del comentario (usuario identficado)
        $user = \Auth::user();

        //Conseguir datos del comentario
        $comment = Comment::find($id);
        
        //Comprobar si soy el dueño del comentario o de la imagen
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            $message = 'Comentario eliminado correctamente';
            return redirect()->route('image.detail', ['id' => $comment->image_id])->with(['message' => $message]);
        }else{
            $message = 'El comentario no se ha eliminado porque no es el usuario o no es su imagen';
            return redirect()->route('image.detail', ['id' => $comment->image_id])->with(['message' => $message]);
        }
    }
}
