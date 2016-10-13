@extends('app')

@section('content')
    <div class="container">
        <h3>Clients</h3>
        <br>
{{--        <a href={{route('admin.orders.create')}} class="btn btn-default">Novo cliente</a>--}}
        <br><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Pedido</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <th>{{ $order->user->name }}</th>
                    <th>
{{--                        <a href="{{ route('admin.orders.edit', ['id' => $order->id]) }}" class="btn btn-default">Edit</a>--}}
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>
@endsection