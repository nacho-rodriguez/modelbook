<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/user_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="form-group col-lg-12 col-md-12 text-right">
				<a href="<?php echo base_url('user/requests/newrequest') ?>" class="fa fa-envelope fa-2x btn btn-lg btn-info"> Nueva petición</a>
            </div>
        </div>
        <form id="formListRequests" action="<?php echo base_url('user/requests/detailsrequest'); ?>" method="post">
            <table  data-toggle="table"
                    data-pagination="true"
                    data-locale="es-SP"
                    data-search="true" class="table table-striped table-hover" data-show-filter="true" data-events="operateRequest">
                <thead>
                <tr>
                    <th data-sortable="true">Asunto</th>
                    <th data-sortable="true">Estado</th>
                    <th data-sortable="true">Fecha apertura</th>
                    <th data-events="operateRequest">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php if (is_array($requests)) {
                    foreach ($requests as $request) { ?>
                        <tr>
                            <td data-request="<?php echo $request->id_peticion; ?>"><?php echo $request->asunto ?></td>
                            <td><?php $status = $request->estado;
                                switch($status){
                            case 0: echo "Abierta";
                                break;
                            case 1: echo "Cerrada";
                                break;
                                }
                                ?></td>
                            <td><?php echo $request->fecha_apertura; ?></td>
                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver petición"> </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </form>
	</div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
