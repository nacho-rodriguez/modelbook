<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <form id="formListClients" action="<?php echo base_url('admin/clients/detailsclient'); ?>" method="post">
	        <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
			class="table table-striped table-hover" data-show-filter="true" data-events="operateClient">
	            <thead>
	            <tr>
	                <th data-sortable="true">DNI</th>
	                <th data-sortable="true">Nombre</th>
	                <th data-sortable="true" >Apellidos</th>
	                <th data-sortable="true" >Teléfono</th>
	                <th data-events="operateClient">Acción</th>
	            </tr>
	            </thead>
	            <tbody>
	            <?php if (is_array($all_clients)) {
	                foreach ($all_clients as $client) { ?>
	                    <tr>
	                        <td data-client="<?php echo $client->id_cliente ?>"><?php echo $client->dni ?></td>
	                        <td><?php echo $client->nombre ?></td>
	                        <td><?php echo $client->apellidos ?></td>
	                        <td><?php echo $client->telefono ?></td>
	                        <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver cliente"> </td>
	                    </tr>
	                <?php }
	            } ?>
	            </tbody>
	        </table>
        </form>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
