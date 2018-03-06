@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs - View <a href="{{ route('blogs.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        {{ $blog->id }}
        {{ $blog->title }}
        {{ $blog->slug }}
        {{ $blog->image }}
        {{ $blog->excerpt }}
        {{ $blog->description }}
        {{ $blog->views }}
        {{ $blog->user_id }}
        {{ $blog->is_active }}
        {{ $blog->allow_comments }}
        {{ $blog->created_at }}
        {{ $blog->updated_at }}
        {{ $blog->deleted_at }}

        @foreach($blog->categories as $category)
        {{ $category->name }}
        @endforeach

    </div>

</div>
@endsection

@section('custom_js')
@endsection
