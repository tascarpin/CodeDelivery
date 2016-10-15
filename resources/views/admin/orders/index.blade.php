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
                <td>Total</td>
                <td>Data</td>
                <td>Itens</td>
                <td>Entregador</td>
                <td>Status</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <th>{{ $order->total }}</th>
                    <th>{{ $order->created_at }}</th>
                    <th>
                        @foreach( $order->items as $item)
                            <li>{{$item->product->name}}</li>
                        @endforeach
                    </th>
                    <th>
                        @if($order->deliveryman)
                            {{$order->deliveryman->name}}
                        @else
                            --
                        @endif
                    </th>
                    <th>{{ $order->status }}</th>
                    <th>
                        <a href="{{ route('admin.orders.edit', ['id' => $order->id]) }}" class="btn btn-default">Edit</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>
@endsection