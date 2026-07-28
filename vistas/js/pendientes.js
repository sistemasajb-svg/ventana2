/*=============================================
EDITAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEditarPendienteegreso", function () {

  var idPendiente = $(this).attr("idPendiente2");

  console.log("qwewqeqweqweq")
  console.log(idPendiente)
  

  var datos = new FormData();

  datos.append("idPendiente", idPendiente);

  $.ajax({
    url:"ajax/pendientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
      success: function (respuesta) {

        console.log("qwewqeqweqweq")
        console.log(respuesta["id"])
        

        
          $("#idPendienteegreso").val(respuesta["id"]);
          $("#idegreso").val(respuesta["id"]);
          $("#editarTipopendienteegreso").val(respuesta["tipo"]);
          $("#editarIngresoMontopendienteegreso").val(respuesta["ingreso"]);
          $("#editarsalidaMontopendienteegreso").val(respuesta["salida"]);
          $("#editardetalleprincipalegreso").val(respuesta["detalleprincipal"]);
          $("#editardetallesegundoegreso").val(respuesta["detalle"]);
          $("#editardniclienteegreso").val(respuesta["dni"]);
          $("#editarnombreclienteegreso").val(respuesta["cliente"]);
         // $("#editarEmail").val(respuesta["email"]);
         // $("#editarTelefono").val(respuesta["telefono"]);
         // $("#editarDireccion").val(respuesta["direccion"]);
        //  $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);


        


    }






  })
  




})


/*=============================================
EDITAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEditarPendiente", function () {

    var idPendiente = $(this).attr("idPendiente");

    

    var datos = new FormData();

    datos.append("idPendiente", idPendiente);

    $.ajax({
      url:"ajax/pendientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
        success: function (respuesta) {

          console.log(respuesta)
          

          
            $("#idPendiente").val(respuesta["id"]);
            $("#id").val(respuesta["id"]);
            $("#editarTipopendiente").val(respuesta["tipo"]);
            $("#editarIngresoMontopendiente").val(respuesta["ingreso"]);
            $("#editarsalidaMontopendiente").val(respuesta["salida"]);
            $("#editardetalleprincipal").val(respuesta["detalleprincipal"]);
            $("#editardetallesegundo").val(respuesta["detalle"]);
            $("#editardnicliente").val(respuesta["dni"]);
            $("#editarnombrecliente").val(respuesta["cliente"]);
           // $("#editarEmail").val(respuesta["email"]);
           // $("#editarTelefono").val(respuesta["telefono"]);
           // $("#editarDireccion").val(respuesta["direccion"]);
          //  $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);


          


      }






    })
    




})

/*=============================================
ELIMINAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEliminarPendiente", function () {

  var idPendiente = $(this).attr("idPendiente");

      Swal.fire({
            title: '¿Está seguro de borrar el pendiente?',
             icon: 'success',
            }).then((result) => {


                window.location = "index.php?ruta=pendientes&idPendiente=" + idPendiente;


            })


  




})









$("#cantidadingresopendienteagregar").change(function(){
  
  var ingreso=(document.querySelector("#editarIngresoMontopendiente").value); 
  var egreso=(document.querySelector("#editarsalidaMontopendiente").value); 
  var montoqueingreso=$(this).val();

        

    if(Number(montoqueingreso) > Number(egreso)){
        console.log("ingreso es mayor que egreso!!!")
        $(this).val("");
            
    }else{
      
        console.log("1111")
        console.log("EGRESO"+egreso)
        console.log("ESCRIBIO"+montoqueingreso)

    }
    
    //$("#editarAfavor2").val(sobrante);    

    // $(this).val();

    //console.log(validaraperturacaja);

  

   
})


$("#cantidadingresopendienteagregaregreso").change(function(){
  
  var ingreso=(document.querySelector("#editarIngresoMontopendienteegreso").value); 
  var egreso=(document.querySelector("#editarsalidaMontopendienteegreso").value); 
  var montoqueingreso=$(this).val();

      

    if(Number(montoqueingreso) > Number(egreso)){
        console.log("ingreso es mayor que egreso!!!")
        $(this).val("");
    }else{
        console.log("1111")
        console.log("EGRESO"+egreso)
        console.log("ESCRIBIO"+montoqueingreso)
    }
    
    //$("#editarAfavor2").val(sobrante);    

    // $(this).val();

    //console.log(validaraperturacaja);

  

   
})











