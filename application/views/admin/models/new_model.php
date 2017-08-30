<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="col-lg-12 col-md-12 text-right">
                <a href="<?php echo base_url('admin/models/showmodels') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> Ver modelos existentes</a>
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">1) Insertar detalles y tipo de modelo</a></li>
            <li role="presentation" ><a href="#banner" aria-controls="banner" role="tab" data-toggle="tab">2) Añadir un báner</a></li>
            <li role="presentation" ><a href="#paradas" aria-controls="paradas" role="tab" data-toggle="tab">3) Establecer paradas del modelo</a></li>
            <li role="presentation"><a href="#precios" aria-controls="precios" role="tab" data-toggle="tab">4) Completar tabla de precios y comisiones</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <?php if (isset($code_result)) if ($code_result == 0) { ?>
	                <div id="formCreateService">
	                    <?php echo form_open_multipart(base_url('admin/models/creatingmodel')) ?>
	                    <div class="row">
	                        <div class="form-group col-lg-12 col-md-12 text-center well">
	                            <h4>Tipo de modelo</h4>

	                            <?php foreach ($all_type_services as $typeService) { ?>
	                                <input type="radio" name="type_service" required="" value="<?php echo $typeService->id_tipo_servicio; ?>" />
	                                <label style="margin-right: 40px;"><?php echo $typeService->nombre; ?></label>
	                            <?php } ?>
	                        </div>
	                        <div class="form-group col-lg-4 col-md-4">
	                            <label for="Modelo">Nombre del modelo</label>
	                            <div class="input-group">
	                                <input class="form-control" id="inputModelo" name="Modelo" required="" type="text" placeholder="Nombre del modelo">
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-4 col-md-4">
	                            <label for="Titulo">Título </label>
	                            <div class="input-group">
	                                <input name="Titulo" id="Titulo" class="form-control" required="" type="text" placeholder="Título">
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-4 col-md-4">
	                            <label for="Foto">Foto</label>
	                            <div class="input-group">
									<?php echo form_upload('userfile') ?>
	                            </div>
	                        </div>
  						<div class="clearfix"></div>
  	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="descripcion">Descripción</label>
	                            <textarea type="text" id="descripcion" class="form-control" rows="2" name="Descripcion" placeholder="Descripción"></textarea>
	                        </div>
	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="Recomendaciones">Recomendaciones</label>
	                            <textarea type="text" id="Recomendaciones" class="form-control" rows="2" name="Recomendaciones"  placeholder="Recomendaciones"></textarea>
	                        </div>

	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="LocalidadInicio">Localidad de inicio</label>
	                            <div class="input-group">
	                                <input name="LocalidadInicio" id="localidadinicio" class="form-control" required=""  type="text" placeholder="Localidad de inicio">
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="LocalidadFin">Localidad de fin</label>
	                            <div class="input-group">
	                                <input name="LocalidadFin" id="localidadfin" class="form-control" required="" type="text" placeholder="Localidad de fin">
	                            </div>
	                        </div>
							<div class="clearfix"></div>

	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="HoraInicio">Hora de inicio</label>
	                            <div class="input-group">
	                                <input name="HoraInicio" id="HoraInicio" class="form-control" required="" type="time" >
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="HoraFin">Hora de fin</label>
	                            <div class="input-group">
	                                <input name="HoraFin" id="HoraFin" class="form-control" required="" type="time" >
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="NumeroMinimoPersonas">Mínimo personas</label>
	                            <div class="input-group">
	                                <input name="NumeroMinimoPersonas" id="minpersonas" class="form-control" required="" type="number" placeholder="Mínimo personas">
	                            </div>
	                        </div>
	                        <div class="form-group col-lg-3 col-md-3">
	                            <label for="NumeroMaximoPersonas">Máximo personas</label>
	                            <div class="input-group">
	                                <input name="NumeroMaximoPersonas" id="maxpersonas" class="form-control" required="" type="number" placeholder="Máximo personas">
	                            </div>
	                        </div>
	                    </div>

	                    <div class="row">
							<div class="form-group col-lg-4 col-md-4">
								<label>Opciones adicionales:</label>
								<div class="input-group">
									<input type="checkbox" name="unique_passenger"> ¿Se pueden hacer reservas sólo con los datos del pasajero principal?
								</div>
							</div>

	                        <div class="form-group col-lg-12 col-md-12">
	                            <input value="Crear modelo y seguir completándolo" name="submit" class="btn btn-md btn-primary" type="submit">
	                        </div>
	                    </div>

	                    <?php echo form_close() ?>
	                </div>
                <?php } ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="banner">

                <div class="row">
					<div class="col-lg-8 col-md-8 col-md-offset-2">
						<div id="formBanner">
							<?php echo form_open_multipart(base_url('admin/models/updatebanner'), 'id="bannerId"') ?>
							<?php if (isset($modelID)) { ?>
								<input style='display:none;' name="modelId" id='modelLabel' value="<?php echo $modelID; ?>"/>
								<?php }; if (isset($modelInfo->banner)) { ?>
	                                <img class="image-shadow" width="840" height="240" src="<?php echo $modelInfo->banner; ?>"/>
	        					<?php } else { ?>
	                                <h6>No hay báner establecido</h6>
						        <?php } ?>
							<?php echo form_upload('userfile') ?>
							<?php echo form_submit('submit', 'Actualizar báner', "class='btn btn-primary btn-lg' id='updateBannerModel'") ?>
							<?php echo form_close() ?>
						</div>
					</div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="paradas">
                <div id="CompleteParadasContent">
                    <div class="row">
                        <div class='col-lg-4 col-md-4'>
                            <select id="selectSellersForParadas">
                                <?php if (is_array($all_sellers)) {
                                    foreach ($all_sellers as $seller) {
                                        echo "<option value='".$seller->id_vendedor."' >".$seller->nombre.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class='col-lg-3 col-md-3'>
                            <input type="button" class="btn btn-primary btn-lg addVendedor" value="Añadir Vendedor" />
                        </div>

                        <div style="margin-top: 24px;" class='col-lg-12 col-md-12'>
                            <form id="ParadasForm" method="post">
                                <div id="listado_paradas" >

                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <input id="crearParadasModelo" class="btn btn-primary btn-lg fullInput" value="Añadir las paradas de los vendedores">
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="precios">
                <div id="CompletePreciosContent">
                    <div class="row ">
                        <div class="col-md-6 col-lg-6 col-lg-offset-3 col-md-offset-3">
                            <div id="tabla-precios-defecto" class="well">
                                <!-- Aquí van a ir los precios por defecto (añadidas por JQuery con los precios establecidos) -->
                                    <div class="col-md-4 col-lg-4 ">
                                        <label>Tipo</label>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <label>Precio</label>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <label>Comisión</label>
                                    </div>
                                    <div class="col-md-2 col-lg-2">
                                        <label>Tipo Comisión</label>
                                    </div>

                                <div id="tablaPreciosDefecto" class="row">
                                    <?php if (is_array($all_type_clients)) {
                                        foreach ($all_type_clients as $precio) { ?>
                                        <div>
                                            <div class="col-md-4 col-lg-4">
                                                <input class="id_tipo_cliente" style="display: none;" value="<?php echo $precio->id_tipo_cliente; ?>">
                                                <label class="precio_nombre" ><?php echo $precio->nombre; ?></label>
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <input class="form-control precio"  type="text" placeholder="Precio">
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <input class="form-control comision"  type="text" placeholder="Comisión">
                                            </div>
                                            <div class="col-md-2 col-lg-2">
                                                <select class="form-control tipo_comision" name="tipo_comision">
                                                    <?php if (is_array($all_commissions)) {
                                                        foreach ($all_commissions as $comision) { ?>
                                                        <option value="<?php echo $comision->id_tipo_comision; ?>">  <?php echo $comision->nombre; ?>  </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php }
                                    } ?>
                                    <div class="col-md-12 col-lg-12">
                                        <input id="precioVendedoresBoton" name="submit" class="btn btn-primary btn-lg" value="Aplicar precios por defecto a todos los vendedores">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form id="listadoVendedoresYPreciosForm" method="post">
                            <?php if (is_array($all_sellers)) {
                                foreach ($all_sellers as $sellers) { ?>
                                    <div class="preciosVendedor col-md-4 col-lg-4 panel panel-default">
                                        <div class="text-center panel-heading">
                                            <input style="display: none" readonly="" name="idVendedor" type="text" value="<?php echo $sellers->id_vendedor; ?>">
                                            <h5 class="panel-title"><?php echo $sellers->nombre; ?></h5>
                                        </div>
                                        <?php if (is_array($all_type_clients)) {
                                            foreach ($all_type_clients as $precio) { ?>
                                            <div class="precios panel-body">
                                                <div class="col-md-4 col-lg-4">
                                                    <input class="id_tipo_cliente" name="idPrecio" style="display: none;" value="<?php echo $precio->id_tipo_cliente; ?>">
                                                    <label for="precio"><?php echo $precio->nombre; ?></label>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <input class="form-control precioOficial" name="precio" type="text" placeholder="Precio">
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <input class="form-control comisionOficial" name="comision" type="text" placeholder="Comisión">
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                    <select class="form-control tipoComisionOficial" name="tipo_comision">
                                                        <?php if (is_array($all_commissions)) {
                                                            foreach ($all_commissions as $comision) { ?>
                                                                <option value="<?php echo $comision->id_tipo_comision; ?>">  <?php echo $comision->nombre; ?>  </option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php }
                                        } ?>
                                    </div>
                                <?php }
                            } ?>
                            <div class="col-md-12 col-lg-12">
                                <input id="guardarPreciosComisionesModelo" type="button" name="submit" class="btn btn-primary btn-lg" value="Guardar todas las tarifas del modelo a los vendedores y finalizar">
                            </div>
                        </form>
                    </div>
                </div>
                <div id="finalizarBoton" style="display: none;" align="center" class="col-md-12 col-lg-12" >
                    <form role="form" action="<?php echo base_url('admin/dashboard'); ?>" method="post">
                        <button style="width: 240px;" class="btn btn-lg btn-info" type="submit">
                            <i class="fa fa-check-circle fa-2x pull-left"></i><div style="margin-top: 5px;"> Finalizar</div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
