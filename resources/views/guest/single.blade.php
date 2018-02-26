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
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="http://www.facebook.com/sharer.php?u={{ url('post/'.$blog->slug) }}" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com/share?url={{ url('post/'.$blog->slug) }}&amp;text={{ $blog->title }}&amp;" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('post/'.$blog->slug) }}" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://plus.google.com/share?url={{ url('post/'.$blog->slug) }}" target="_blank"><i class="fab fa-google-plus-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="mailto:?Subject={{ $blog->title }}&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{ url('post/'.$blog->slug) }}"><i class="fas fa-envelope-square fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:;" onclick="window.print()"><i class="fas fa-print fa-2x"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="http://reddit.com/submit?url={{ url('post/'.$blog->slug) }}&amp;title={{ $blog->title }}" target="_blank"><i class="fab fa-reddit-square fa-2x"></i></a>
                    </li>
                </ul>
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