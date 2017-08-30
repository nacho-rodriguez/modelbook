<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>

<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="col-lg-6">
                <form role="form" action="<?php echo base_url('user/closeouts/showemissions'); ?>" method="post">
                    <input style="display: none;" type="number" name="optionSelected" value="1">
                    <input name="submit" id="submit" value="Ver emisiones" class="btn btn-lg btn-primary" type="submit">
                </form>
            </div>
            <div class="col-lg-6">
                <form role="form" action="<?php echo base_url('user/closeouts/showcloseouts'); ?>" method="post">
                    <input name="submit" id="submit" value="Documentos de liquidación" class="btn btn-lg btn-primary" type="submit">
                </form>
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#generalVision" aria-controls="visionglobal" role="tab" data-toggle="tab">Visión general</a></li>
            <li role="presentation"><a href="#currentBooking" aria-controls="pendingBooking" role="tab" data-toggle="tab">Reservas pendientes de emisión</a></li>
            <li role="presentation"><a href="#cancelledBooking" aria-controls="cancelledBooking" role="tab" data-toggle="tab">Reservas anuladas</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="generalVision">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (is_array($resumeInfo['servicios'])) {
                            if (count($resumeInfo['servicios']) > 0) {
                                foreach ($resumeInfo['servicios'] as $info) { ?>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 style="color: #ffffff;"> <?php echo $info->nombre.", ".$info->fecha_inicio; ?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-12 col-lg-12">
                                                <span
                                                    style="padding-right: 10px;">Código de referencia:<strong><?php echo " ".$info->referencia; ?></strong></span>
                                            </div>

                                            <div class="col-md-4 col-lg-4">
												<span>Hay <strong><?php echo count($info->reservas); ?></strong> <?php $reservas = count($info->reservas)==1? 'reserva pendiente': 'reservas pendientes'; echo $reservas;?>.</span>
                                            </div>
                                            <div class="col-md-4 col-lg-4 text-right">
                                                <span>Importe ventas: <strong><?php echo sprintf("%.2f", $info->totalReservaServicio)." €"; ?></strong></span>
                                            </div>
                                            <div class="col-md-4 col-lg-4 text-right">
                                                <span>Comisiones derivadas: <strong><?php echo sprintf("%.2f", $info->totalComisionServicio)." €"; ?></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="col-md-12 col-lg-12 well text-center">
                                    <h3>No hay ninguna reserva pendiente de liquidar de este vendedor.</h3>
                                </div>
                            <?php }
                        } ?>
                        <div class="col-md-4 col-lg-4 col-lg-offset-4 col-md-offset-4 text-right well">
                            <span>Importe total ventas: <strong style="font-size: 28px;"><?php echo sprintf("%.2f", $resumeInfo['totalReservaGlobal'])." €"; ?></strong></span>
                        </div>
                        <div class="col-md-4 col-lg-4 text-right well">
                            <span>Importe total comisiones: <strong style="font-size: 28px;"><?php echo sprintf("%.2f", $resumeInfo['totalComisionGlobal'])." €"; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="currentBooking">
                <form id="formCurrentPaymentsBookingList" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" method="post">
                    <table id="tableCurrentPaymentsBookingList" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentCloseoutU">
                        <thead>
                        <tr>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha reserva</th>
                            <th data-sortable="true">Servicio (Referencia)</th>
                            <th data-sortable="true">Estado</th>
                            <th data-sortable="true">Total pers.</th>
                            <th data-events="operateCurrentCloseoutU">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($pendingPaymetsBooking)) {
                            foreach ($pendingPaymetsBooking as $reservas) { ?>
                                <tr>
                                    <td data-booking="<?php echo $reservas->id_reserva ?>">
                                        <?php echo $reservas->identificacion_reserva ?>
                                    </td>
                                    <td><?php echo date_format(date_create($reservas->fecha_reserva), 'd/m/Y, H:i'); ?></td>
                                    <td><?php echo $reservas->servicio_completo ?></td>
                                    <td><?php
                                        switch ($reservas->estado_reserva) {
                                    case 0:
                                        echo "Sin confirmar";
                                        break;
                                    case 1:
                                        echo 'Confirmada';
                                        break;
                                    case 2:
                                        echo "Anulada";
                                        break;
                                        }
                                        ?></td>
                                    <td><?php echo $reservas->totalPersonas; ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva">
                                    </td>
                                </tr>
                                <?php }
                        } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="cancelledBooking">
                <form id="formCancelledBookings" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" method="post">
                    <table id="tableCurrentPaymentsBookingList"
                           data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
						   class="table table-striped table-hover" data-show-filter="true" data-events="operateCancelBookingU">
                        <thead>
                        <tr>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha reserva</th>
                            <th data-sortable="true">Servicio (Referencia)</th>
                            <th data-sortable="true">Estado</th>
                            <th data-sortable="true">Total pers.</th>
                            <th data-events="operateCancelBookingU">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($cancelledBookings)) {
                            foreach ($cancelledBookings as $reservas) { ?>
                                <tr>
                                    <td data-booking="<?php echo $reservas->id_reserva ?>">
                                        <?php echo $reservas->identificacion_reserva ?>
                                    </td>
                                    <td><?php echo date_format(date_create($reservas->fecha_reserva), 'd/m/Y, H:i'); ?></td>
                                    <td><?php echo $reservas->servicio_completo ?></td>
                                    <td><?php
                                        switch ($reservas->estado_reserva) {
                                    case 0:
                                        echo "Sin confirmar";
                                        break;
                                    case 1:
                                        echo 'Pagada';
                                        break;
                                    case 2:
                                        echo "Anulada";
                                        break;
                                        }
                                        ?></td>
                                    <td><?php echo $reservas->totalPersonas; ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva">
                                    </td>
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

<?php $this->load->view('partials/user_footer'); ?>
