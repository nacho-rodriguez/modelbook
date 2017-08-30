<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>

<div class="main-container">

    <div class="panel panel-default panel-properties">

        <div class="row">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 text-right">
                    <form role="form" action="<?php echo base_url('admin/typeservices/newtypeservice'); ?>" method="post">
                        <button style="width: 300px; margin-bottom: 25px;" class="btn btn-lg btn-info" type="submit">
                            <i class="fa fa-plus fa-2x pull-left"></i>
                            <div style="margin-top: 5px;"> Nuevo tipo de servicio</div>
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                <form id="formListTypeServices" action="<?php echo base_url('admin/typeservices/detailstypeservice'); ?>" method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" class="table table-striped table-hover"
						data-show-filter="true" data-events="operateTypeServices">
                        <thead>
                        <tr>
                            <th data-sortable="true">Tipo de servicios </th>
                            <th data-sortable="true">Estado</th>
                            <th data-sortable="true">Orden</th>
                            <th data-events="operateTypeServices">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($typeData)) {
                            foreach ($typeData as $typeService) { ?>
                                <tr>
                                    <td data-typeservice="<?php echo $typeService->id_tipo_servicio; ?>"><?php echo $typeService->nombre; ?></td>
                                    <td><?php
                                        switch ($typeService->estado) {
                                    case 0: echo 'Inactivo';
                                        break;
                                    case 1: echo 'Activo';
                                        break;
                                        } ?></td>
                                    <td><?php echo $typeService->orden; ?> </td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver tipo de servicio"> </td>
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

<?php $this->load->view('partials/admin_footer'); ?>
