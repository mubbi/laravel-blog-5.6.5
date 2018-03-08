@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Users - View <a href="{{ route('users.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <p><b>ID:</b> {{ $user->id }}, <b>Created at</b>: {{ $user->created_at }}, <b>Updated At</b> {{ $user->updated_at }}</p>
                <div class="form-group">
                    <label for="name"><b>Name:</b></label>
                    {{ $user->name }}
                </div>
                <div class="form-group">
                    <label for="email"><b>Email:</b></label>
                    {{ $user->email }}
                </div>
                <div class="form-group">
                    <label for="is_active"><b>Active:</b></label>
                    {{ $user->is_active == 1 ? 'Yes' : 'No' }}
                </div>
                <div class="form-group">
                    <label for="about"><b>About: </b></label>
                    {{ $user->about }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('custom_js')
@endsection
