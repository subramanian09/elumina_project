@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Customer Form</h2>
            </div>
            <div class="pull-right">
                @can('form-create')
                <a class="btn btn-success" href="{{ route('form.create') }}"> Create New Form</a>
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date Of Birth</th>
            <th>status</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($forms as $form)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $form->first_name }}</td>
	        <td>{{ $form->last_name }}</td>
            <td>{{ $form->email }}</td>
            <td>{{ $form->date_of_birth }}</td>
            <td>{{ $form->status }}</td>
	        <td>
                <form action="{{ route('form.destroy',$form->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('form.show',$form->id) }}">Show</a>
                    @can('form-edit')
                    <a class="btn btn-primary" href="{{ route('form.edit',$form->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('form-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $forms->links() !!}

@endsection