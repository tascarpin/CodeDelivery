@extends('app')

@section('content')
    <div class="container">
        <h3>Product</h3>
        <br>
        <a href={{route('admin.products.create')}} class="btn btn-default">Novo produto</a>
        <br><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Produto</td>
                <td>Categoria</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <th>{{ $product->name }}</th>
                    <th>{{ $product->category->name }}</th>
                    <th>
                        <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-default">Edit</a>
                        <a href="{{ route('admin.products.destroy', ['id' => $product->id]) }}" class="btn btn-danger">Destroy</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $products->render() !!}
    </div>
@endsection