<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo 'services/'.basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="form-group col-lg-12 col-md-12 text-right">
                <a href="<?php echo base_url('admin/services/showservices') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> Ver servicios existentes</a>
            </div>
        </div>
        <div class="modelsList">
            <form id="formListModelsForServices" action="<?php echo base_url('admin/services/newservice'); ?>" method="post">
                <table  data-toggle="table"
                        data-pagination="true"
                        data-locale="es-SP"
                        data-search="true" class="table table-striped table-hover" data-show-filter="true" data-events="operateModelForService">
                    <thead>
                    <tr>
                        <th data-sortable="true">Modelo</th>
                        <th data-sortable="true">Tipo de modelo</th>
                        <th data-sortable="true" >Título del modelo</th>
                        <th data-events="operateModelForService">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (is_array($modelsList)) {
                        foreach ($modelsList as $model) {
                            ?>
                            <tr>
                                <td data-model="<?php echo $model->id_modelo ?>"><?php echo $model->modelo ?></td>
                                <td><?php echo $model->tipo_servicio; ?> </td>
                                <td><?php echo $model->titulo; ?></td>
                                <td><input class="btn btn-primary" name="submitTable" type="submit" value="Nuevo Servicio"> </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
