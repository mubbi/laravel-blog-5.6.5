<div class="card mb-3">
    <div class="card-header">Subscribe</div>
    <div class="card-body">
        <form action="{{ url('subscribe') }}" method="post" id="subscribe_form">
            <div class="form-row">
                <div class="col-md-12">
                    <label for="email">Email ID <span class="required">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email ID" required>
                    <small>Get Latest Updates by Email</small>
                </div>
                <div class="col-md-12">
                    <div id="subscriber_response"></div>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-envelope"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>