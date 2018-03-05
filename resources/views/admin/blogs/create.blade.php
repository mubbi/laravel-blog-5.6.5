@extends('admin/layouts.app')

@section('custom_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs - Add New <a href="{{ route('blogs.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
     <form method="post" action="route('blogs.store')">
         <div class="form-group row">
             <label for="title" class="col-sm-2 form-control-label">title</label>
             <div class="col-sm-10">
                 <input type="text" class="form-control" id="title" name="title" placeholder="title">
             </div>
         </div>
         <div class="form-group row">
             <label for="categories" class="col-sm-2 form-control-label">Categories</label>
             <div class="col-sm-10">
                <select class="form-control" id="categories" name="categories[]" multiple>
                </select>
             </div>
         </div>
         <div class="form-group row">
             <label for="excerpt" class="col-sm-2 form-control-label">excerpt</label>
             <div class="col-sm-10">
                <textarea name="exceprt" class="form-control"></textarea>
             </div>
         </div>
         <div class="form-group row">
             <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-secondary">Add</button>
             </div>
         </div>
     </form>
    </div>

</div>
@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#categories').select2({
        theme: "bootstrap",
        tags: true,
        // allowClear: true,
        // placeholder: "Choose Categories...",
        minimumInputLength: 2,
        delay : 200,
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
});
</script>
@endsection
