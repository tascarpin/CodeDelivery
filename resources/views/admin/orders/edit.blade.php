@extends('app')

@section('content')
    <div class="container">
        <h2>Editando pedido: #{{$order->id}} - R$ {{$order->total}}</h2>
        <h3>Cliente: {{$order->client->user->name}}</h3>
        <h4>Data: {{$order->created_at}}</h4>

        <p>
            <b>Entregar<b></b> em:<br>
            {{$order->client->address}} - {{$order->client->city}}/{{$order->client->state}}
        </p>

        {!! Form::model($order, ['route' => ['admin.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('status', 'Status:') !!}
            {!! Form::select('status', $list_status, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('entregador', 'Entregador:') !!}
            {!! Form::select('user_deliveryman_id', $deliveryman, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar pedido!', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection