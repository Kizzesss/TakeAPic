@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Comunidad</h1>
            <form method="GET" action="{{ route('user.index') }}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Buscar usuarios...">
                    </div>
                    <div class="form-group col">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
                
            </form>

            <hr>
            @foreach ($users as $user)
                @if ($user->role == 'user')
                    <div class="profile-user">
                        @if ($user->image)
                        <div class="container-avatar">
                            <img class="profile_image" src="{{ route('user.image', ['filename'=>$user->image]) }}"/>
                        </div>
                        @endif 

                        <div class="user-info">
                            <div class="profile-data">
                                <h2>{{"@".$user->nick." | ".$user->category->name}}</h2>
                                <h3>{{ $user->name." ".$user->surname }}</h3>
                                <p>{{ 'Se unio hace: '.\FormatTime::LongTimeFilter($user->created_at) }}</p> 
                                <a class="btn btn-sm btn-outline-success" href="{{ route("user.profile",['id' => $user->id]) }}">Visitar perfil</a> 
                            </div> 
                        </div>       
                    </div>
                @endif      
            @endforeach  
            <div class="clearfix">{!! $users->links() !!}</div>
            
        </div>
    </div>
</div>
@endsection
