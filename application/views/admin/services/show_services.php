<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo 'services/'.basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
		<ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
			<li role="presentation" class="active"><a href="#currentServices" aria-controls="currentServices" role="tab" data-toggle="tab"> Servicios disponibles</a></li>
			<li role="presentation" ><a href="#pastServices" aria-controls="pastServices" role="tab" data-toggle="tab">Servicios no disponibles</a></li>
		</ul>
		<div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="currentServices">
        		<form id="formCurrentServices" action="<?php echo base_url('admin/services/detailsservice'); ?>" method="post">
		            <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentServices">
		                <thead>
		                <tr>
		                    <th data-sortable="true">Código de referencia</th>
		                    <th data-sortable="true">Título</th>
		                    <th data-sortable="true">Fecha de inicio</th>
		                    <th data-sortable="true">Fecha fin</th>
		                    <th data-sortable="true">Estado</th>
		                    <th data-sortable="true">Total personas reservadas</th>
		                    <th data-events="operateCurrentServices">Acción</th>
		                </tr>
		                </thead>
		                <tbody>
		                <?php if (is_array($available_services)) {
		                    foreach ($available_services as $service) { ?>
		                        <tr>
		                            <td data-service="<?php echo $service->id_servicio ?>"><?php echo $service->referencia ?></td>
		                            <td><?php echo $service->nombre ?></td>
		                            <td><?php echo $service->fecha_comienzo; ?></td>
		                            <td><?php echo $service->fecha_finalizacion; ?></td>
		                            <td><?php $status = ($service->estado == 1) ? 'Activo' : 'Inactivo';
		                            echo $status; ?></td>
		                            <td><?php echo $service->numero_actual_reservas_realizadas; ?></td>
		                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver servicio"> </td>
		                        </tr>
		                <?php }
		                }?>
		                </tbody>
		            </table>
        		</form>
    		</div>
			<div role="tabpanel" class="tab-pane" id="pastServices">
        		<form id="formPastServices" action="<?php echo base_url('admin/services/detailsservice'); ?>" method="post">
		            <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
					class="table table-striped table-hover" data-show-filter="true" data-events="operatePastServices">
		                <thead>
		                <tr>
		                    <th data-sortable="true">Código de referencia</th>
		                    <th data-sortable="true">Título</th>
		                    <th data-sortable="true">Fecha de inicio</th>
		                    <th data-sortable="true">Fecha fin</th>
		                    <th data-sortable="true">Estado</th>
		                    <th data-sortable="true">Total personas reservadas</th>
		                    <th data-events="operatePastServices">Acción</th>
		                </tr>
		                </thead>
		                <tbody>
		                <?php if (is_array($not_available_services)) {
		                    foreach ($not_available_services as $service) { ?>
		                        <tr>
		                            <td data-service="<?php echo $service->id_servicio ?>"><?php echo $service->referencia ?></td>
		                            <td><?php echo $service->nombre ?></td>
		                            <td><?php echo $service->fecha_comienzo; ?></td>
		                            <td><?php echo $service->fecha_finalizacion; ?></td>
		                            <td><?php $status = ($service->estado == 1) ? 'Activo' : 'Inactivo';
		                            echo $status; ?></td>
		                            <td><?php echo $service->numero_actual_reservas_realizadas; ?></td>
		                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver servicio"> </td>
		                        </tr>
		                <?php }
		                }?>
		                </tbody>
		            </table>
        		</form>
    		</div>
		</div>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
