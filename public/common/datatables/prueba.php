<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
    <head> 
        <title> Listado x Obra </title> 
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" /> 
        <link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico"> 

        <style type="text/css" title="currentStyle"> 
            @import "examples/resources/demo.css"; 
            @import "media/css/jquery.dataTables.min.css"; 
            @import "media/css/jquery-ui.min.css"; 
            @import "extensions/TableTools/css/dataTables.tableTools.min.css"; 
            @import "extensions/ColVis/css/dataTables.colVis.min.css"; 
        </style> 

        <script type="text/javascript" charset="utf-8" src="media/js/jquery.js"></script> 
        <script type="text/javascript" charset="utf-8" src="media/js/jquery.dataTables.js"></script> 
        <script type="text/javascript" charset="utf-8" src="extensions/TableTools/js/ZeroClipboard.js"></script> 
        <script type="text/javascript" charset="utf-8" src="extensions/TableTools/js/dataTables.TableTools.js"></script> 
        <script type="text/javascript" charset="utf-8" src="extensions/ColVis/js/dataTables.ColVis.js"></script> 
        <script type="text/javascript" charset="utf-8"> 
var asInitVals = new Array(); 

    $(document).ready(function() { 
                    $('#example').dataTable({ 
                       "bJQueryUI": true, 
                    "sPaginationType": "full_numbers", 
                    "sDom": 'T C lfrtip', 
                    "oTableTools": { 
                    "sSwfPath": "/TableTools-2.0.0/media/swfcopy_cvs_xls_pdf.swf", 
                    "aButtons": [ 
                    "xls", 
                    "pdf", 
                    { 
                    "sExtends": "print", 
                    "sButtonText": "Imprimir", 
                    "sInfo": "<br><center><h1>PRESIONAR ESCAPE AL TERMINAR</h1></center>", 
                    "sMessage": "<center><h2><b>TITULO!</b></h2></center>", 
                    "sTitle": "Listado x Obra Social", 
                    } 
                    ], 
                    }, 
                    "fnInitComplete": function () { 
                        var 
                            that = this, 
                            nTrs = this.fnGetNodes(); 
                        $('td', nTrs).click( function () { 
                            that.fnFilter( this.innerHTML ); 
                        } ); 
                    }, 
                    "oLanguage": { 
"oPaginate": { 
"sPrevious": "Anterior", 
"sNext": "Siguiente", 
"sLast": "Ultima", 
"sFirst": "Primera" 
}, 

"sLengthMenu": 'Mostrar <select>'+ 
'<option value="10">10</option>'+ 
'<option value="20">20</option>'+ 
'<option value="30">30</option>'+ 
'<option value="40">40</option>'+ 
'<option value="50">50</option>'+ 
'<option value="-1">Todos</option>'+ 
'</select> registros', 

"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 

"sInfoFiltered": " - filtrados de _MAX_ registros", 

"sInfoEmpty": "No hay resultados de b�squeda", 

"sZeroRecords": "No hay registros a mostrar", 

"sProcessing": "Espere, por favor...", 

"sSearch": "Buscar:", 

} 
                }); 

    $("tfoot input").keyup( function () { 
        /* Filter on the column (the index) of this element */ 
        oTable.fnFilter( this.value, $("tfoot input").index(this) ); 
    } ); 


    /* 
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer 
     */ 
    $("tfoot input").each( function (i) { 
        asInitVals[i] = this.value; 
    } ); 

    $("tfoot input").focus( function () { 
        if ( this.className == "search_init" ) 
        { 
            this.className = ""; 
            this.value = ""; 
        } 
    } ); 

    $("tfoot input").blur( function (i) { 
        if ( this.value == "" ) 
        { 
            this.className = "search_init"; 
            this.value = asInitVals[$("tfoot input").index(this)]; 
        } 
    } ); 
            });  // Termina document.ready 
        </script> 
<style> 
.data_table { 
font-family: helvetica; 
font-size: 1px; 
} 
#top_of_page { 
position: absolute; 
} 
#main_table_area { 
position: absolute; 
top: 20px; 
height: 540px; 
width: 800px; 
overflow: auto; 
} 
</style> 

    </head> 
<?php 
// Arriba est� el c�digo de lo que va en el archivo include a continuaci�n: 
include 'db_connect.php'; 

  $sql = "SELECT * FROM trimestres"; 

  $result = execute_query($sql); 

// Pasa la fecha a espa�ol llamar FechaEsp($row['campo']); 
  function FechaESP ($fecha) { 
if ($fecha != '') { 
$data=explode("-",$fecha); 
$retfecha = substr($data[2],0,2).'/'.$data[1].'/'.$data[0]; 
return $retfecha; 
} else { 
$retfecha = ''; 
} 
} 

?> 

    <body id="dt_example"> 



            <div id="demo"> 
<font size=1> 
<div id="main_table_area"> 
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" class="data_table"> 
    <thead> 
        <tr> 
            <th width="auto">Titulo 1</th> 
            <th width="auto">Titulo 2</th> 
            <th width="auto">Titulo 3</th> 
            <th width="auto">Titulo 4</th> 
            <th width="auto">Titulo 5</th> 
            <th width="auto">Titulo 6</th> 
        </tr> 
    </thead> 
    <tbody> 
     <?php 
       $i = 0; 
       $total = mysql_num_rows($result); 
       while ($row = mysql_fetch_array($result)) { 
           $i++; 
               echo "<tr class='gradeA'> 
            <td width='auto'>".$row[0]."</td> 
            <td width='auto' class='center'>".$row[1]."</td> 
            <td width='auto'>".$row[2]."</td> 
            <td width='auto'>".$row[3]."</td> 
            <td width='auto'>".$row[4]."</td> 
            <td width='auto'>".$row[5]."</td> 
            </tr>"; 
       } 
       echo 'Total: ' . $total; 
      ?> 
    </tbody> 
</table> 
</div> 
</font> 
            </div> 
            <div class="spacer"></div> 
        </div> 
    </body> 
</html>