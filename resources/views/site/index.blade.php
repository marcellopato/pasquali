@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar novo site</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="uri" class="form-label">URI</label>
                        <input type="text" class="form-control" id="uri" placeholder="http://www.link.com">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
