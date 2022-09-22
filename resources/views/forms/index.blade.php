@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Form List</h2>
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
            <th>Status</th>
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
                <form>
                    <a class="btn btn-info" href="{{ route('forms.show',$form->id) }}">Show</a>
                    <a class="btn btn-info" href="{{ route('approve',$form->id) }}">Approve</a>
                    <a class="btn btn-info" href="{{ route('reject',$form->id) }}">Reject</a>
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $forms->render() !!}

@endsection