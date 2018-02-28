$("#subscribe_form").submit(function(e) {
    $('#subscriber_response').html('');

    if ( $("#subscribe_form #email").val() == '' ) {
        alert('Email Required');
    }
    else {
        // Submit Ajax Request
        $.ajax({
            url: $("#subscribe_form").attr("action"),
            type: 'POST',
            dataType: 'json',
            data: {
                email: $("#subscribe_form #email").val()
            },
        })
        .done(function(data) {
            $('#subscriber_response').html('<div class="alert alert-success">' + data + '</div>');
        })
        .fail(function(data) {
            // If there are some errors
            if( data.status === 422 )
            {
                //process validation errors here.
                var errors = data.responseJSON.errors; //this will get the errors response data.

                //show them somewhere in the markup
                errors_html = '<div class="alert alert-danger"><ul>';

                $.each( errors, function( key, value ) {
                    errors_html += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errors_html += '</ul></div>';

                $('#subscriber_response').html(errors_html); //appending to a <div id="form-errors"></div> inside form
            }
            else
            {
                $('#subscriber_response').html('<div class="alert alert-danger">Something Went Wrong.</div>'); //appending to a <div id="form-errors"></div> inside form
            }
        })
        .always(function() {
            console.log("Subscribe form process Completed");
        });
    }

    // Stop Form
    e.preventDefault();
});