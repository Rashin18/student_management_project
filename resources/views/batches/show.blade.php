@extends ('layout')
@section('content')
<div class="card">
    <div class="card-header">Batch Page</div>
    <div class="card-body">
        <h5 class="card-title">Batch Name: {{ $batches->name }}</h5>
        <p class="card-text">Course Name: {{ $batches->course->name }}</p>
        <p class="card-text">Start date: {{ $batches->start_date }}</p>
    </div>
    <hr>
</div>
@endsection
