@extends('app')

@section('content')
    <div class="container">
        <h3>Clients</h3>
        <br>
        <a href={{route('admin.clients.create')}} class="btn btn-default">Novo cliente</a>
        <br><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Cliente</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <th>{{ $client->id }}</th>
                    <th>{{ $client->user->name }}</th>
                    <th>
                        <a href="{{ route('admin.clients.edit', ['id' => $client->id]) }}" class="btn btn-default">Edit</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $clients->render() !!}
    </div>
@endsection