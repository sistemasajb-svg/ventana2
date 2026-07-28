<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pagos Masivos
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>
            <li class="active">Masivas</li>
        </ol>
    </section>


    <script>
        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
    </script>



    <section class="content">
        <div class="box">
            <div class="box-body" style="overflow-y: scroll;">

                <div class="col-lg-6 col-xs-12" style="border-right: 1px solid #ccc; padding-right: 15px;">
                    <form role="form" method="post" class="formularioPagar">

                        <div class="box-body">

                            <div class="col-lg-12 col-xs-6">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i> Cajero/Cajera</span>
                                            <input type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                                            <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-file-code-o"></i> Cod. Masivo</span>
                                            <?php
                                            $codigomasivo = ControladorPagoMasivo::ctrcodigomasivo();
                                            echo '<input value="' . $codigomasivo . '" type="text" class="form-control" id="idabuscar" name="idabuscar" placeholder="Codigo por dia" readonly>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <br />
                            </div>



                            <div class="col-lg-12 col-xs-6">
                                <select class="form-control mi-selector" style="width:100%" id="selectcliente" name="selectcliente" required onchange="actualizarSaldoAnterior()">
                                    <option value="0">Seleccionar Cliente Trabajador</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $clientes = ControladorPagoMasivo::ctrMostrarClientes();
                                    foreach ($clientes as $key => $value) {
                                        echo '<option value="' . $value["documento"] . '" data-saldo="' . $value["saldo"] . '">' . $value["nombre"] . ' - ' . $value["documento"] . ' - Saldo: ' . $value["saldo"] . '</option>';
                                    }
                                    ?>
                                </select>

                                <br><br><br>



                                <script>
                                    function actualizarSaldoAnterior() {
                                        var selectCliente = document.getElementById("selectcliente");
                                        var saldoAnteriorInput = document.getElementById("addsaldoanterior");
                                        var addpagoInput = document.getElementById("addpago");
                                        var addsaldonuevoInput = document.getElementById("addsaldonuevo");
                                        var saldo = selectCliente.options[selectCliente.selectedIndex].getAttribute("data-saldo");
                                        saldoAnteriorInput.value = saldo;
                                        addpagoInput.value = "";
                                        addsaldonuevoInput.value = "";
                                    }
                                </script>


                            </div>

                            <br></br>

                            <br></br><br>

                            <div class="col-lg-4 col-xs-4">
                                <h4 style="text-align: center; font-weight: bold;">Saldo Ant.</h4>
                                <input type="text" class="form-control" id="addsaldoanterior" name="addsaldoanterior" placeholder="0.0" readonly style="font-weight: bold; text-align: center;">
                            </div>

                            <div class="col-lg-4 col-xs-4">
                                <h4 style="text-align: center; font-weight: bold;">Pago</h4>
                                <input type="text" class="form-control" id="addpago" name="addpago" placeholder="0.0">
                            </div>

                            <div class="col-lg-4 col-xs-4">
                                <h4 style="text-align: center; font-weight: bold;">Saldo Nuevo</h4>
                                <input type="text" class="form-control" id="addsaldonuevo" name="addsaldonuevo" placeholder="0.0" required readonly style="font-weight: bold; text-align: center;">
                            </div>

                            <script>
                                // Función para calcular el saldo nuevo
                                function calcularSaldoNuevo() {
                                    var saldoAnterior = parseFloat(document.getElementById('addsaldoanterior').value);
                                    var pago = parseFloat(document.getElementById('addpago').value);
                                    var saldoNuevo = saldoAnterior - pago;
                                    document.getElementById('addsaldonuevo').value = saldoNuevo.toFixed(2);
                                }

                                // Asignar el evento onchange al campo de pago
                                document.getElementById('addpago').addEventListener('input', calcularSaldoNuevo);
                            </script>

                            <div class="col-lg-12 col-xs-12">
                                <br>
                                <input type="text" class="form-control" id="addobservacion" name="addobservacion" placeholder="Ingrese Observación">
                            </div>

                            <div class="col-lg-12 col-xs-12" style="text-align: center;">
                                <br>
                                <button class="btn btn-primary" id="btnAgregar" style="color: white; background-color: green;" type="button">Pagar <i class="fa fa-money"></i></button>

                            </div>

                        </div>
                    </form>

                    <script>
                        //mdlRegistrarPagosdeClienteefectivo
                        $(document).ready(function() {
                            $("#btnAgregar").click(function() {
                                var addPagocero = parseFloat($("#addpago").val());
                                console.log("Valor de addPagocero:", addPagocero); // Agrega este console.log para depurar
                                var selectclientecero = parseFloat($("#selectcliente").val());

                                if (addPagocero > 0 && selectclientecero > 1) {
                                    var data = {
                                        nuevoVendedor: $("#nuevoVendedor").val(),
                                        idVendedor: $("input[name='idVendedor']").val(),
                                        selectcliente: $("#selectcliente").val(),
                                        addsaldoanterior: $("#addsaldoanterior").val(),
                                        addpago: addPagocero,
                                        addsaldonuevo: $("#addsaldonuevo").val(),
                                        idabuscar: $("#idabuscar").val(),
                                        addobservacion: $("#addobservacion").val()
                                    };

                                    $.ajax({
                                        url: 'procesar_pago.php',
                                        type: 'POST',
                                        data: data,
                                        success: function(response) {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: "success",
                                                title: "PAGO, Registrado Correctamente"
                                            });

                                            $(".formularioPagar")[0].reset();

                                            // Actualizar el select de clientes después de 3 segundos
                                            setTimeout(actualizarSelectClientes, 3000); // 3000 milisegundos = 3 segundos


                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.error(textStatus, errorThrown);
                                            alert('Ocurrió un error al procesar el pago.');
                                        }
                                    });
                                } else {
                                    let timerInterval;
                                    Swal.fire({
                                        title: "Alerta!",
                                        html: "El monto del pago debe ser mayor a cero y la selección del cliente<b></b> milliseconds.",
                                        timer: 5000,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                            timerInterval = setInterval(() => {
                                                timer.textContent = `${Swal.getTimerLeft()}`;
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        }
                                    }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            console.log("I was closed by the timer");
                                        }
                                    });
                                }
                            });


                             // Función para actualizar el select de clientes
                             function actualizarSelectClientes() {
                                $.ajax({
                                    url: 'actualizadoscliente.php', // URL del script PHP que devuelve los clientes actualizados
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Limpiar y actualizar el select de clientes
                                        $('#selectcliente').empty();
                                        $('#selectcliente').append('<option value="0">Seleccionar Cliente Trabajador</option>');
                                        $.each(data, function(index, cliente) {
                                            $('#selectcliente').append('<option value="' + cliente.documento + '" data-saldo="' + cliente.saldo + '">' + cliente.nombre + ' - ' + cliente.documento + ' - Saldo: ' + cliente.saldo + '</option>');
                                        });
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error('Error al obtener clientes:', errorThrown);
                                    }
                                });
                            }


                        });
                    </script>


                </div>

                <div class="col-lg-6 col-xs-12" style="padding-left: 15px;">



                    <button id="btnActualizarTabla" class="btn btn-primary mt-3">Actualizar Tabla</button>
                    <br>
                    </br>
                    <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas mt-3">

                        <script>
                            $(document).ready(function() {
                                initDataTable('#tablas2');
                            });
                        </script>
                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>CLIENTE</th>
                                <th>CANTIDAD</th>
                                <th>AFAVOR</th>
                                <th>DETALLE</th>
                                <th>FECHA</th>
                                <th>TICKET</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                    <script>
                        document.getElementById('btnActualizarTabla').addEventListener('click', function() {
                            var idabuscar = document.getElementById('idabuscar').value;

                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', 'datos.php?idabuscar=' + idabuscar, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 200) {
                                        var data = JSON.parse(xhr.responseText);
                                        console.log('Data received:', data); // Debugging line
                                        actualizarTabla(data);
                                    } else {
                                        console.error('Error in AJAX request:', xhr.statusText); // Debugging line
                                    }
                                }
                            };
                            xhr.send();
                        });

                        function actualizarTabla(data) {
                            var tabla = document.getElementById('tablas2');
                            var tbody = tabla.querySelector('tbody');
                            tbody.innerHTML = '';

                            data.forEach(function(item, index) {
                                var row = '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + item.cliente + '</td>' +
                                    '<td>' + item.cantidad + '</td>' +
                                    '<td>' + item.afavor + '</td>' +
                                    '<td>' + item.detalle + '</td>' +
                                    '<td>' + item.fecha + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-success btnImprimirTicket" codigoVenta="' + item.id + '">' +
                                    '<i class="fa fa-print">Ticket</i>' +
                                    '</button>' +
                                    '</td>' +
                                    '</tr>';
                                tbody.innerHTML += row;
                            });
                        }
                    </script>




                </div>

            </div>
        </div>
    </section>

</div>