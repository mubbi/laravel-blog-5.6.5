$("#subscribe_form").submit(function(e) {
    // Submit Ajax Request
    $.ajax({
        url: '$("#subscribe_form").attr("action")',
        type: 'POST',
        dataType: 'json',
        data: {
            email_id: $("#subscribe_form #email_id").val()
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

    // Stop Form
    e.preventDefault();
});