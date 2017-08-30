<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <form id="formListSellers" action="<?php echo base_url('admin/closeouts/detailscloseouts'); ?>" method="post">
            <table data-toggle="table" data-pagination="true" data-locale="es-SP"
                data-search="true" class="table table-striped table-hover" data-show-filter="true"
                data-events="operateCloseoutsSeller">
                <thead>
                <tr>
                    <th data-sortable="true">CIF</th>
                    <th data-sortable="true">Nombre comercial</th>
                    <th data-events="operateCloseoutsSeller">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php if (is_array($all_sellers)) {
                    foreach ($all_sellers as $seller) { ?>
                        <tr>
                            <td data-seller="<?php echo $seller->id_vendedor ?>"><?php echo $seller->cif ?></td>
                            <td><?php echo $seller->nombre ?></td>
                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver liquidaciones"> </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
