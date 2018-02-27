@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-header">{{ $blog->title }}</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" title="Share on Pinterest">
                    <img class="img-thumbnail img-responsive mb-4" src="{{ $blog->image }}" alt="{{ $blog->title }}">
                </a>
            </div>
            <div class="col-md-6">
                <p><i class="fas fa-calendar-alt"></i> Posted on: {{ date('F d, Y h:i A', strtotime($blog->created_at)) }}</p>
            </div>
            <div class="col-md-6">
                <p><i class="fas fa-user"></i> Posted by: <a href="#author_section">{{ $blog->user->name }}</a></p>
            </div>
            <div class="col-md-12">
                <p>
                    <i class="fas fa-tags"></i> Categories:
                    @foreach($blog->categories as $category)
                    <a href="{{ url('category/'.$category->slug) }}" class="badge badge-primary">{{ $category->name }}</a>
                    @endforeach
                </p>
            </div>
            <div class="col-md-12">
                {!! $blog->description !!}
            </div>
        </div>

    </div>
</div>

<!-- Share Buttons Box -->
<div class="card mb-3">
    <div class="card-header">Share</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="http://www.facebook.com/sharer.php?u={{ url('post/'.$blog->slug) }}" target="_blank" data-toggle="tooltip" title="Share on Facebook"><i class="fab fa-facebook fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com/share?url={{ url('post/'.$blog->slug) }}&amp;text={{ $blog->title }}&amp;" target="_blank" data-toggle="tooltip" title="Share on Twitter"><i class="fab fa-twitter-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://plus.google.com/share?url={{ url('post/'.$blog->slug) }}" target="_blank" data-toggle="tooltip" title="Share on Google plus"><i class="fab fa-google-plus-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('post/'.$blog->slug) }}" target="_blank" data-toggle="tooltip" title="Share on Linkedin"><i class="fab fa-linkedin fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="http://reddit.com/submit?url={{ url('post/'.$blog->slug) }}&amp;title={{ $blog->title }}" target="_blank" data-toggle="tooltip" title="Share on Reddit"><i class="fab fa-reddit-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="mailto:?Subject={{ $blog->title }}&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{ url('post/'.$blog->slug) }}" data-toggle="tooltip" title="Send as in email"><i class="fas fa-envelope-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:;" onclick="window.print()" data-toggle="tooltip" title="Get a print"><i class="fas fa-print fa-2x"></i></a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Author Box -->
<div class="card mb-3" id="author_section">
    <div class="card-header">About Author</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
              <h4>{{ $blog->user->name }}</h4>
              <p>{{ $blog->user->about }}</p>
            </div>
        </div>

    </div>
</div>

<!-- Add Comment Box -->
<div class="card mb-3">
    <div class="card-header">Add a Comment</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">

                <form action="{{ url('post/comment') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="name">Name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Your Email ID">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="name">Your Comment <span class="required">*</span></label>
                            <textarea name="body" class="form-control" rows="4" placeholder="Write something nice...">{{ old('body') }}</textarea>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-comment"></i> Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<!-- Comments List Box -->
<div class="card mb-3" id="comments_section">
    <div class="card-header">Comments <small class="float-right">{{ $total_comments }} Comments</small></div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">

                @if(count($comments) < 1)
                <h4>No comments yet! Be the first to comment</h4>
                @else
                    <ul class="list-unstyled">
                        @foreach($comments as $comment)
                            <li class="media mb-3">
                                <img class="mr-3 rounded-circle" src="https://www.gravatar.com/avatar/{{ md5( strtolower( trim("$comment->email") ) ) }}?d=http://placehold.it/70" alt="{{ $comment->name }}">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">{{ $comment->name }} - <small>{{ $comment->created_at->diffForHumans() }}</small></h5>
                                    {{ $comment->body }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
            <div class="col-md-12">
                {{ $comments->fragment('comments_section')->links() }}
            </div>
        </div>

    </div>
</div>
@endsection