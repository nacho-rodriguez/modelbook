<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
	<div class="panel panel-default panel-properties">
	<ul class="nav nav-tabs nav-justified" id="sellerstab" role="tablist">
	    <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"> 1) Información del cliente.</a></li>
	    <li role="presentation" ><a href="#preciosycomisiones" aria-controls="preciosycomisiones" role="tab" data-toggle="tab"> 2) Reservas realizadas por el cliente.</a></li>
	</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="info">
			    <!--label id="idCliente" style="display: none;"><?php if (isset($idCliente)) {echo $idCliente; } ?></label-->

			    <form id="formNuevoCliente" action="<?php echo base_url('admin/clients/updateclient'); ?>" method="post">
			        <div class="row">
			            <input id="idCliente" style="display: none;" name="idCliente" type="text" value="<?php echo $idCliente; ?>">

			            <div class="form-group col-lg-2 col-md-2">
			                <label for="DNI">DNI</label>
			                <div class="input-group">
			                    <input name="DNI" id="DNI" class="form-control" required="required" type="text" placeholder="DNI" value="<?php echo $client->dni; ?>">
			                </div>
			            </div>


			            <div class="form-group col-lg-2 col-md-2">
			                <label for="Nombre">Nombre</label>

			                <div class="input-group">
			                    <input name="Nombre" class="form-control" required="required" type="text"
			                           placeholder="Nombre" value="<?php echo $client->nombre; ?>">
			                </div>
			            </div>
			            <div class="form-group col-lg-3 col-md-3">
			                <label for="Apellidos">Apellidos</label>

			                <div class="input-group">
			                    <input name="Apellidos" class="form-control" required="required" type="text" placeholder="Apellidos" value="<?php echo $client->apellidos; ?>">
			                </div>
			            </div>

			            <div class="form-group col-lg-3 col-md-3">
			                <label for="fecha_nacimiento">Fecha de nacimiento</label>

			                <div class="input-group">
			                    <input name="fecha_nacimiento" class="form-control" required="required" type="date" placeholder="Fecha de nacimiento" value="<?php echo $client->fecha_nacimiento; ?>">
			                </div>
			            </div>


			            <div class="form-group col-lg-2 col-md-2">
			                <label for="telefono">Teléfono</label>

			                <div class="input-group">
			                    <input name="telefono" class="form-control" type="text" placeholder="Teléfono" value="<?php echo $client->telefono; ?>">
			                </div>
			            </div>
				        <div class="form-group col-lg-3 col-md-3">
				            <label for="Email">Email</label>
				            <div class="input-group">
				                <input name="Email" class="form-control" type="email" placeholder="Email" value="<?php echo $client->email; ?>">
				            </div>
				        </div>
				        <div class="form-group col-lg-12 col-md-12">
				            <input style="margin-left: 5px; margin-bottom: 5px;" type="submit" name="submit" class="btn btn-primary btn-lg" value="Actualizar cliente" >
				            </input>
				        </div>
			        </div>
			    </form>

			</div>
			<div role="tabpanel" class="tab-pane" id="preciosycomisiones">
			    <form id="formBookingListClient" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>" method="post">
			        <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateBookingClient">
			            <thead>
			            <tr>
			                <th data-sortable="true">Fecha reserva</th>
			                <th data-sortable="true">Nº de ticket</th>
			                <th data-sortable="true">Año</th>
			                <th data-sortable="true">Servicio</th>
			                <th data-sortable="true">Tipo de servicio</th>
			                <th data-sortable="true">Estado</th>
			                <th data-events="operateBookingClient">Acción</th>
			            </tr>
			            </thead>
			            <tbody>
			                <?php if (is_array($clientBooking)) {
			                    foreach ($clientBooking as $reservas) { ?>
			                        <tr>
			                            <td data-booking="<?php echo $reservas->id_reserva ?>"><?php echo date_format(date_create($reservas->fecha_reserva), 'd/m/Y'); ?></td>
			                            <td><?php echo $reservas->numero_billete ?></td>
			                            <td><?php echo $reservas->reservas_year ?></td>
			                            <td><?php echo $reservas->nombre ?></td>
			                            <td><?php echo $reservas->tipo_servicio; ?></td>
			                            <td><?php $status = $reservas->estado_reserva;
			                            switch ($status) {
			                            case 0: echo 'No confirmada';
			                                break;
			                            case 1: echo 'Confirmada';
			                                break;
										case 2: echo 'Anulada';
											break;
			                            } ?></td>
			                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva"> </td>
			                        </tr>
			                    <?php }
			                } ?>
			            </tbody>
			        </table>
			    </form>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
