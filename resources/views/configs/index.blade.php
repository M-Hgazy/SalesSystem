@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>configs</h2>
            </div>
            <div class="pull-right">
                @can('sale-create')
                    <a class="btn btn-success" href="{{ route('configs.create') }}"> Create New config</a>
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
        @foreach ($configs as $config)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $config->name }}</td>
                <td>{{ $config->amount }}</td>
                <td>
                    <form action="{{ route('configs.destroy',$config->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('configs.show',$config->id) }}">Show</a>
                        @can('config-edit')
                            <a class="btn btn-primary" href="{{ route('configs.edit',$config->id) }}">Edit</a>
                        @endcan

                        @csrf
                        @method('DELETE')
                        @can('config-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $configs->links() !!}

@endsection
