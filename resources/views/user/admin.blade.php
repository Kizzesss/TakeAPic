@extends('layouts.app')
@section('content')
  
<div class="container table-responsive">

    @include('includes.show_message')

    <a href="{{url('/user/create_user')}}" class="btn btn-outline-success">Registrar Nuevo Usuario</a>
    <br/>
    <br/>

    <table class="table table-light table-hover">

    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Rol</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Apodo</th>
            <th>Correo</th>
            <th>Accion</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            @if ($user->role == 'user')
                <tr>              
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->nick }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{url('/user/'.$user->id.'/edit_user')}}" class="btn btn-outline-info">
                            Editar
                        </a>

                        <form action="{{url('/user/'.$user->id)}}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input class="btn btn-outline-danger" type="submit" onclick="return confirm('Quieres banear al usuario?')" 
                        value="Banear">
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
    
    </table> 
    <div class="clearfix">{!! $users->links() !!}</div>
</div>
@endsection
