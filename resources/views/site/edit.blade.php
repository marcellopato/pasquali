@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar novo site</div>
                <div class="card-body">
                    <form action="{{ action('\App\Http\Controllers\SiteController@update', $site->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="uri" class="form-label">URI (http://www.url.com)</label>
                            <input type="text" class="form-control" id="uri" name="uri" value="{{ $site->uri }}">
                                @error('uri')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Editar</button>
                            <form action="{{ action('\App\Http\Controllers\SiteController@destroy', $site->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Apagar</button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
