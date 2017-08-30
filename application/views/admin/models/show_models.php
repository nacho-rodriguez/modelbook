<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo 'models/'.basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
            <li role="presentation" class="active"><a href="#currentModels" aria-controls="currentModels" role="tab" data-toggle="tab">Modelos disponibles</a></li>
            <li role="presentation" ><a href="#pastModels" aria-controls="pastModels" role="tab" data-toggle="tab">Modelos inactivos</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="currentModels">
                <form id="formCurrentListModels" action="<?php echo base_url('admin/models/detailsmodel'); ?>" method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
                            class="table table-striped table-hover" data-show-filter="true" data-events="operateCurrentModels">
                        <thead>
                        <tr>
                            <th data-sortable="true">Modelo</th>
                            <th data-sortable="true">Tipo de modelo</th>
                            <th data-sortable="true" >Título del modelo</th>
                            <th data-events="operateCurrentModels">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (is_array($availableModels)) {
                            foreach ($availableModels as $model) { ?>
                                <tr>
                                    <td data-model="<?php echo $model->id_modelo ?>"><?php echo $model->modelo ?> </td>
                                    <td><?php echo $model->tipo_servicio; ?> </td>
                                    <td><?php echo $model->titulo; ?> </td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver modelo"> </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="pastModels">
                <form id="formPastListModels" action="<?php echo base_url('admin/models/detailsmodel'); ?>" method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
                            class="table table-striped table-hover" data-show-filter="true" data-events="operatePastModels">
                        <thead>
                        <tr>
                            <th data-sortable="true">Modelo</th>
                            <th data-sortable="true">Tipo de modelo</th>
                            <th data-sortable="true" >Título del modelo</th>
                            <th data-events="operatePastModels">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (is_array($disableModels)) {
                            foreach ($disableModels as $model) { ?>
                                <tr>
                                    <td data-model="<?php echo $model->id_modelo ?>"><?php echo $model->modelo ?> </td>
                                    <td><?php echo $model->tipo_servicio; ?> </td>
                                    <td><?php echo $model->titulo; ?> </td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver modelo"> </td>
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
