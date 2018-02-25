@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-header">{{ $blog->title }}</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                {{ $blog->image }}
            </div>
            <div class="col-md-12">
                {!! $blog->description !!}
            </div>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-header">Share</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                Share Widgets
            </div>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-header">Comments</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                Comments list
            </div>
        </div>

    </div>
</div>
@endsection