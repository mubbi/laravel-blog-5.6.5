@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Showing blogs in category "{{ $category->name }}"</div>

    <div class="card-body">

        <div class="row mb-5">
            @if(count($blogs) < 1 )
            <div class="col-md-12">
                <h3>No blogs found in this category.</h3>
            </div>
            @endif
            @foreach($blogs as $blog)
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="{{ $blog->image }}" alt="{{ $blog->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
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