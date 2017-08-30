<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/user_nav');   ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <form id="formCustomBookingSearchList" action="<?php echo base_url('user/bookings/detailsbooking'); ?>" method="post">
            <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
				class="table table-striped table-hover" data-show-filter="true" data-events="operateSearchBookingU">
                <thead>
                <tr>
                    <th data-sortable="true">ID reserva</th>
                    <th data-sortable="true">Servicio (Referencia)</th>
                    <th data-sortable="true">Fecha emisión reserva</th>
                    <th data-sortable="true">Vendedor</th>
                    <th data-sortable="true">Total personas</th>
                    <th data-sortable="true">Estado</th>
                    <th data-events="operateSearchBookingU">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($bookingData)) {
                    foreach ($bookingData as $reservas) { ?>
                        <tr>
                            <td data-booking="<?php echo $reservas->id_reserva ?>"><?php echo $reservas->identificador_reserva; ?></td>
                            <td><?php echo $reservas->servicio_completo ?></td>
                            <td><?php echo $reservas->fecha_emision_reserva; ?></td>
                            <td><?php echo $reservas->nombre_vendedor ?></td>
                            <td><?php echo $reservas->totalPersonas ?></td>
                            <td><?php
                                switch($reservas->estado_reserva){
                            case 0: echo "No confirmada";
                                break;
                            case 1: echo "Confirmada";
                                break;
                            case 2: echo "Cancelada";
                                break;
                                }
                                ?></td>

                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reserva"> </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
