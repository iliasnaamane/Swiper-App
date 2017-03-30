$(document).ready(function (){
    validate();
    $('#title, #textarea').keyup(validate);
    $('#exampleInputFile').change(validate);
    var text_max = 350;
    $('#textarea_feedback').html(text_max + ' characters remaining');

    $('#textarea').keyup(function() {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;
        $('#textarea_feedback').html(text_remaining+' characters remaining');
    });
        
});

function validate(){
    if ($('#title').val().length   >   0   &&
        $('#textarea').val().length  >   0   &&
        $('#exampleInputFile').val()  ) {
        $("button[type=submit]").prop("disabled", false);
    }
    else {
        $("button[type=submit]").prop("disabled", true);
    }
}

   
