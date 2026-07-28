/*=============================================
EDITAR CLIENTE EFECTIVO
=============================================*/

$(".tablas").on("click", ".btnEditarClientePagos", function () {

    var idCliente = $(this).attr("idCliente");
    var datos = new FormData();

    datos.append("idCliente", idCliente);

    $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
        success: function (respuesta) {

          console.log(respuesta)
                  
            $("#idCliente2").val(respuesta["id"]);
            $("#editarCliente2").val(respuesta["nombre"]);
            $("#editarDocumentoId2").val(respuesta["documento"]);
            $("#editarCompras2").val(respuesta["compras"]);
            $("#editarAmortizacion2").val(respuesta["amortizacion"]);
            $("#editarSaldo2").val(respuesta["saldo"]);
            $("#editarAfavor2").val(respuesta["afavor"]);
            $("#editarAfavorantiguo2").val(respuesta["afavor"]);
           // $("#nuevoVendedor").val(respuesta["caja"]);
      }
    })
})



////////CALCULAR EL MONTO QUE INGRESA
$("#editarNuevaAmortizacion22").change(function(){
  $("#editarAfavor2").val(0);    

  $(this).val();
  var saldopendiente=Number(document.querySelector("#editarSaldo2").value); 
  var afavoranterior=Number(document.querySelector("#editarAfavorantiguo2").value); 
  var validaraperturacaja=(document.querySelector("#estadocajapagos").value); 

  console.log("oli")
  console.log(saldopendiente)

  nueva=$(this).val();
  var convertirade=   $(this).val();
    var convertiradecimal=  convertirade.replace(/\B(?=(\d{3})+(?!\d))/g, ",");


  $("#montoqueingresaraes").val("S/. " +convertiradecimal);    

  if(Math.floor(nueva) > Math.floor(saldopendiente) ){
    //   $("#editarNuevaAmortizacion").val(0);    
      //  $(this).val(0);    
      var sobrante = nueva - saldopendiente + afavoranterior;

      var nuevo= saldopendiente;
      
      $(this).val(nuevo);    

      $("#editarAfavor2").val(sobrante);    


      Swal.fire({
          title: "La cantidad supera el saldo, tendra monto a favor ",
          type: "error",
          timer: 2000,
    timerProgressBar: true,
          confirmButtonText: "¡Cerrar!"
                        
          });

  }


  if(validaraperturacaja == "desactivo" ){
      console.log("desactivado")


      Swal.fire({
          title: "Aperture caja",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        }).then(function(result){
          if (result.value) {

          window.location = "cajas";

          }
      
                              
      });

  }else{
      console.log("activo")

  }

})





$("#editarNuevaAmortizacion2").change(function(){
  $("#editarAfavor2").val(0);    

  $(this).val();
  var montoactualcliente=Number(document.querySelector("#editarSaldo2").value); 
  var afavoranterior=Number(document.querySelector("#editarAfavorantiguo2").value); 
  var validaraperturacaja=(document.querySelector("#estadocajapagos").value); 


  //convertir a decimal el monto ingresado 
  var convertirade=   $(this).val();
  var convertiradecimal=  convertirade.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  $("#montoqueingresaraes").val("S/. " +convertiradecimal);    
  
  var calculofinales=0;
  
    if(Number(montoactualcliente) > 0 ){
      //debe
        calculofinales = Number(montoactualcliente) - Number(convertirade);

      
    }
  

    if( 0 > Math.floor(calculofinales) ){
        //afavor
          calculofinales = Number(montoactualcliente) - Number(convertirade);

    }
  
 
    if( 0 === Math.floor(calculofinales) ){
        //sin deuda
          calculofinales = Number(montoactualcliente) - Number(convertirade);

    }
  


  //var calculofinales = Number(montoactualcliente) + Number(convertirade);



  if(Math.floor(calculofinales) > 0 ){

    $("#calculofinal").val(" SALDO S/. " +calculofinales);    

  }else{
      if( 0 > Math.floor(calculofinales) ){

     $("#calculofinal").val("A FAVOR S/. " +calculofinales);    

      }else{
        if( 0 === Math.floor(calculofinales) ){

          $("#calculofinal").val(" S/. "+calculofinales);    

        }else{
          Swal.fire({
            title: "Monto incorrecto!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
          }).then(function(result){
            if (result.value) {
  
  
            }
        
                                
        });

        }
      }

  }

  
  if(   $(this).val() == 0  ){

    $("#editarNuevaAmortizacion2").val("");    

  }





})









$("#editarNuevaObservacion2").change(function(){
  
   var amortizacion=Number(document.querySelector("#editarNuevaAmortizacion2").value); 
   

  if(amortizacion == 0){
    $("#editarNuevaAmortizacion2").val("");    


  }

  

    
 })
 
 
 
 
 
 
 






 /*========PARA BANCOS========================
EDITAR CLIENTE BANCOS AGREGAR PAGOS A LOS
=============================================*/
$(".tablas").on("click", ".btnEditarClientePagosbancos", function () {

  var idCliente = $(this).attr("idCliente");
  var datos = new FormData();

  datos.append("idCliente", idCliente);

  $.ajax({
    url:"ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
      success: function (respuesta) {

        console.log(respuesta)
                
          $("#idCliente2bancos").val(respuesta["id"]);
          $("#editarCliente2bancos").val(respuesta["nombre"]);
          $("#editarDocumentoId2bancos").val(respuesta["documento"]);
          $("#editarCompras2bancos").val(respuesta["compras"]);
          $("#editarAmortizacion2bancos").val(respuesta["amortizacion"]);
          $("#editarSaldo2bancos").val(respuesta["saldo"]);
          $("#editarAfavor2bancos").val(respuesta["afavor"]);
          $("#editarAfavorantiguo2bancos").val(respuesta["afavor"]);
         // $("#nuevoVendedor").val(respuesta["caja"]);
    }
  })
})



////////CALCULAR EL MONTO QUE INGRESA para banco
$("#editarNuevaAmortizacion2bancos").change(function(){
  $("#editarAfavor2").val(0);    

  $(this).val();
  var montoactualcliente=Number(document.querySelector("#editarSaldo2bancos").value); 


  //convertir a decimal el monto ingresado 
  var convertirade=   $(this).val();
  var convertiradecimal=  convertirade.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  $("#montoqueingresaraesbancos").val("S/. " +convertiradecimal);    
  




var calculofinales=0;
  
    if(Number(montoactualcliente) > 0 ){
      //debe
        calculofinales = Number(montoactualcliente) - Number(convertirade);

      
    }
  

    if( 0 > Math.floor(calculofinales) ){
        //afavor
          calculofinales = Number(montoactualcliente) - Number(convertirade);

    }
  
 
    if( 0 === Math.floor(calculofinales) ){
        //sin deuda
          calculofinales = Number(montoactualcliente) - Number(convertirade);

    }







  if(Math.floor(calculofinales) > 0 ){

    $("#calculofinalbanco").val(" SALDO S/. " +calculofinales);    

  }else{
      if( 0 > Math.floor(calculofinales) ){

     $("#calculofinalbanco").val("A FAVOR S/. " +calculofinales);    

      }else{
        if( 0 == Math.floor(calculofinales) ){

          $("#calculofinalbanco").val(" S/."+calculofinales);    

        }else{
          Swal.fire({
            title: "Monto incorrecto!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
          }).then(function(result){
            if (result.value) {
  
  
            }
        
                                
        });

        }
      }

  }

  
  if(   $(this).val() == 0  ){

    $("#editarNuevaAmortizacion2bancos").val("");    

  }





})




$("#editarNuevaObservacion2bancos").change(function(){
  
  var amortizacion=Number(document.querySelector("#editarNuevaAmortizacion2bancos").value); 
  

 if(amortizacion == 0){
   $("#editarNuevaAmortizacion2bancos").val("");    


 }
   
})




/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFactura", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	window.open("extensiones/examples/reportepagosclientes.php?id="+codigoVenta, "_blank"); 

})



$(".tablas").on("click", ".btnImprimir23Factura", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	window.open("extensiones/examples/reportepagos23clientes.php?id="+codigoVenta, "_blank"); 

})




/*=============================================
IMPRIMIR Ticket de pago
=============================================*/

$(".tablas").on("click", ".btnImprimirTicket", function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/examples/ticket.php?id="+codigoVenta, "_blank"); 

})




/*=============================================
BORRAR pagos
=============================================*/

$(".tablas").on("click", ".btnEliminarPagos", function(){

  var idVenta = $(this).attr("idVentas");

    console.log(idVenta)

  Swal.fire({
        title: '¿Está seguro de borrar el pago?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar pago!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=eliminarpagos&idVenta="+idVenta;
        }

  })

})