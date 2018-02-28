$("#subscribe_form").submit(function(e) {

    if ( $("#subscribe_form #email").val() == '' ) {
        alert('Email Required');
    }
    else {
        // Submit Ajax Request
        $.ajax({
            url: '$("#subscribe_form").attr("action")',
            type: 'POST',
            dataType: 'json',
            data: {
                email: $("#subscribe_form #email").val()
            },
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    // Stop Form
    e.preventDefault();
});