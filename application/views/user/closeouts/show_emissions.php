<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>

<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <form action="<?php echo base_url('user/closeouts/showemissions'); ?>" method="post">
            <div class="row">
                <div class='col-lg-3 col-md-3 '>
                    <label>Desde (fecha inicio servicio):</label>
                    <div class="input-group">
                        <input class="form-control" name="startDateBegin"
                               type="date" <?php if ($startDateBegin != '') {
                            echo "value='".$startDateBegin."'";
                        } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Hasta:</label>

                    <div class="input-group">
                        <input class="form-control" name="endDateBegin"
                               type="date" <?php if ($endDateBegin != '') {
                            echo "value='".$endDateBegin."'";
                        } ?> >
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class='col-lg-3 col-md-3 '>
                    <label>Desde (fecha fin servicio):</label>

                    <div class="input-group">
                        <input class="form-control" name="startDateEnd"
                               type="date" <?php if ($startDateEnd != '') {
                            echo "value='".$startDateEnd."'";
                        } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Hasta:</label>

                    <div class="input-group">
                        <input class="form-control" name="endDateEnd"
                               type="date" <?php if ($endDateEnd != '') {
                            echo "value='".$endDateEnd."'";
                        } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Tipo:</label>
                    <div class="input-group">
                        <select class="form-control" name="optionSelected">
                            <option value="1" <?php if ($optionSelected == 1) {
                                echo "selected='selected'";
                            } ?> >Pendiente de emitir
                            </option>
                            <option value="2" <?php if ($optionSelected == 2) {
                                echo "selected='selected'";
                            } ?> >Emitida
                            </option>
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
        <?php if ($optionSelected == 1) { ?>
                <form id="formCurrentPaymentsBookingList" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" target="_blank" method="post">
                    <table id="tableCurrentPaymentsBookingList" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentCloseoutU">
                        <thead>
                        <tr>
                            <th data-sortable="true">ID reserva</th>
                            <th data-sortable="true">Fecha reserva</th>
                            <th data-sortable="true">Servicio (Referencia)</th>
                            <th data-sortable="true">Total personas</th>
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
            <form id="formCurrentPaymentsBookingList" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" method="post" target="_blank">
                <table id="tableCurrentPaymentsBookingList" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					   class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentCloseoutU">
                    <thead>
                    <tr>
                        <th data-field="checkbox" data-checkbox="true">CheckList</th>
                        <th data-sortable="true">ID reserva</th>
                        <th data-sortable="true">Fecha reserva</th>
                        <th data-sortable="true">Servicio (Referencia)</th>
                        <th data-sortable="true">Total personas</th>
                        <th data-events="operateCurrentCloseoutU">Acción</th>
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
        <?php } ?>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
