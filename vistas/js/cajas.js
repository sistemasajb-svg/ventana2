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