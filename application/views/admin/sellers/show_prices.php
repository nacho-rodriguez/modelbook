<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">

        <label id="sellerLab" style="display: none;"><?php if (isset($seller)) {
            echo $seller;
       } ?> </label>
        <label id="serviceLab" style="display: none;"><?php if (isset($service)) {
            echo $service;
       } ?> </label>
        <label id="numberPricesLab" style="display: none;"><?php if (is_array($pricesService)) {
            echo count($pricesService);
       } ?> </label>
        <div class="row">
            <div class="col-lg-12 col-md-12 text-center">
                <h5> Servicio: <?php echo $serviceNameFull; ?></h5>
                <h6> Vendedor: <?php echo $sellerName; ?></h6>
            </div>

			<div class="precios">
				<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
					<div class="col-md-4 col-lg-4">
						<label>Tipo</label>
					</div>
					<div class="col-md-3 col-lg-3">
						<label>Precio</label>
					</div>
					<div class="col-md-3 col-lg-3">
						<label>Comisión</label>
					</div>
					<div class="col-md-2 col-lg-2">
						<label>Tipo comisión</label>
					</div>
				</div>

            <form id="listadoPreciosServicio" method="post">
                    <?php
                    if (is_array($pricesService)) {
                        if (count($pricesService) > 0) {
                            foreach ($pricesService as $precio) {
                                ?>
									<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                                        <div class="col-md-4 col-lg-4">
                                            <input class="id_tipo_cliente" name="idPrecio"
                                                   style="display: none;"
                                                   value="<?php echo $precio->id_tipo_cliente; ?>">
                                            <label for="precio"><?php echo $precio->tipo_cliente; ?></label>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input class="form-control precioOficial" name="precio" type="text"
                                                   placeholder="Precio"
                                                   value="<?php echo $precio->valor_monetario; ?>">
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input class="form-control comisionOficial" name="comision"
                                                   type="text"
                                                   placeholder="Comisión"
                                                   value="<?php echo $precio->comision; ?>">
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <select class="form-control tipoComisionOficial"
                                                    name="tipo_comision">
                                                <?php
                                                if (is_array($all_commissions)) {
                                                    foreach ($all_commissions as $comision) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $comision->id_tipo_comision; ?>" <?php if ($precio->tipo_comision_fk == $comision->id_tipo_comision) {
                                                                    echo "selected='selected'";
                                                           } ?> >  <?php echo $comision->nombre; ?>  </option>
													<?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
								<?php
                            }
                        } else {
                            foreach ($all_types_clients as $precio) { ?>
                                <div class="precios">
                                    <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                                        <div class="col-md-4 col-lg-4">
                                            <input class="id_tipo_cliente" name="idPrecio"
                                                   style="display: none;"
                                                   value="<?php echo $precio->id_tipo_cliente; ?>">
                                            <label for="precio"><?php echo $precio->nombre; ?></label>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input class="form-control precioOficial" name="precio" type="text"
                                                   placeholder="Precio"
                                                  >
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input class="form-control comisionOficial" name="comision"
                                                   type="text"
                                                   placeholder="Comisión"
                                                   >
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <select class="form-control tipoComisionOficial"
                                                    name="tipo_comision">
                                                <?php
                                                if (is_array($all_commissions)) {
                                                    foreach ($all_commissions as $comision) { ?>
                                                        <option
                                                            value="<?php echo $comision->id_tipo_comision; ?>">  <?php echo $comision->nombre; ?>  </option>
													<?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    } ?>
                <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
                    <input style="margin-top: 25px;" id="actualizarPreciosServicio" name="submit" class="btn btn-primary btn-lg" value="Actualizar los precios y comisiones del servicio">
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
