@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('partials.feedback')
            <div class="text-center">
                <h1>Criar novo cliente</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 ml-auto mr-auto">
            <div class="card">
                <div class="card-header">
                    Informações do cliente
                </div>
                <div class="card-body">
                    <form action="{{route('cliente.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Tipo de cliente</label>
                            <select class="form-control" name="customer_type_id" id="tipoCliente">
                                <option value="">Selecione um tipo de cliente</option>
                                @foreach($tiposCliente as $tipo)
                                    <option value="{{$tipo->id}}">{{ $tipo->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="identificacaoCliente" hidden>
                            <label for="name" id="labelTipo">Tipo de cliente</label>
                            <input type="text" name="identification_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Salvar" class="btn btn-lg btn-success">
                        </div>
                    </form>            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/create.js')}}"></script>
@endsection