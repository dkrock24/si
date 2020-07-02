

function generalAlert( type , mensaje , title , boton , finalMessage, url) {
    swal({

        html: true,
        title: title,
        text: mensaje,
        type: type,
        showCancelButton: false,
        confirmButtonColor: boton,
        confirmButtonText: "Ok",
        cancelButtonColor: "danger",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: false

    }, function (isConfirm) {

        $(document).ready(function() {
            $('.confirm').focus();
            $("#m_orden_creada").hide();
        });

        if (isConfirm) {
            swal("Ok ", finalMessage);
            //redirec("index");
            if(url != null){
                window.location.href = url;
            }
        } else {
            swal("Cancelado", "Debes Hacer Login de Nuevo", "error");
        } 
    });
}