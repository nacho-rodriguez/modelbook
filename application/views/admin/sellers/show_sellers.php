<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
	<div class="panel panel-default panel-properties">
		<form id="formListSellers" action="<?php echo base_url('admin/sellers/detailsseller'); ?>" method="post">
			<table  data-toggle="table" data-locale="es-SP" data-pagination="true" data-search="true"
			class="table table-striped table-hover" data-show-filter="true" data-events="operateSeller">
				<thead>
					<tr>
						<th data-sortable="true">CIF</th>
						<th data-sortable="true">Nombre comercial</th>
						<th data-sortable="true" >Estado</th>
						<th data-events="operateSeller">Acción</th>
					</tr>
				</thead>
				<tbody>
				<?php if (is_array($all_sellers)) {
				    foreach ($all_sellers as $seller) { ?>
				        <tr>
				        <td data-seller="<?php echo $seller->id_vendedor ?>"><?php echo $seller->cif ?></td>
				        <td><?php echo $seller->nombre ?></td>
				        <td><?php $tipo_servicio = $seller->estado;
				        switch ($tipo_servicio) {
				        case 0: echo 'Sin acceso';
				            break;
				        case 1: echo 'Con acceso';
				            break;
				        } ?></td>
				    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver vendedor"> </td>
				    </tr>
					<?php }
				} ?>
				</tbody>
			</table>
		</form>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
