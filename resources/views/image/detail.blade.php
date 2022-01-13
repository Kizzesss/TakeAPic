@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.show_message')
                 
            <div class="card pub_image pub_image_detail">
                <div class="card-header">
                    @if ($image->user->image)
                    <div class="profile_image_container">
                        <img class="profile_image" src="{{ route('user.image', ['filename'=>$image->user->image]) }}"/>
                    </div>
                    @endif
                    <div class="data-user">
                        {{ '@'.$image->user->nick.' | '}}
                        <span class="category">
                            {{$image->category->name }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}" class="image_pub"/>
                    </div>
                    
                    <div class="description">
                        <span class="nickname">{{ '@'.$image->user->nick }}</span>
                        <span class="nickname-date"> {{ ' | '.\FormatTime::LongTimeFilter($image->created_at) }} </span>
                        <p>{{ $image->description }}</p>
                    </div>
                    <div class="likes">
                        <!--Comprobar si el usuario le dio like a la imagen-->
                        <?php $user_like = false; ?>
                        @foreach ($image->like as $like)
                            @if ($like->user->id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if ($user_like)
                            <img src="{{ asset('software/heart_red.png') }}" data-id="{{ $image->id }}"" class="btn-dislike"/>  
                        @else
                            <img src="{{ asset('software/heart.png') }}" data-id="{{ $image->id }}" class="btn-like"/>
                        @endif
                       
                    </div>
                    @if (Auth::user() && Auth::user() == $image->user)
                        <div class="actions">
                            <a href="{{ route("image.edit", ['id' => $image->id]) }}" class="btn btn-sm btn-outline-info">Editar</a>
                            <a href="{{ route("image.delete", ['id' => $image->id]) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Quieres eliminar la imagen?')">Borrar</a>
                        </div>   
                    @endif
                    

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comment)}})</h2>
                        <hr> 

                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <textarea class="card form-control @error('content') is-invalid @enderror" name="content" placeholder="Comentar..."></textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="btn btn-outline-info">
                                Publicar
                            </button>
                        </form>

                        <hr>
                        @foreach ($image->comment as $comment)
                            <div class="comments">
                                <span class="nickname">{{ '@'.$comment->user->nick }}</span>
                                <span class="nickname-date"> {{ ' | '.\FormatTime::LongTimeFilter($comment->created_at) }} </span>
                                <p>{{ $comment->content }}
                                @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                    <a href="{{ route('comment.delete', ['id'=>$comment->id]) }}">
                                        <button class="btn btn-sm btn-outline-danger">
                                            Eliminar
                                        </button>
                                    </a>                
                                @endif
                                </p>
                            </div>              
                        @endforeach

                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
@endsection
