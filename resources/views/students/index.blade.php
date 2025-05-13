@extends('layout')

@section('content')

<div class="card">
    <div class="card-header">
        <h2 class="text-center">Student Application</h2>
    </div>
    <div class="card-body">
        <a href="{{ url('/students/create') }}" class="btn btn-success btn-sm mb-3" tittle="Add New Student">
            <i class="fa fa-plus"></i> Add New
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td>
                                <a href="{{ url('/students/' . $item->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('/students/' . $item->id . '/edit') }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ url('/students/' . $item->id) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @can('manage-students')
                                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                                        Add New Student
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
