@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Showing Blogs in category "XYZ"</div>

    <div class="card-body">

        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="http://placehold.it/450x300" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="http://placehold.it/450x300" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <nav aria-label="pagination">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>
            </div>
        </div>

    </div>
</div>
@endsection