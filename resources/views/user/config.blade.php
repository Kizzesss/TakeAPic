@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.show_message')           
            <div class="card">
                <div class="card-header">Configuración de mi Cuenta</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" required autocomplete="surname" autofocus>

                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nick" class="col-md-4 col-form-label text-md-right">{{ __('Apodo') }}</label>

                            <div class="col-md-6">
                                <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror" name="nick" value="{{ Auth::user()->nick }}" required autocomplete="nick" autofocus>

                                @error('nick')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(Auth::user()->role == 'user' )
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>

                            <div class="col-md-6">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Escoja la categoria</option>
                                    @foreach ($categories as $category)
{{--                                         <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>{{$category['name']}}</option>
 --}}                                        <option value="{{ $category['id'] }}" {{ ( $category['id'] == $selectedCategory) ? 'selected' : '' }}> {{$category['name']}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   

                        <div class="form-group row">
                            <label for="image_path" class="col-md-4 col-form-label text-md-right">{{ __('Imagen de Perfil') }}</label>

                            <div class="col-md-6">

                                @include('includes.profile_image')

                                <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" autocomplete="image_path">

                                @error('image_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
