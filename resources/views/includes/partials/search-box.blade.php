<div class="card mb-3">
    <div class="card-header">Search</div>
    <div class="card-body">
        <form action="{{ url('search') }}" method="get" enctype="application/x-www-form-urlencoded">
            <div class="form-row">
                <div class="col-md-12">
                    <input type="text" class="form-control" name="q" value="{{ isset($_GET['q']) ? $_GET['q'] : ''  }}" placeholder="Search..." required>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>