/*
*   PRINT GENERAL FUNCIONS
*/



// Print.js

function b()
{ 
    var x = $("#pdfParametros").serializeArray();
    
    var y = [] ;

    x.map(function (value, label) {
        y.push(value.name);
        
    });    

    generate(y);
}; 

function exportPdf(){
    $("#opciones").modal();
}

function generate(x) {
    
    var doc = new jsPDF();

    // Simple data example
    var head = x;
    

    var body = []; 

    var a = 0;
    var attr;

    a = 0;
    var flag = true;
    newObject = records.map(function (value, label) {

        var b = 1;
        var c = 0;
        var Linea = [];

        if(b <= head.length){
            while (b <= head.length) {

                attr = head[c];
    
                    Linea[c] =  value[attr] ;
                    if(value[attr] == null ){
                        //console.log(value[attr], attr);
                        Linea[b] =  "NULL";
                    }
    
                b++;
                c++;
            }
            body[a] = Linea;
            a++;
        }else{
            return 1;
        }
        
    });

    doc.autoTable({ head: [head], body: body } );

    // Simple html example
    //doc.autoTable({head: head, body: '#datosLista'});

    doc.save(documento_titulo+'.pdf');
}