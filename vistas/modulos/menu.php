<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo $_SESSION["foto"]; ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php echo $_SESSION["nombre"]; ?></p>
				<a href="inicio"><i class="fa fa-circle text-success"></i> enlinea</a>

				<div class="popup" onclick="myFunction()"><i class="fa fa-bell-o" aria-hidden="true"></i>
					<span class="popuptext" id="myPopup">Próximamente Msj.Alert</span>
				</div>
			</div>
		</div>

		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">menu de navegacion</li>
			<li>
				<a href="inicio">
					<i class="fa fa-th"></i> <span>inicio</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>


			<li>
				<a href="pagosmasivos">
					<i class="fa fa-money"></i> <span>Pago Masivo</span>
					<span class="pull-right-container">
						<small class="label pull-right bg-green ">Masivo</small>
					</span>
				</a>
			</li>



			<?php
            if ($_SESSION['perfil'] != "Masiva") {
                echo '   
                     
                	<li>
				<a href="cajas">
					<i class="fa fa-archive"></i> <span>Aperturar/Cerra Caja</span>
					<span class="pull-right-container">
						<small class="label pull-right bg-yellow"><i class="fa fa-clock-o" aria-hidden="true"></i></small>
					</span>
				</a>
			</li>


			<li class="header">Pagos de Huevos </li>
	<li hidden>
				<a href="usuarios">
					<i class="fa fa-th"></i> <span>usuarios</span>
					<span class="pull-right-container">
						<small class="label pull-right bg-green">Hot</small>
					</span>
				</a>
			</li>



			<li class="treeview">
				<a href="#">
					<i class="fa fa-retweet"></i> <span>Pagos Clientes Huevos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="pagos"><i class="fa fa-circle-o"></i>Pagos Clientes</a></li>
					<li><a href="historialpagos"><i class="fa fa-circle-o"></i>Pagos del dia</a></li>
				</ul>
			</li>

		


                
                    ';
            }
            ?>




			<?php
			if ($_SESSION['perfil'] != "Caja2") {
				echo '   
                      
					<li>
				<a href="listadoventasterminadas">
					<i class="fa fa-file-pdf-o"></i> <span>Venta Huevos</span>
					<span class="pull-right-container">
						<small class="label pull-right bg-green"><i aria-hidden="true"> Ventas</i></small>
					</span>
				</a>
			</li>

                    ';
			}
			?>





		

			<?php
			if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador") {
				echo '   
                        <li >
                        <a href="eliminarpagos">
                            <i class="fa fa-trash" style="color:red"></i> <span>Eliminar Pagos</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                        </li>
                    ';
			}
			?>



<?php
            if ($_SESSION['perfil'] != "Masiva") {
                echo '   
                     
                
	<li class="header">Caja Personas</li>


			<li>
				<a href="personas">
					<i class="fa fa-users"></i> <span>Personas</span>
					<span class="pull-right-container">
						<small class="label pull-right bg-green"><i class="fa fa-user" aria-hidden="true"></i></small>
					</span>
				</a>
			</li>



			<li>
				<a href="ingresoegreso">
					<i class="fa fa-desktop"></i> <span>Ingreso / Egreso</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>

                
                    ';
            }
            ?>


		




			<?php
			if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador") {
				echo '   
                        <li >
                        <a href="eliminaringresosegresos">
                            <i class="fa fa-trash" style="color:red"></i> <span>Eliminar Ingreso|Egreso</span>
                            <span class="pull-right-container">
                                <small class="label pull-right bg-green"><i  aria-hidden="true"> New</i></small>
                            </span>
                        </a>
                        </li>
                    ';
			}
			?>




<?php
            if ($_SESSION['perfil'] != "Masiva") {
                echo '   
                     
                
	<li>
				<a href="pendientes">
					<i class="fa fa-bell"></i> <span>Cerrar pendientes</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>


			<li class="header"></li>




			<li class="treeview">
				<a href="#">
					<i class="fa fa-share"></i> <span>Reportes Generales</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li><a target="_blank" href="https://reporte1.avicolajb.com"><i class="fa fa-circle-o"></i>IR A REPORTES</a></li>
				</ul>
			</li>

                
                    ';
            }
            ?>

		




		</ul>
	</section>
	<!-- /.sidebar -->
</aside>


<script>
	// When the user clicks on <div>, open the popup
	function myFunction() {
		var popup = document.getElementById("myPopup");
		popup.classList.toggle("show");
	}
</script>


<style>
	/* Popup container */
	.popup {
		position: relative;
		display: inline-block;
		cursor: pointer;
	}

	/* The actual popup (appears on top) */
	.popup .popuptext {
		visibility: hidden;
		width: 160px;
		background-color: #555;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 8px 0;
		position: absolute;
		z-index: 1;
		bottom: 125%;
		left: 50%;
		margin-left: -80px;
	}

	/* Popup arrow */
	.popup .popuptext::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -5px;
		border-width: 5px;
		border-style: solid;
		border-color: #555 transparent transparent transparent;
	}

	/* Toggle this class when clicking on the popup container (hide and show the popup) */
	.popup .show {
		visibility: visible;
		-webkit-animation: fadeIn 1s;
		animation: fadeIn 1s
	}

	/* Add animation (fade in the popup) */
	@-webkit-keyframes fadeIn {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}

	@keyframes fadeIn {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}
</style>