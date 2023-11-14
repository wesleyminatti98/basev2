@extends('layouts.app')

@section("title_prefix", 'Tipo - Cadastrar - ')

@section('load_css')
    <link href="/css/iziToast.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('tipo.store')  }}" method="post" class="jsonForm">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Tipo">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/iziToast.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script>
        $(document).ready(function(){
            $('.jsonForm').ajaxForm({
                dataType:  'json',

                success:   function(d){
                    if (d.status==0){
                        iziToast.error({
                            message: d.message
                        });
                    }else{
                        iziToast.success({
                            message: d.message
                        });
                        $('.jsonForm').trigger("reset");
                    }
                },
                error: function(response){
                    d = response.responseJSON;

                    let mensagem='';
                    $.each(d.errors, function(campo, erros){
                        $.each(erros, function(key, erro){
                            mensagem += erro + '<br>';
                        })

                    });

                    iziToast.error({
                        message: mensagem
                    });
                }

            });
        });
    </script>


@endsection
