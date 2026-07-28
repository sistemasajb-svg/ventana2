/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFacturaFinal", function(){


    var codigoVenta = $(this).attr("codigoVenta");
  
    window.open("extensiones/examples/reporteventafinal.php?codigo="+codigoVenta, "_blank");
  
  
  })