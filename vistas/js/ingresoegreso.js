/*=============================================
IMPRIMIR Ticket
=============================================*/

$(".tablas").on("click", ".btnImprimirTicketcaja", function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/examples/ticketcaja.php?id="+codigoVenta, "_blank"); 

})





/*=============================================
VALIDAMOS DETALLE PRINCIPAL  ingreso
=============================================*/


$("#ingresomontoingreso").change(function(){
  
	var validaraperturacaja=(document.querySelector("#estadocaja").value); 
  
	  //$("#editarAfavor2").val(sobrante);    
  
	$(this).val();
	
	  var convertirade=   $(this).val();
	  var convertiradecimal=  convertirade.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  
  
	console.log("validando ingreso si esta activo")
	console.log(validaraperturacaja);
  
	var montocajaingreso=(document.querySelector("#montocajaingreso").value); 
  
	
	if(0 >= $(this).val()){
  
		Swal.fire({
		  title: "Monto incorrecto!",
		  type: "error",
		  confirmButtonText: "¡Cerrar!"
		}).then(function(result){
		  if (result.value) {
  
  
		  }
	  
							  
		});
  
	}else{
  
  
	
	  
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
	  }
  
	
  
  
  
  
	  var montorealdecaja=(document.querySelector("#montocajaingreso").value); 
  
	  cajamasingreso =Number(montorealdecaja)  + Number($(this).val()); 
  
		$("#nuevomontoactualdecaja").val(cajamasingreso);
  
  
  
		if(Number(cajamasingreso) > 0 ){
		  console.log($(this).val());
	
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
	
  
  
  
  
	  if(cajamasingreso == null){
  
			console.log("NAN NAN NAN"+ cajamasingreso)
  
	  }
  
	  $("#montodecimal").val("S/. " +convertiradecimal);
  
	 
  })
  
  
  
  $("#detalleprincipalingreso").change(function(){
	
	var validaraperturacaja=(document.querySelector("#estadocaja").value); 
  
	//$("#editarAfavor2").val(sobrante);    
  
	$(this).val();
  
	console.log("oli")
	console.log(validaraperturacaja);
  
	
  
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







/*=============================================
VALIDAMOS DETALLE PRINCIPAL  EGRESO
=============================================*/


$("#ingresoMontosegreso").change(function(){
  
	var validaraperturacajaegreso=(document.querySelector("#estadocajaegreso").value); 
  
  
	$(this).val();
  
	console.log("egreso  aaaaaaaaaaaaa")
	console.log(validaraperturacajaegreso);
  
   // var montocajaingreso=(document.querySelector("#montocajaingreso").value); 
   var convertirade=   $(this).val();
	  var convertiradecimal=  convertirade.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  
	
	
	if(0 >= $(this).val()){
  
		Swal.fire({
		  title: "Monto incorrecto!",
		  type: "error",
		  confirmButtonText: "¡Cerrar!"
		}).then(function(result){
		  if (result.value) {
  
  
		  }
	  
							  
		});
  
	}else{
  
  
	
	  
	  if(validaraperturacajaegreso == "desactivo" ){
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
		console.log("activo   la apertura")
  
	  }
	}
  
	
  
  
  
  
	  var montorealdecajaegreso=(document.querySelector("#montocajaegreso").value); 
  
  
  
	  if(montorealdecajaegreso == 0){
		$(this).val("0");
  
	  }else{
  
  
		if(Number($(this).val())  > Number(montorealdecajaegreso) ){
		  Swal.fire({
			title: "Monto no disponible en caja!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		  }).then(function(result){
			
		  })
		  $(this).val("0");
  
		}else{
  
  
		var restacajaconmontoreal =Number(montorealdecajaegreso) - Number($(this).val()); 
		console.log(restacajaconmontoreal)
		console.log(restacajaconmontoreal)
  
  
		$("#nuevomontoactualdecajasalida").val(restacajaconmontoreal);
  
  
		}
  
	  }
  
  
  
	  
	  if(Number(restacajaconmontoreal) >= 0 ){
		console.log($(this).val());
  
	  }else{
		Swal.fire({
		  title: "Monto incorrecto...!",
		  type: "error",
		  confirmButtonText: "¡Cerrar!"
		}).then(function(result){
		  if (result.value) {
  
  
		  }
	  
							  
	  });
  
	  }
  
  
	  $("#montodecimal2").val("S/. " +convertiradecimal);
  
	 
})
  
 

/*=============================================
BORRAR INGRESPS EGRESOS
=============================================*/

$(".tablas").on("click", ".btnEliminaringresosegresos", function(){

    var idVenta = $(this).attr("idVentas");
  
      console.log(idVenta)
  
    Swal.fire({
          icon: 'question',
          title: '¿Está seguro de borrar?',
          text: "¡Si no lo está puede cancelar la accíón!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, borrar!',
          timer: 5000,
          timerProgressBar: true
        }).then(function(result){
          if (result.value) {
            
              window.location = "index.php?ruta=eliminaringresosegresos&idVenta="+idVenta;
          }
  
    })
  
 })
