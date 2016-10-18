@extends('app')

@section('content')
    <div class="container">
        <h3>Nova pedido</h3>

        @include('errors._check')

        {!! Form::open(['class' => 'form']) !!}

            <div class="container">
                <div class="form-group">
                    <label>Total: </label>
                    <p id="total"></p>
                    <a href="#" id="btnNewItem" class="btn btn-primary">Novo item</a>
                </div>
            </div>
            <table id="tblAppendGrid" class="table table-bordered">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-control" name="items[0][product_id]">
                                @foreach($products as $p)
                                    <option value="{{$p->id}}" data-price="{{$p->price}}"> {{$p->name}} --- {{$p->price}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {!! Form::text('items[0][qtd]', 1, ['class' =>'form-control']) !!}
                        </td>

                    </tr>
                </tbody>
            </table>

        {!! Form::close() !!}

    </div>
@endsection

@section('post-script')
    {{--<script>--}}
        {{--$('#btnNewItem').click(function () {--}}
            {{--var row = $('table tbody > tr:last'),--}}
                    {{--newRow = row.clone(),--}}
                    {{--length = $("table tbody tr").length;--}}
            {{--newRow.find('td').each(function () {--}}
                {{--var td = $(this),--}}
                        {{--input = td.find('input,select'),--}}
                        {{--name = input.attr('name');--}}
                {{--input.attr('name', name.replace((length - 1) + "", length + ""));--}}
            {{--});--}}
            {{--newRow.find('input').val(1);--}}
            {{--newRow.insertAfter(row);--}}
        {{--});--}}
    {{--</script>--}}

        <!--jQuery UI Core, Widget and Button components are mandatory-->
    <link href="jquery-ui-1.11.1.css" rel="stylesheet"/>
    <link href="jquery.appendGrid-1.6.2.css" rel="stylesheet"/>
    <script type="text/javascript" src="jquery-1.11.1.js"></script>
    <script type="text/javascript" src="jquery-ui-1.11.1.js"></script>
    <script type="text/javascript" src="jquery.appendGrid-1.6.2.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#btnNewItem').appendGrid();
        });
    </script>
@endsection