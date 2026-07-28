/*=============================================
ACTIVAR USUARIO
=============================================*/

$(".tablas").on("click", ".btnActivarcajas", function () {


    var idCaja = $(this).attr("idCaja");
    var estadoCaja = $(this).attr("estadoCaja");

    var datos = new FormData();

    datos.append("activarId", idCaja);
  	datos.append("activarCaja", estadoCaja);

    $.ajax({

	  url:"ajax/cajas.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
 
      }

  	})

 


        if(estadoCaja == "desactivo"){

            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).html('desactivado');
            $(this).attr('estadoCaja', "desactivo");



        }else{
            if(estadoCaja == "activo"){

                $(this).addClass('btn-success');
                $(this).removeClass('btn-danger');
                $(this).html('Activado');
                $(this).attr('estadoCaja', "desactivo");



            }   

        }

})




/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFacturacaja", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	window.open("extensiones/examples/cajarpt.php?id="+codigoVenta, "_blank"); 

})

$(".tablas").on("click", ".btnImprimirNewFacturacaja", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	window.open("extensiones/examples/caja.php?id="+codigoVenta, "_blank"); 

})

$(".tablas").on("click", ".btnImprimirNewaFacturacaja", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	window.open("extensiones/examples/cajaa5.php?id="+codigoVenta, "_blank"); 

})




$(document).ready(function() {
    var table = $('#tablas2').DataTable( {
        fixedHeader: true,
        "language":{
                    "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %d fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "1": "Mostrar 1 fila",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d"
                },
                "select": {
                    "1": "%d fila seleccionada",
                    "_": "%d filas seleccionadas",
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "$d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "am",
                        "pm"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"
            } ,
            //para usar los botones   
            responsive: "true",
            dom: 'Bfrtilp',       
            buttons:[ 
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success'
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend:    'print',
                    text:      '<i class="fa fa-print"></i> ',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-info'
                },
            ]	   
  
  
        }
        
        
         );
} );





/////////MENU///////////
function btn_menu(element) {

    habilitar_menu();

    // Convierte el elemento pasado a un objeto jQuery
    var container2 = $(element).closest('.container2');
    // Verifica que container2 sea un objeto jQuery
    if (container2.length === 0) {
        console.error("El elemento .container2 no fue encontrado.");
        return;
    }

    // Oculta todos los submenús excepto el de la fila actual
    $('.submenu').not(container2.find('.submenu')).hide();

    // Selecciona el submenú dentro de la fila en la que se hizo clic
    var submenu = container2.find('.submenu');

    // Si el submenú actual está visible, lo oculta; de lo contrario, lo muestra
    if (submenu.is(':visible')) {
        submenu.hide();
    } else {
        // Calcula la posición del submenú
        var triggerOffset = $(element).offset();
        var submenuHeight = submenu.outerHeight();
        var windowHeight = $(window).height();

        // Si no hay suficiente espacio debajo del disparador, muestra el submenú encima del disparador
        if ((triggerOffset.top + submenuHeight + 100) > windowHeight) {
            submenu.css({
                top: 'auto',
                bottom: '100%'
            });
        } else {
            submenu.css({
                top: '100%',
                bottom: 'auto'
            });
        }

        submenu.show();
    }

}

function habilitar_menu() {
    // Oculta el menú cuando se hace clic en cualquier parte del documento, excepto en el menú o el disparador
    $(document).click(function (event) {
        if (!$(event.target).closest('.container2').length) {
            $('.submenu').hide();
        }
    });
}










