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