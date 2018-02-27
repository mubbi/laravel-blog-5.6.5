@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Latest</div>

    <div class="card-body">

        <div class="row mb-5">
            @foreach($blogs as $blog)
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="{{ $blog->image }}" alt="{{ $blog->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <h6><i>{{ date('F d, Y h:i A', strtotime($blog->created_at)) }}</i></h6>
                        <p class="card-text">{{ $blog->excerpt }}</p>
                        <a href="{{ url('post/'.$blog->slug) }}" class="btn btn-primary btn-sm">Read More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                {{ $blogs->links() }}
            </div>
        </div>

    </div>
</div>
@endsection