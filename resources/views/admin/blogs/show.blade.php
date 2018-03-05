@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs - View <a href="{{ route('blogs.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
    View Blog Data
    </div>

</div>
@endsection

@section('custom_js')
@endsection
