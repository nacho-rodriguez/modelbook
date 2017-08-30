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
                    <form role="form" action="<?php echo base_url('admin/typeclients/newtypeclient'); ?>" method="post">
                        <button style="width: 300px; margin-bottom: 25px;" class="btn btn-lg btn-info" type="submit">
                            <i class="fa fa-plus fa-2x pull-left"></i>
                            <div style="margin-top: 5px;"> Nuevo tipo de cliente</div>
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                <form id="formListTypePrices" action="<?php echo base_url('admin/typeclients/detailstypeclient'); ?>" method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" class="table table-striped table-hover"
					data-show-filter="true" data-events="operatePrices">						
                        <thead>
                        <tr>
                            <th data-sortable="true">Tipo de precio/cliente</th>
                            <th data-sortable="true">Estado</th>
                            <th data-events="operatePrices">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($tipoClientes)) {
                            foreach ($tipoClientes as $tipoCliente) { ?>
                                <tr>
                                    <td data-price="<?php echo $tipoCliente->id_tipo_cliente ?>"><?php echo $tipoCliente->nombre ?></td>
                                    <td><?php $status = $tipoCliente->estado;
                                    switch ($status) {
                                    case 0:
                                        echo 'Inactivo';
                                        break;
                                    case 1:
                                        echo 'Activo';
                                        break;
                                    } ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver tipo de cliente">
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

<?php $this->load->view('partials/admin_footer'); ?>
