

    // filtrar producto
    $(document).on('keyup', '#buscar_producto', function(){
        var texto_input = $(this).val();

        $("#list tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
        });        
    });

    // Seleccionar persona
    $(document).on('click', '.seleccionar_persona', function(){
        var id = $(this).attr("id");
        var name = $(this).attr("name");

        $.ajax({
            url: "<?php echo base_url(). 'admin/usuario/validar_usuario'; ?>"+ id,
            datatype: 'json',      
            cache : false,                

            success: function(data){
                if(data){
                     $(".notificacion_texto").text("Empleado ya vinculado a un usuario existente.");
                    $('#error').modal('show');

                }else{
                    $("#persona").val(id);
                    $("#nombre_persona").val(name);
                    $('#persona_modal').modal('hide');
                }               
            },
            error:function(){
            }
        });
    });

    //Compar password
    $(document).on('click','#btn_save',function(){
        var password = $("#password").val();
        var password2 = $("#password2").val();

        if( (password == password2) ){
            //$('form#crear').submit();
        }else{
            $(".notificacion_texto").text("Password Diferente.");
            $('#error').modal('show');
        }
    });

    $("#imagen_nueva").hide();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('.preview_producto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            $("#imagen_nueva").show();
            }
        }

    // Asignar roles
    $(document).on('click', '.agregar_rol', function(){
        var id_rol = $(this).attr("id");
        var accion = $(this).attr("name");
        var usuario = $("#id_usuario").val();
        var data = {id_rol : id_rol, usuario:usuario, metodo:accion };
        //url = <?php echo base_url() ?>;
        var url = "<?php echo base_url() ?>"; 

        $.ajax({
            url:  url+"admin/usuario/agregar_remover_rol",
            datatype: 'json',
            type : 'GET',
            data : data,
            cache : false,                

            success: function(data){
                dibujar(data);
            },
            error:function(){
            }
        });
        
    });

    function dibujar(response_data){
        var html = '';
        var datos = JSON.parse(response_data);
        $(".roels_asignados").empty();
                
        $.each(datos, function(i, item) {
            html += '<label class="btn btn-success label-lg agregar_rol" style="margin-top:2px;" name="remover" id="'+item.id_rol+'">';
                html += item.role;
            html += '</label>';
        });

        $(".roels_asignados").html(html);
    }
