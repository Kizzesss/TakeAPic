@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Editar Imagen</div> 

                <div class="card-body">

                    <form method="POST" action="{{ route("image.update") }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="image_id" value="{{$image->id}}">

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class="col-md-7">
                                @if ($image->user->image)
                                    <div class="profile_image_container">
                                        <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}" class="profile_image"/>
                                    </div>
                                @endif
                                <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" value="{{ old('image_path') }}" autocomplete="image_path" autofocus>
                                @error('image_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>        
                        </div> 

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Descripción</label>
                            <div class="col-md-7">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>{{ $image->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>        
                        </div> 

                        <div class="form-group row">
                            <label for="category_id" class="col-md-3 col-form-label text-md-right">{{ __('Categoria') }}</label>

                            <div class="col-md-7">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Escoja la categoria</option>
                                    @foreach ($categories as $category)
{{--                                         <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>{{$category['name']}}</option>
 --}}                                        <option value="{{ $category['id'] }}" {{ ( $category['id'] == $selectedCategory) ? 'selected' : '' }}> {{$category['name']}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Editar Imagen') }}
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
