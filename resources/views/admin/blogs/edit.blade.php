@extends('admin/layouts.app')

@section('custom_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs - Edit <a href="{{ route('blogs.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ route('blogs.update', $blog->id) }}" enctype="multipart/form-data" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title <span class="required">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" placeholder="Write something beautiful today..." onkeyup="countChar(this, 'charNumTitle', 60)" maxlength="60" required>
                        <span id="charNumTitle" class="text-info">60 Characters Left</span>
                    </div>
                    <div class="form-group">
                        <label for="excerpt">Excerpt/Summary <span class="required">*</span></label>
                        <textarea name="excerpt" id="excerpt" class="form-control" rows="3" maxlength="280" placeholder="summary of my beautiful words..." onkeyup="countChar(this, 'charNumExcerpt', 280)" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                        <span id="charNumExcerpt" class="text-info">280 Characters Left</span>
                        <small id="excerptHelp" class="form-text text-muted">Excerpts are hand-crafted summaries of your content helps search engines and to show post on home page</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="6" required>{!! old('description', $blog->description) !!}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="image">Featured Image (optional)</label>
                        <img class="img-fluid" src="{{ url( Storage::url($blog->image) ) }}" alt="{{ $blog->title }}">
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="categories">Categories <span class="required">*</span></label>
                        <select class="form-control" id="categories" name="categories[]" required multiple>
                            @if (is_array(old('categories')))
                                @foreach (old('categories') as $oldCategory)
                                <option value="{{ $oldCategory }}" selected="selected">
                                    @if(is_numeric($oldCategory))
                                        {{ App\Category::where('id', $oldCategory)->get()->pluck('name')[0] }}
                                    @else
                                        {{ $oldCategory }}
                                    @endif
                                </option>
                                @endforeach
                            @else
                                @foreach($blog->categories as $category)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Author <span class="required">*</span></label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}" @if(old('user_id', $blog->user_id) == $author->id) selected @endif>{{ $author->name }} ({{ $author->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Publish <span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" @if(old('is_active', $blog->is_active) == 1) selected @endif>Yes</option>
                            <option value="0" @if(old('is_active', $blog->is_active) == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="allow_comments">Allow Comments <span class="required">*</span></label>
                        <select class="form-control" id="allow_comments" name="allow_comments" required>
                            <option value="1" @if(old('allow_comments', $blog->allow_comments) == 1) selected @endif>Yes</option>
                            <option value="0" @if(old('allow_comments', $blog->allow_comments) == 0) selected @endif>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
// Integrate TinyMCE Editor
// Make Config Settings
var editor_config = {
    path_absolute : base_url,
    selector:'#description',
    height: 450,
    plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat',
    image_advtab: true,
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + '/tinymce/filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };
// Init TinyMCE
tinymce.init(editor_config);

$(document).ready(function() {
    $('#categories').select2({
        theme: "bootstrap",
        tags: true,
        placeholder: "Choose Categories...",
        minimumInputLength: 2,
        delay : 200,
        tokenSeparators: [',','.'],
        ajax: {
            url: '{{ route("categories.ajaxSelectData") }}',
            dataType: 'json',
            cache: true,
            data: function(params) {
              return {
                  term: params.term || '',
                  page: params.page || 1
              }
          },
        }
    });
    $('#categories').trigger('change');
});

// Count Char Helper
function countChar(val, id, limit) {
    leftChar = limit - val.value.length;
    $('#'+id).text( leftChar + " Characters Left");
}
</script>
@endsection
