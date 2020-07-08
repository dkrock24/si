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

    var e = [] ;
    x.map(function (value, label) {
        e.push(value.value);
    }); 


    generate(e,y);
}; 

function exportPdf(){
    $("#opciones").modal();
}

function generate(e,x) {

    var doc = new jsPDF('landscape');

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
    //var img = new Image();
    doc.setFontSize(12);
    doc.text(documento_titulo, 15, 10);
    doc.setFontSize(12);
    //doc.text(img[0], 150, 10);
    //img.src = '/asstes/img/bg1.jpg';
    //doc.addImage(img, 'jpg', 10, 50);
    doc.autoTable( 
        //styles: { fillColor: [255, 0, 0] },
        //tableWidth: 'auto',
        //columnStyles: { 0: { halign: 'center' } }, // Cells in first column centered and green
        //margin: { top: 10 },
        e, 
        body 
    );
    

    // Simple html example
    //doc.autoTable({head: head, body: '#datosLista'});

    doc.save(documento_titulo+'.pdf');
}