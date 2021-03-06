@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                    <a href="{{ route('site.index') }}" class="btn btn-success float-right">Cadastrar novo site</a>
                    <a class="btn btn-primary float-right" id="reload">Checar sites</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <table class="table border" id="myTable">
                        <thead>
                            <th>URI</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th>Editar</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>    
        $(document).ready( function () {
            $.noConflict();
            var route = '{{ route("get.sites") }}';
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: route,
                columns: [
                    { data: 'uri', 
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href="+oData.uri+" target=\"_blank\">"+oData.uri+"</a>");
                        }                    
                    },
                    { data: 'status_code', 
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            if(oData.status_code == 200) {
                                $(nTd).html("<span class='badge badge-pill badge-success'>ok</span>");
                            }
                            if(oData.status_code != 200) {
                                $(nTd).html("<span class='badge badge-pill badge-warning'>not ok</span>");
                            }
                        }
                    },
                    { data: 'created_at', 
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            moment.locale('pt-br');
                            var data = oData.updated_at;
                            let atualizado = moment(data, 'YYYYMMDD').fromNow();
                                $(nTd).html(atualizado);
                        }
                    },
                    { data: null,
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='/site/"+oData.id+"/edit/'>Editar</a>");
                        }
                    }
                ]
            });
            table
                .order( [ 2, 'desc' ] )
                .draw();
            
            $("#reload").click(function(){
                $.ajax({
                    type: "GET",
                    url: '{{ route("check.sites") }}', 
                    success: function(result){
                        if (result == 1) 
                            console.log('atualizou')
                            table.ajax.reload()
                    }});
            });
            setInterval(function () {
                $('#reload').trigger('click')
            }, 60000);
        });
    </script>
@endsection
