<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>
<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <form action="<?php echo base_url('admin/closeouts/showemissions'); ?>" method="post">
            <input style="display: none;" type="text" name="idSeller" value="<?php echo $idSeller; ?>">
            <div class="row">
                <div class='col-lg-3 col-md-3 '>
                    <label>Desde (fecha inicio servicio):</label>
                    <div class="input-group">
                        <input class="form-control" name="startDateBegin" type="date" <?php if ($startDateBegin != '') { echo "value='".$startDateBegin."'"; } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Hasta:</label>
                    <div class="input-group">
                        <input class="form-control" name="endDateBegin" type="date" <?php if ($endDateBegin != '') { echo "value='".$endDateBegin."'"; } ?> >
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class='col-lg-3 col-md-3 '>
                    <label>Desde (fecha fin servicio):</label>
                    <div class="input-group">
                        <input class="form-control" name="startDateEnd" type="date" <?php if ($startDateEnd != '') { echo "value='".$startDateEnd."'"; } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Hasta:</label>
                    <div class="input-group">
                        <input class="form-control" name="endDateEnd" type="date" <?php if ($endDateEnd != '') { echo "value='".$endDateEnd."'"; } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Tipo:</label>
                    <div class="input-group">
                        <select class="form-control" name="optionSelected">
                            <option value="1" <?php if ($optionSelected == 1) { echo "selected='selected'"; } ?> >Pendiente de emitir </option>
                            <option value="2" <?php if ($optionSelected == 2) { echo "selected='selected'"; } ?> >Emitida </option>
                        </select>
                    </div>
                </div>

                <div class='col-lg-2 col-md-2 col-lg-offset-1 col-md-offset-1'>
                    <div class="input-group">
                        <input class="btn btn-primary" value="Buscar" name="submit" type="submit">
                    </div>
                </div>
            </div>
        </form>

        <?php if ($optionSelected == 1) {?>
                <div class="col-lg-12 col-md-12 text-right well" style="padding: 24px; margin-top: 40px;">
                    <div class="col-lg-4 col-md-4 text-center">
                        <form id="tableConfirmCloseout" action="<?php echo base_url('admin/closeouts/closeoutemission'); ?>" method="post">
                            <label style="font-weight: bold;">Fecha de emisión</label>
                            <input class="form-control" type="date" name="dateCloseout" id="dateCloseOutSelected">
                            <input style="display: none;" type="text" name="idCliente" value="<?php echo $idSeller; ?>">
                            <input style="display: none;" id="rowsSelected" name="closeoutSelected" type="text"/>
                        </form>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <button style="margin-left: 5px; margin-bottom: 5px;" id="makeLiquidaciones" class="btn btn-warning btn-lg"> Emitir documentos de las reservas seleccionadas</button>
                        <button type="button" id="openModal" style="display:none" data-toggle="modal" data-target="#confirmarGenerarDocumentosLiquidacionModal"> </button>
                    </div>
                </div>
                <form id="formCurrentPaymentsBookingList" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>" target="_blank" method="post">
                    <input style="display: none;" type="text" name="idCliente" value="<?php echo $idSeller; ?>">
                    <input style="display: none;" type="text" name="codeBack" value="2">
                    <table id="tableCurrentPaymentsBookingList" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentCloseoutOnSearch">
                        <thead>
                        <tr>
                            <th data-field="checkbox" data-checkbox="true">CheckList</th>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha reserva</th>
                            <th data-sortable="true">Servicio (Referencia)</th>
                            <th data-sortable="true">Total personas</th>
                            <th data-events="operateCurrentCloseoutOnSearch">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($pendingPaymetsBooking)) {
                            foreach ($pendingPaymetsBooking as $reservas) { ?>
                                <tr>
                                    <td></td>
                                    <td data-booking="<?php echo $reservas->id_reserva ?>">
                                        <?php echo $reservas->identificacion_reserva ?>
                                    </td>
                                    <td><?php echo date_format(date_create($reservas->fecha_reserva), 'd/m/Y, H:i'); ?></td>
                                    <td><?php echo $reservas->servicio_completo ?></td>
                                    <td><?php echo $reservas->totalPersonas; ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva">
                                    </td>
                                </tr>
							<?php }
                        } ?>
                        </tbody>
                    </table>
                </form>
		<?php } else { ?>
            <form id="formCurrentPaymentsBookingList" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>" method="post" target="_blank">
                <input style="display: none;" type="text" name="idCliente" value="<?php echo $idSeller; ?>">
                <input style="display: none;" type="text" name="codeBack" value="2">
                <table id="tableCurrentPaymentsBookingList" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					   class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentCloseoutOnSearch">
                    <thead>
                    <tr>
                        <th data-field="checkbox" data-checkbox="true">CheckList</th>
                        <th data-sortable="true">ID reserva</th>
                        <th data-sortable="true">Fecha reserva</th>
                        <th data-sortable="true">Servicio (Referencia)</th>
                        <th data-sortable="true">Total personas</th>
                        <th data-events="operateCurrentCloseoutOnSearch">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($pastPaymentsBooking)) {
                        foreach ($pastPaymentsBooking as $reservas) { ?>
                            <tr>
                                <td></td>
                                <td data-booking="<?php echo $reservas->id_reserva ?>">
                                    <?php echo $reservas->identificacion_reserva ?>
                                </td>
                                <td><?php echo date_format(date_create($reservas->fecha_reserva), 'd/m/Y, H:i'); ?></td>
                                <td><?php echo $reservas->servicio_completo ?></td>
                                <td><?php echo $reservas->totalPersonas; ?></td>
                                <td><input class="btn btn-success" name="submitTable" type="submit" value="Ver reserva"></td>
                            </tr>
						<?php }
                    } ?>
                    </tbody>
                </table>
            </form>
        <?php
        } ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarGenerarDocumentosLiquidacionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5>¿Está seguro que desea realizar la liquidación de las reservas seleccionadas?</h5>
            </div>
            <div class="modal-body">
                <span>Recuerde que se generará automáticamente un <strong>documento de liquidación</strong> que estará asociado con todas las reservas seleccionadas.</span>
            </div>
            <div class="modal-footer">
				<div class="col-lg-5 col-md-5" style="text-align: left;">
					<button type="button" class="btn btn-default" style="text-align: left" data-dismiss="modal">Cerrar</button>
				</div>
				<div class="col-lg-2 col-md-2" style="padding-left: 0 !important;">
	                <button type="button" id="confirmGenerateDocuments" class="btn btn-md btn-success">Confirmar liquidación de reservas</button>
				</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
