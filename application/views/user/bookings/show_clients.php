<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

<script type="text/javascript">
    var currentDate = <?php echo $today."";?>;
</script>

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <form id="ReservasForm" accept-charset="utf-8" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" method="post">

                <input style="display:none;" id="serviceID" type="text" name="serviceID" value="<?php echo $serviceInfo->id_servicio; ?>"/>
                <div class='col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 well text-center'>
                    <h4> <strong><?php echo $serviceInfo->nombre; ?></strong> (<?php echo $serviceInfo->referencia; ?>) - Fecha de comienzo:<strong> <?php echo $serviceInfo->fecha_comienzo; ?> </strong></h4> <h4>Último día de reserva: <strong> <?php echo $serviceInfo->fecha_reservas_fin; ?> </strong></h4>
                </div>
                <div class='col-lg-4 col-md-4 well'>
                    <label for="numeroReservasSelect"
                           data-seller="<?php echo $id_user; ?>">
                        Nº PERSONAS:</label>
                    <select id="numeroReservasSelect" name="numeroReservasSelect" required="required">
                        <option value="" selected="selected" disabled="disabled">No hay ninguna seleccionada</option>
                        <script type="text/javascript">
                            var number_top = 10;
                            for (var i = 1; i < number_top; i++) {
                                document.write('<option value="' + i + '"> ' + i + '</option>');
                            }
                        </script>
                    </select>
                </div>
                <div class='col-lg-8 col-md-8 well'>
                    <label for="paradaSelect">
                        HORA Y LUGAR DE RECOGIDA:</label>
                    <select id="paradaSelect" name="paradaSelect" required="required">
                        <option value="" selected="selected" disabled="disabled">Ninguna parada seleccionada</option>
                        <?php if (is_array($serviceInfo->paradasVendedor)) {
                            foreach ($serviceInfo->paradasVendedor as $parada) { ?>
                                <option value="<?php echo $parada->id_servicio_parada; ?>">
                                    <?php echo $parada->hora_parada." - ".$parada->parada; ?>
                                </option>
                            <?php }
                        } ?>
                    </select>
                </div>

                <?php if ($serviceInfo->unique_passenger) {?>
                <div class='col-lg-12 col-md-12'>
                    <div class='col-lg-12 col-md-12'>
                        <input type='checkbox' id="onlyMainPassenger" name="onlyMainPassenger"> Marque esta casilla si solo son necesarios los datos del pasajero principal para esta reserva.
                    </div>
                </div>
                <?php } ?>
                <div class='col-lg-4 col-md-4 col-lg-offset-8  col-md-offset-8 well text-right' style="margin-top: 16px; margin-bottom: 16px;">
                    <h3 id="totalReserva"></h3>
                </div>
                <div id="listado_clientes_reservas" >
                </div>
            </form>

            <button type="button" id="openModal" style="display:none" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirmarReservaModal"> </button>
        </div>

        <div class="row">
            <form id="finalForm" accept-charset="utf-8" action="<?php echo base_url('user/bookings/bookingdetailsfromnew'); ?>" method="post"> </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarReservaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5>¿Está seguro que desea realizar la reserva a este servicio?</h5>
            </div>
            <div class="modal-footer">
			<div class="col-lg-8 col-md-8" style="text-align: left;">
                <button type="button" id="cerrarConfirmarReserva" class="btn btn-default" style="text-align: left" data-dismiss="modal">No </button>
			</div>
			<div class="col-lg-4 col-md-4" style="padding-left: 0 !important;">
                <button type="button" id="confirmarReserva" class="btn btn-md btn-success">Confirmar reserva</button>
			</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
