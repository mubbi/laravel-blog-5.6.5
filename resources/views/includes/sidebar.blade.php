<div class="card">
    <div class="card-header">Categories</div>
    <div class="card-body">
        <ul class="list-group">
          @foreach($sidebar_categories as $category)
          <li class="list-group-item"><a href="{{ url('category/'.$category->slug) }}">{{ $category->name }}</a></li>
          @endforeach
        </ul>
    </div>
</div>