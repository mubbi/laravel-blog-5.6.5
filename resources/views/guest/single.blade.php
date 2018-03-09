@extends('layouts.app')

@section('pageTitle', $blog->title.' - '.app('global_settings')[0]['setting_value'])
@section('pageDescription', $blog->excerpt)
@section('pageImage', url( Storage::url( $blog->image ) ) )

@section('content')
<div class="card mb-3">
    <div class="card-header">{{ $blog->title }}</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" title="Share on Pinterest">
                    <img class="img-thumbnail img-responsive mb-4" src="{{ url( Storage::url($blog->image) ) }}" alt="{{ $blog->title }}">
                </a>
            </div>
            <div class="col-md-6">
                <p><i class="fas fa-calendar-alt"></i> Posted on: {{ date('F d, Y h:i A', strtotime($blog->created_at)) }}</p>
            </div>
            <div class="col-md-6">
                <p><i class="fas fa-user"></i> Posted by: <a href="#author_section">{{ $blog->user->name }}</a></p>
            </div>
            <div class="col-md-7">
                <p>
                    <i class="fas fa-tags"></i> Categories:
                    @foreach($blog->categories as $category)
                    <a href="{{ url('category/'.$category->slug) }}" class="badge badge-primary">{{ $category->name }}</a>
                    @endforeach
                </p>
            </div>
            <div class="col-md-3">
                <p><i class="fas fa-eye"></i> Views: {{ $blog->views }}</p>
            </div>
            <div class="col-md-12">
                {!! $blog->description !!}
            </div>
        </div>

    </div>
</div>

@include('guest.partials.share-box')

@include('guest.partials.author-box')

@include('guest.partials.comment-box')

@include('guest.partials.comments')

@endsection