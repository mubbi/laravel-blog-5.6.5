@extends('admin/layouts.app')

@section('custom_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Users Roles - Edit <a href="{{ route('users.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="check_all">
            <label class="form-check-label" for="check_all">
                Check All
            </label>
        </div>
        <form method="post" action="{{ route('users.updateRoles', $user->id) }}">
            @csrf
            {{ method_field('PUT') }}

            @foreach($roles->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $role)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->id }}" id="{{ $role->role }}" @if($user->hasRole($role->role)) checked @endif>
                            <label class="form-check-label" for="{{ $role->role }}">
                                <abbr title='{{ $role->description }}'>{{ ucfirst(str_replace('_', ' ', $role->role)) }}</abbr>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('custom_js')
<script>
    $("#check_all").click(function() {
        $('[name="roles[]"]').prop('checked', $(this).is(':checked'));
    });
</script>
@endsection
