$("#subscribe_form").submit(function(e) {
    alert('test');

    if ( $("#subscribe_form #email").val() == '' ) {
        alert('Email Required');
        alert('test 2');
    }
    else {
        alert('test 3');

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