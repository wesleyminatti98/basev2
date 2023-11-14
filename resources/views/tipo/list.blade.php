@extends('layouts.app')

@section("title_prefix", 'Tipo - Listagem - ')

@section('load_css')
    <link href="/css/jquery.bootgrid.css" rel="stylesheet" />
    <link href="/css/iziToast.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table id="grid-data" class="table table-striped table-sm">
                <thead>
                <tr>
                    <th data-column-id="id" >Código</th>
                    <th data-column-id="nome" data-order="desc" data-sortable="true">Nome</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Ações</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/jquery.bootgrid.js"></script>
    <script src="/js/jquery.bootgrid.fa.js"></script>
    <script src="/js/iziToast.js"></script>
    <script src="/js/iziToastExcluir.js"></script>

    <script>
        var grid;
        $(document).ready(function(){
            grid = $("#grid-data").bootgrid({
                ajax: true,
                post: function ()
                {
                    return {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };
                },
                url: "/tipo/bootgrid",
                formatters: {
                    "commands": function(column, row)
                    {
                        return "<button type=\"button\" class=\"btn btn-primary command-edit\" data-row-id=\"" + row.id   + "\"><span class=\"fas fa-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-danger command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function()
            {
                grid.find(".command-edit").on("click", function(e)
                {
                    document.location = '/tipo/' + $(this).data("row-id") + '/edit';
                }).end().find(".command-delete").on("click", function(e)
                {
                    iziToastExcluir($(this).data("row-id"));
                });
            });
        });


        function excluir(id){
            $.ajax({
                    url: "/tipo/" + id,
                    type: 'DELETE',
                    data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                    success: function () {
                        iziToast.success({
                            message: 'Cadastro excluído com sucesso!'
                        });
                        grid.bootgrid("reload")
                    },
                    error: function (data) {
                        var erro = JSON.parse(JSON.stringify(data));
                        iziToast.error({
                            message: erro.responseText
                        });
                    },
                    datatype: "json"
                }
            );
        }
    </script>

@endsection
