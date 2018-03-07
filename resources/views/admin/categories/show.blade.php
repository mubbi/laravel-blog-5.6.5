@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Categories - View <a href="{{ route('categories.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <p><b>ID:</b> {{ $category->id }}</p>
                <div class="form-group">
                    <label for="name"><b>Name:</b></label>
                    <p>{{ $category->name }}</p>
                    <p><b>Slug</b>: {{ $category->slug }}</p>
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Created By:</b></label>
                    {{ $category->user->name }}
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Created at:</b></label>
                    {{ $category->created_at }}
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Updated at:</b></label>
                    {{ $category->updated_at }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('custom_js')
@endsection
