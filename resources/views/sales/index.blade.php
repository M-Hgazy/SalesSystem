@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Sales</h2>
            </div>
            <div class="pull-right">
                @can('sale-create')
                    <a class="btn btn-success" href="{{ route('sales.create') }}"> Create New Sale</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Target</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $sale->name }}</td>
                <td>{{ $sale->amount }}</td>
                <td>
                    <form action="{{ route('sales.destroy',$sale->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('sales.show',$sale->id) }}">Show</a>
                        @can('sale-edit')
                            <a class="btn btn-primary" href="{{ route('sales.edit',$sale->id) }}">Edit</a>
                        @endcan

                        @csrf
                        @method('DELETE')
                        @can('sale-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $sales->links() !!}

@endsection
