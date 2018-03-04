<div class="row mb-5">
    @if(count($blogs) < 1 )
    <div class="col-md-12">
        <h3>No blogs found.</h3>
    </div>
    @endif
    @foreach($blogs as $blog)
    <div class="col-md-6">
        <div class="card">
            <img class="card-img-top" src="{{ $blog->image }}" alt="{{ $blog->title }}">
            <div class="card-body">
                <h5 class="card-title"><a href="{{ url('post/'.$blog->slug) }}">{{ $blog->title }}</a></h5>
                <p class="card-text">{{ $blog->excerpt }}</p>
                <a href="{{ url('post/'.$blog->slug) }}" class="btn btn-primary btn-sm">Read More <i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="card-footer text-muted">
            {{ date('F d, Y h:i A', strtotime($blog->created_at)) }}
            </div>
        </div>
    </div>
    @endforeach
</div>