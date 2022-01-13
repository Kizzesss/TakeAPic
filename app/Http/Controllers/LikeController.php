<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Image;
use DateTime;
use Hamcrest\Core\HasToString;
use SebastianBergmann\Environment\Console;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($image_id)
    {
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();

        //Condicion para ver si ya existe el like
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();
        if($isset_like == 0){
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //$like->save();
            $url = "http://localhost:5000/likes";

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
                    "image_id": $image_id,
                    "created_at":null,
                    "updated_at":null
                }
            }
            DATA;

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 

            $resp = curl_exec($curl);
            curl_close($curl);
            var_dump($resp);

            return response()->json([
                'like' => $like,
                'message' => 'Has dado LIKE correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id)
    {
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();

        //Condicion para ver si ya existe el like
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();
        if($like){
            //Eliminar like
            //$like->delete();
            $url = "http://localhost:5000/likes/".$like->id;

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


            return response()->json([
                'like' => $like,
                'message' => 'Has dado DISLIKE correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }
}