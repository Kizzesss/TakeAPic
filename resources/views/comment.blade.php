@extends('layouts.app')
@section('content')
  
<div class="container table-responsive col-md-8">

    @include('includes.show_message')

    <table class="table table-light table-hover">

    <thead class="thead-dark">
        <tr>
            <th>#</th>          
            <th>Usuario_id</th>
            <th>Image_id</th>
            <th>Contenido</th>
            <th>Creacion</th>
            <th>Modificacion</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($comments as $comment)
                <tr>              
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user_id }}</td>
                    <td>{{ $comment->image_id }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->updated_at }}</td>
                </tr>
        @endforeach
    </tbody>
    
    </table> 
    {!! $comments->links() !!}
</div>
@endsection
