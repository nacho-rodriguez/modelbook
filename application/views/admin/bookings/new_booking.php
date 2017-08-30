<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-lg-offset-9 col-md-offset-9 text-right">
                <form role="form" action="<?php echo base_url('admin/bookings/createallbookingspdf'); ?>" method="post">
                    <input style="display: none;" name="serviceID" id="serviceID" type="text"
                           value="<?php echo $idService; ?>"/>
                    <input style="display: none;" name="nameService" id="nameService" type="text"
                           value="<?php echo $nameService; ?>"/>
                    <input name="submit" id="submit" value="Generar PDF de reservas" class="btn btn-lg btn-primary"
                           type="submit">
                </form>
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
            <li role="presentation" class="active"><a href="#confirmedBooking" aria-controls="confirmedBooking" role="tab" data-toggle="tab">Confirmadas</a></li>
            <li role="presentation"><a href="#nonconfirmedBooking" aria-controls="nonconfirmedBooking" role="tab" data-toggle="tab">No confirmadas</a></li>
            <li role="presentation"><a href="#cancelledBooking" aria-controls="nonconfirmedBooking" role="tab" data-toggle="tab">Anuladas</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="confirmedBooking">
                <form id="formConfirmedBookingList" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>"
                      method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateBookingConfirmedFromSeller">
                        <thead>
                        <tr>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha emisión reserva</th>
                            <th data-sortable="true">Vendedor</th>
                            <th data-sortable="true">Total personas</th>
                            <th data-events="operateBookingConfirmedFromSeller">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($confirmedBooking)) {
                            foreach ($confirmedBooking as $reservas) { ?>
                                <tr>
                                    <td data-booking="<?php echo $reservas->id_reserva ?>"><?php echo $reservas->identificador_reserva; ?></td>
                                    <td><?php echo $reservas->fecha_emision_reserva; ?></td>
                                    <td><?php echo $reservas->nombre_vendedor ?></td>
                                    <td><?php echo $reservas->totalPersonas ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva">
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="nonconfirmedBooking">

                <?php if (is_array($nonConfirmedBooking)) {
                    if (count($nonConfirmedBooking) > 0) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 text-right">
                                <form id="formUpdateBookingNonConfirmed" action="<?php echo base_url('admin/bookings/confirmbooking'); ?>" method="post">
                                    <input style="display: none;" id="rowsSelected" name="bookingSelected" type="text"/>
                                    <input style="display: none;" name="idService" type="text" value="<?php echo $idService; ?>"/>
                                    <input style="display: none;" name="nameService" type="text" value="<?php echo $nameService; ?>"/>
                                </form>
                                <button style="margin-left: 5px; margin-bottom: 5px;" id="confirmBookingNonConfirmed" class="btn btn-warning btn-lg"> Confirmar reservas seleccionadas
                                </button>

                                <button type="button" id="openModal" style="display: none" data-toggle="modal" data-target="#confirmarReservasModal">
                                </button>
                            </div>
                        </div>
                    <?php }
                } ?>
                <form id="formNonConfirmedBookingList" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>"
                      method="post">
                    <table id="tableBookingNonConfirmed" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateBookingNonConfirmedFromSeller">
                        <thead>
                        <tr>
                            <th data-checkbox="true">Check</th>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha emisión reserva</th>
                            <th data-sortable="true">Vendedor</th>
                            <th data-sortable="true">Total personas</th>
                            <th data-events="operateBookingNonConfirmedFromSeller">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($nonConfirmedBooking)) {
                            foreach ($nonConfirmedBooking as $reservasNo) { ?>
                                <tr>
                                    <td></td>
                                    <td data-booking="<?php echo $reservasNo->id_reserva ?>"><?php echo $reservasNo->identificador_reserva; ?></td>
                                    <td><?php echo $reservasNo->fecha_emision_reserva; ?></td>
                                    <td><?php echo $reservasNo->nombre_vendedor ?></td>
                                    <td><?php echo $reservasNo->totalPersonas ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva"></td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="cancelledBooking">

                <form id="cancelledBookingForm" action="<?php echo base_url('admin/bookings/detailsbooking'); ?>"
                      method="post">
                    <table id="tableCancelledBooking"
                           data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
						   class="table table-striped table-hover" data-show-filter="true" data-events="operateCancelledBooking">
                        <thead>
                        <tr>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha emisión reserva</th>
                            <th data-sortable="true">Vendedor</th>
                            <th data-sortable="true">Total personas</th>
                            <th data-events="operateCancelledBooking">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (is_array($cancelledBooking)) {
                            foreach ($cancelledBooking as $reservasNo) { ?>
                                <tr>
                                    <td data-booking="<?php echo $reservasNo->id_reserva ?>"><?php echo $reservasNo->identificador_reserva; ?></td>
                                    <td><?php echo $reservasNo->fecha_emision_reserva; ?></td>
                                    <td><?php echo $reservasNo->nombre_vendedor ?></td>
                                    <td><?php echo $reservasNo->totalPersonas ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva"></td>
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

<!-- Modal -->
<div class="modal fade" id="confirmarReservasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5>¿Está seguro que desea confirmar las reservas seleccionadas?</h5>
            </div>
            <div class="modal-footer">
				<div class="row">
					<div class="col-lg-8 col-md-8" style="text-align: left;">
						<button type="button" class="btn btn-default" style="text-align: left" data-dismiss="modal">Cerrar</button>
					</div>
					<div class="col-lg-4 col-md-4" style="padding-left: 0 !important;">
	                	<button type="button" id="confirmReservasNoConfirmed" class="btn btn-md btn-success">Confirmar reservas</button>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
