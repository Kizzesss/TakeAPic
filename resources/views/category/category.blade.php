@extends('layouts.app')
@section('content')
  
<div class="container table-responsive col-md-6">

    @include('includes.show_message')

    <a href="{{url('/category/create_category')}}" class="btn btn-outline-success">Registrar Nueva Categoria</a>
    <br/>
    <br/>

    <table class="table table-light table-hover">

    <thead class="thead-dark">
        <tr>
            <th>#</th>          
            <th>Nombre</th>
            <th>Accion</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
                <tr>              
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="col-md-4">
                        <a href="{{url('/category/'.$category->id.'/edit_category')}}" class="btn btn-outline-info">
                            Editar
                        </a>

                        <form action="{{url('/category/'.$category->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input class="btn btn-outline-danger" type="submit" onclick="return confirm('Quieres eliminar la categoria?')" 
                        value="Eliminar">
                        </form>
                    </td>
                </tr>
        @endforeach
    </tbody>
    
    </table> 
    {!! $categories->links() !!}
</div>
@endsection
