function exportXLS(){
    
    //console.log(headers);
    //console.log(records);

    $.ajax({
        type: 'POST',
        datatype: 'json',
        cache: false,
        data: {
            data: 1,
        },
        url: "export",

        success: function(data) {

            //location.reload();
        },
        error: function() {}
    });
    
}