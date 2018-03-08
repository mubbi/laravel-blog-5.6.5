@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Settings</div>

    <div class="card-body">
        <form method="post" action="{{ route('settings.update') }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('custom_js')
@endsection
