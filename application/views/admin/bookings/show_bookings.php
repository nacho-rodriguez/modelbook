<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <form id="formFilterByServiceBooking" action="<?php echo base_url('admin/bookings/showbookings'); ?>" method="post"> </form>
        <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
		class="table table-striped table-hover" data-show-filter="true" data-events="operateBookingServices">
            <thead>
            <tr>
                <th data-sortable="true">Código de referencia</th>
                <th data-sortable="true">Título</th>
                <th data-sortable="true">Fecha de inicio</th>
                <th data-sortable="true">Fecha fin</th>
                <th data-sortable="true">Total personas reservadas</th>
                <th data-events="operateBookingServices">Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($services_availables)) {
                foreach ($services_availables as $service) { ?>
                    <tr>
                        <td data-service="<?php echo $service->id_servicio ?>"><?php echo $service->referencia ?></td>
                        <td><?php echo $service->nombre ?></td>
                        <td><?php echo $service->fecha_comienzo; ?></td>
                        <td><?php echo $service->fecha_finalizacion; ?></td>
                        <td><?php echo $service->numero_actual_reservas_realizadas; ?></td>
                        <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver reservas"> </td>
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
