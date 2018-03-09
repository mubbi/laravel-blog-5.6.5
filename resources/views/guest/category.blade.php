@extends('layouts.app')

@section('pageTitle', 'Category "'.$category->name.'" - '.app('global_settings')[0]['setting_value'])

@section('content')
<div class="card">
    <div class="card-header">Showing blogs in category "{{ $category->name }}"</div>

    <div class="card-body">

        @include('guest.partials.blogs-loop-box')

        <div class="row">
            <div class="col-md-12">
                {{ $blogs->links() }}
            </div>
        </div>

    </div>
</div>
@endsection