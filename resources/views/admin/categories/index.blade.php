@extends('app')

@section('content')
    <div class="container">
        <h3>Category</h3>
        <br>
        <a href={{route('admin.categories.create')}} class="btn btn-default">Nova categoria</a>
        <br><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Categoria</td>
                <td>Ação</td>
            </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <th>{{ $category->name }}</th>
                    <th>
                        <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}" class="btn btn-default">Edit</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $categories->render() !!}
    </div>
@endsection