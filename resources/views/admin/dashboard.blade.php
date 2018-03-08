@extends('admin/layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Dashboard</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-info">
                    <div class="card-header">At a Glance</div>
                    <div class="card-body">
                        <p class="card-text">{{ $blogs_count }} Blogs</p>
                        <p class="card-text">{{ $comments_count }} Comments</p>
                        <p class="card-text">{{ $categories_count }} Categories</p>
                        <p class="card-text">{{ $users_count }} Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection