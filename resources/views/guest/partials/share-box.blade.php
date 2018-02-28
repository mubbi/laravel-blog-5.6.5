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