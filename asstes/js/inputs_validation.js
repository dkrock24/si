$(document).ready(function () {

    var action  = $('#generic_form').attr('name');
    
    var a = $('#generic_form').validate({ // initialize the plugin

        rules: {
            role: {
                required: true,
            },
            pagina: {
                required: true,
                minlength: 2
            }
        },
        submitHandler: function (form) { // for demo
            e.preventDefault();
            console.log('Form submitted');
            $.ajax({
                type: 'POST',
                url: action,
                dataType: "html",
                data: $('form').serialize(),
                success: function(result) {
                    window.location.href = "index";
                },
                error : function(error) {

                }
            });
            return false;
        }
    });

    if ($('#fogeneric_formrm').valid())
        $('#generic_form').submit();

    

});