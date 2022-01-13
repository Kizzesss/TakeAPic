@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('includes.show_message') 
            <div class="card">

                <div class="card-header">Crear Nueva Categoria</div> 

                <div class="card-body">

                    <form method="POST" action="{{ route('category.insertCategory') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-info">
                                    {{ __('Ingresar Categoria') }}
                                </button>
                                <a class="btn btn-outline-danger" href="{{url('/category')}}">Regresar</a>
                            </div>
                        </div>

                    </form>       
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection
