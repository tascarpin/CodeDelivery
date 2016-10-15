@extends('app')

@section('content')
    <div class="container">
        <h3>Cupom</h3>
        <br>
        <a href={{route('admin.cupoms.create')}} class="btn btn-default">Novo cupom</a>
        <br><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Código</td>
                <td>Value</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($cupoms as $cupom)
                <tr>
                    <th>{{ $cupom->id }}</th>
                    <th>{{ $cupom->code }}</th>
                    <th>{{ $cupom->value }}</th>
                    <th>
                        <a href="{{ route('admin.cupoms.edit', ['id' => $cupom->id]) }}" class="btn btn-default">Edit</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $cupoms->render() !!}
    </div>
@endsection