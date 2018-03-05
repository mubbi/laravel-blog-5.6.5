<!-- Add Comment Box -->
<div class="card mb-3">
    <div class="card-header">Add a Comment</div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">

                @if($blog->allow_comments == 1)
                    <form action="{{ url('post/comment') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="name">Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email <span class="required">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Your Email ID" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="name">Your Comment <span class="required">*</span></label>
                                <textarea name="body" class="form-control" rows="4" placeholder="Write something nice..." required>{{ old('body') }}</textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-comment"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                @else
                <h4>Comments are disabled!</h4>
                @endif

            </div>
        </div>

    </div>
</div>