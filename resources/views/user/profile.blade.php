@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="profile-user">
                @if ($user->image)
                <div class="container-avatar">
                    <img class="profile_image" src="{{ route('user.image', ['filename'=>$user->image]) }}"/>
                </div>
                @endif 

                <div class="user-info">
                    <div class="profile-data">
                        <h1>{{"@".$user->nick." | ".$user->category->name}}</h1>
                        <h2>{{$user->name." ".$user->surname}}</h2>
                        <p>{{ 'Se unio hace: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>  
                    </div> 
                </div>       
            </div>
            <div class="clearfix"></div>
            @foreach ($user->images as $image)
                @include('includes.image_profile', ['image' => $image])      
            @endforeach   
            
        </div>
    </div>
</div>
@endsection
