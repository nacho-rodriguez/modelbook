<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <form action="<?php echo base_url('admin/typeservices/createnewtypeservice'); ?>" method="post">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group col-lg-5 col-md-5">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <input name="nombre" id="nombre" class="form-control" required="" type="text"
                                       placeholder="Nombre">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="estado">Estado</label>
                            <div class="input-group">
                                <select id="estado" name="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="orden">Orden</label>
                            <div class="input-group">
                                <input name="orden" id="orden" class="form-control" required="" type="number" min="1"
                                       placeholder="Orden">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <input class="btn btn-primary" name="submit" type="submit" value="Crear nuevo tipo de servicio">
                        </div>
                    </div>
                </div>
             </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
