<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <form action="<?php echo base_url('admin/typeclients/updatetypeclient'); ?>" method="post">
                <input name="idPrice" style="display: none;" type="text" value="<?php echo $tipoCliente->id_tipo_cliente; ?>">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="nombre">Nombre</label>

                            <div class="input-group">
                                <input name="nombre" id="nombre" class="form-control" required="" type="text"
                                       placeholder="Nombre" value="<?php echo $tipoCliente->nombre; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="edadMinima">Edad mínima</label>

                            <div class="input-group">
                                <input name="edadMinima" id="edadMinima" class="form-control" required="" type="number"
                                       placeholder="Edad mínima" min="0" max="250"
                                       value="<?php echo $tipoCliente->edad_minima; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="edadMaxima">Edad máxima</label>

                            <div class="input-group">
                                <input name="edadMaxima" id="edadMaxima" class="form-control" required="" type="number"
                                       placeholder="Edad máxima" min="0" max="250"
                                       value="<?php echo $tipoCliente->edad_maxima; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 ">
                            <div class="input-group">
                                <label for="estado">Estado</label>

                                <div class="input-group">
                                    <select id="estado" name="estado">
                                        <option value="0" <?php if ($tipoCliente->estado == 0) {
										    echo "selected='selected'";
										} ?>>
                                            Inactivo
                                        </option>
                                        <option value="1" <?php if ($tipoCliente->estado == 1) {
										    echo "selected='selected'";
										} ?>>
                                            Activo
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3  col-md-3">
                            <input class="btn btn-primary" name="submit" type="submit" value="Actualizar">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
