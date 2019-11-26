/*
*   PRINT GENERAL FUNCIONS
*/

function printTable($params) {

    var tab = document.getElementById('datatable1');
    var win = window.open('', '', 'height=700,width=1000');
    win.document.write(tab.outerHTML);
    win.document.close();
    win.print();

}