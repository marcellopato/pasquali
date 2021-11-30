@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar novo site</div>
                <div class="card-body">
                    <form action="{{ route('site.store') }}" method="post">
                        @method('POST')
                        @csrf
                        @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="uri" class="form-label">URI (http://www.url.com)</label>
                            <input type="text" class="form-control" id="uri" name="uri" value="{{ old('uri') }}">
                                @error('uri')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
