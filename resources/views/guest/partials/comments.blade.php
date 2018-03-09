@if($blog->allow_comments == 1)
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
                                <img class="mr-3 rounded-circle" src="https://www.gravatar.com/avatar/{{ md5( strtolower( trim("$comment->email") ) ) }}?d=http://placehold.it/80" alt="{{ $comment->name }}">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">{{ $comment->name }} - <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    @auth
                                    <a href="{{ route('comments.spamStatus', $comment->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-bug"></i> Spam</a>
                                    <a href="javascript:void(0);" onclick="callDeletItem('{{ $comment->id }}', 'comments');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                    @endauth
                                    </h5>
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

@auth
<form action="#" method="post" id="deletCommentForm" display: none;>
    @csrf
    {{ method_field('DELETE') }}
</form>

@section('custom_js')
<script>
function callDeletItem(id, model) {
    if (confirm('Are you sure?')) {
        $("#deletCommentForm").attr('action', base_url + '/admin/'+ model + '/' + id);
        $("#deletCommentForm").submit();
    }
}
</script>
@endsection
@endauth

@endif