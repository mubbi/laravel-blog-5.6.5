@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Users - Edit <a href="{{ route('users.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ route('users.update', $user->id) }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (optional)</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="about">About (optional)</label>
                        <textarea name="about" id="about" class="form-control" rows="3">{{ old('about', $user->about) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Active <span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" @if(old('is_active', $user->is_active) == '1') selected @endif>Yes</option>
                            <option value="0" @if(old('is_active', $user->is_active) == '0') selected @endif>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('custom_js')
@endsection
