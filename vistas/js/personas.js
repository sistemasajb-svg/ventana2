/*=============================================
EDITAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEditarPersona", function () {

  var idPersona = $(this).attr("idPersona");

  

  var datos = new FormData();

  datos.append("idPersona", idPersona);

  $.ajax({
    url:"ajax/personas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
      success: function (respuesta) {

        console.log(respuesta)
                 
          $("#idPersona").val(respuesta["id"]);
          $("#editarPersonaeditar").val(respuesta["nombre"]);
          $("#editarDocumentoIdeditar").val(respuesta["documento"]);
          $("#editarEmaileditar").val(respuesta["email"]);
          $("#editarTelefonoeditar").val(respuesta["telefono"]);
          $("#editarDireccioneditar").val(respuesta["direccion"]);
          $("#nuevaFechaCreacioneditar").val(respuesta["fechacreacion"]);

    }






  })
  




})