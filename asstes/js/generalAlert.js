

function generalAlert( type , mensaje , title , boton , finalMessage) {

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

            if (isConfirm) {
                swal("Ok ", finalMessage);
                //redirec("index");
                //window.location.href = 'index';
            } else {
                swal("Cancelado", "Debes Hacer Login de Nuevo", "error");
            }
            
        });

  
}