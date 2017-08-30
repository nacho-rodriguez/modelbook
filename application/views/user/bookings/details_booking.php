<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>
<div class="main-container-booking-details">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <?php if ($bookingInfo->estado_reserva == 1) { ?>
				<div class="col-lg-6 col-md-6 col-md-offset-6 text-right">
                    <form action="<?php echo base_url('user/bookings/createbookingpdf'); ?>" method="post">
                        <input style="display: none;" name="bookingID" value="<?php echo $bookingInfo->id_reserva; ?>"/>
                        <input style="margin-left: 5px; margin-bottom: 5px;" type="submit" class="btn btn-info btn-lg" value="Generar PDF de la reserva"/>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div style="margin-top: 16px;" class="well text-center">
            <h4> Información de la reserva</h4>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID reserva</th>
                <th>Fecha de emisión</th>
                <th>Estado de la reserva</th>
                <th>Total reserva</th>
                <th>Total comisión</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $bookingInfo->numero_billete."/".$bookingInfo->reservas_year; ?></td>
                <td><?php echo $bookingInfo->fecha_emision_reserva; ?></td>
                <td><?php
                    switch ($bookingInfo->estado_reserva) {
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
                <td><?php echo sprintf("%.2f", $bookingInfo->totalReserva)." €"; ?></td>
                <td><?php echo sprintf("%.2f", $bookingInfo->totalComision)." €"; ?></td>
            </tr>
            </tbody>
        </table>

        <div style="margin-top: 16px;" class="well text-center">
            <h4> Información del servicio</h4>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nombre del servicio</th>
                <th>Referencia</th>
                <th>Inicio</th>
                <th>Finalización</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $bookingInfo->nombreServicio; ?></td>
                <td><?php echo $bookingInfo->referencia; ?></td>
                <td><?php echo "En ".$bookingInfo->localidad_inicio." el día ".$bookingInfo->fecha_inicio_reserva . " en ".$bookingInfo->lugar_parada." a las ".$bookingInfo->hora_parada; ?></td>
                <td><?php echo "En ".$bookingInfo->localidad_fin." el día ".$bookingInfo->fecha_fin_reserva . " a las ".$bookingInfo->hora_fin_reserva; ?></td>
            </tr>
            </tbody>
        </table>

        <div style="margin-top: 16px;" class="well text-center">
            <h4> Clientes de la reserva</h4>
        </div>

        <div class="panel-group" id="clients" role="tablist" aria-multiselectable="true">
            <?php if (is_array($bookingInfo->clients)) {
                $numberClient = 1;
                foreach ($bookingInfo->clients as $client) {
                    $name = $client->nombre ? $client->nombre." ".$client->apellidos : 'Acompañante'; ?>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h5 class="text-center">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#clients" href="#client<?php echo $numberClient; ?>" aria-expanded="false" aria-controls="client<?php echo $numberClient; ?>">
                                    <?php echo $name; ?>
                                </a>
                            </h5>
                        </div>
                        <div id="client<?php echo $numberClient; ?>" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="client<?php echo $numberClient; ?>">
                            <div class="panel-body">

                                <div class="row">
                                    <?php if ($client->nombre) { ?>
                                        <div class='col-lg-2 col-md-2'>
                                            <label>DNI:</label>

                                            <p><?php echo $client->dni; ?></p>
                                        </div>
                                    <?php } ?>
                                    <div class='col-lg-2 col-md-2'>
                                        <label>Tipo cliente:</label>
                                        <p><?php echo $client->tipo_cliente; ?></p>
                                    </div>
                                    <div class='col-lg-2 col-md-2'>
                                        <label>Fecha de nacimiento:</label>
                                        <p><?php echo date_format(date_create($client->fecha_nacimiento), 'd/m/Y'); ?></p>
                                    </div>

                                    <?php if ($client->nombre) { ?>
                                        <div class='col-lg-2 col-md-2'>
                                            <label>Teléfono:</label>

                                            <p><?php echo $client->telefono; ?></p>
                                        </div>
                                        <div class='col-lg-3 col-md-3'>
                                            <label>Email:</label>

                                            <p><?php echo $client->email; ?></p>
                                        </div>
                                    <?php } ?>

                                    <div class='col-lg-2 col-md-2 col-lg-offset-8 col-md-offset-8'>
                                        <label>Precio individual:</label>

                                        <p><?php echo sprintf("%.2f", $client->valor_monetario)." €"; ?></p>
                                    </div>
                                    <div class='col-lg-2 col-md-2'>
                                        <label>Comisión individual:</label>

                                        <p><?php echo sprintf("%.2f", $client->comisionTotal)." €"; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $numberClient++;
                }
            } ?>
        </div>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
