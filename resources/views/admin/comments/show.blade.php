@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Comments - View <a href="{{ route('comments.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <p><b>ID:</b> {{ $comment->id }}</p>
                <div class="form-group">
                    <label for="name"><b>Author:</b></label>
                    {{ $comment->name }}
                    <p><b>Email</b>: {{ $comment->email }}</p>
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Commented on Blog:</b></label>
                    <a href="route('blogs.show', $comment->blog->id)">{{ $comment->blog->title }}</a>
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Submitted at:</b></label>
                    {{ $comment->created_at }}
                </div>
                <div class="form-group">
                    <label for="user_id"><b>Updated at:</b></label>
                    {{ $comment->updated_at }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('custom_js')
@endsection
