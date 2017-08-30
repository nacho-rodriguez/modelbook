<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">1) Datos del servicio</a></li>
            <li role="presentation"><a href="#banner" aria-controls="banner" role="tab" data-toggle="tab">2) Báner</a></li>
            <li role="presentation"><a href="#paradas" aria-controls="paradas" role="tab" data-toggle="tab">3) Paradas del servicio</a></li>
            <li role="presentation"><a href="#precios" aria-controls="precios" role="tab" data-toggle="tab">4) Tabla de precios y comisiones</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div id="formUpdateModel">
                    <?php echo form_open_multipart(base_url('admin/services/updateservice')) ?>
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 text-center well">
                            <h4>Tipo de servicio</h4>

                            <?php foreach ($all_type_services as $typeService) { ?>
                                <input type="radio" name="typeService"
                                    <?php if ($typeService->id_tipo_servicio === $serviceInfo->tipo_servicio_fk) { echo "checked='checked'";
                                    } ?>
                                    value="<?php echo $typeService->id_tipo_servicio; ?>" />
                                <label style="margin-right: 40px;"><?php echo $typeService->nombre; ?></label>
                            <?php
                            }?>
                        </div>

                        <div class="form-group col-lg-4 col-md-4">
                            <input id="serviceID" name="serviceID" style="display: none;" value="<?php echo $serviceInfo->id_servicio; ?>">

                            <label for="Servicio">Código (Nombre del servicio)</label>

                            <div class="input-group">
                                <input class="form-control" id="inputModelo" name="Modelo" required="" type="text" placeholder="Código (Nombre del servicio)" value="<?php echo $serviceInfo->modelo; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4">
                            <label for="Titulo">Título </label>

                            <div class="input-group">
                                <input name="Titulo" id="Titulo" class="form-control" required="" type="text" placeholder="Título" value="<?php echo $serviceInfo->nombre; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4">

                            <img class="image-shadow" width="150" height="200" alt="foto_Servicio" src="<?php echo $serviceInfo->foto; ?>"/>
                            <input name="foto" style="display: none;" type="text" value="<?php echo $serviceInfo->foto; ?>">

                            <div class="input-group">
                                <input style="width: 100%;" name="userfile" type="file"/>
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="descripcion">Descripción</label>
                            <textarea type="text" id="descripcion" class="form-control" rows="2" name="Descripcion" placeholder="Descripción"><?php echo $serviceInfo->descripcion; ?></textarea>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="Recomendaciones">Recomendaciones</label>
                            <textarea type="text" id="Recomendaciones" class="form-control" rows="2" name="Recomendaciones" placeholder="Recomendaciones"><?php echo $serviceInfo->recomendaciones; ?></textarea>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="LocalidadInicio">Localidad de inicio</label>

                            <div class="input-group">
                                <input name="LocalidadInicio" id="localidadinicio" class="form-control" required="" type="text" placeholder="Localidad de inicio" value="<?php echo $serviceInfo->localidad_inicio; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="LocalidadFin">Localidad de fin</label>
                            <div class="input-group">
                                <input name="LocalidadFin" id="localidadfin" class="form-control" required="" type="text" placeholder="Localidad de fin" value="<?php echo $serviceInfo->localidad_fin; ?>">
                            </div>
                        </div>
						<div class="clearfix"></div>

                        <div class="form-group col-lg-3 col-md-3">
                            <label for="HoraInicio">Hora de inicio</label>
                            <div class="input-group">
                                <input name="HoraInicio" id="HoraInicio" class="form-control" required="" type="time" value="<?php echo $serviceInfo->hora_inicio; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="HoraFin">Hora de fin</label>
                            <div class="input-group">
                                <input name="HoraFin" id="HoraFin" class="form-control" required="" type="time" value="<?php echo $serviceInfo->hora_fin; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="NumeroMinimoPersonas">Mínimo personas</label>
                            <div class="input-group">
                                <input name="NumeroMinimoPersonas" id="minpersonas" class="form-control" required="" type="number" placeholder="Mínimo personas" value="<?php echo $serviceInfo->min_personas; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="NumeroMaximoPersonas">Máximo personas</label>
                            <div class="input-group">
                                <input name="NumeroMaximoPersonas" id="maxpersonas" class="form-control" required="" type="number" placeholder="Máximo personas" value="<?php echo $serviceInfo->max_personas; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
						<div class="form-group col-lg-4 col-md-4">
                            <label>Opciones adicionales:</label>
                            <div class="input-group">
                                <input type="checkbox" <?php if ($serviceInfo->unique_passenger == 1) echo "checked='checked'"; ?> name="unique_passenger"> ¿Se pueden hacer reservas sólo con los datos del pasajero principal?
                            </div>
                        </div>
						<div class="form-group col-lg-2 col-md-2 col-lg-offset-6 col-md-offset-6">
							<label for="estado">Estado </label>

							<div class="input-group">
								<select name="Estado" id="estado">
									<option value="0" <?php if ($serviceInfo->estado == 0) {
											echo "selected='selected'";
									   } ?> >
										Cerrado
									</option>
									<option value="1" <?php if ($serviceInfo->estado == 1) {
											echo "selected='selected'";
									   } ?> >
										Abierto
									</option>
									<option value="2" <?php if ($serviceInfo->estado == 2) {
											echo "selected='selected'";
									   } ?> >
										Anulado
									</option>
								</select>
							</div>
					<span id="cancelOptionMessage" style="display: none;"> <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> <strong>También se anularán las reservas realizadas.</strong> </span>
						</div>
					</div>

					<div class="row">
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="referencia">Código de referencia</label>

                            <div class="input-group">
                                <input name="Referencia" id="referencia" class="form-control" required="" type="text" placeholder="Código de referencia" value="<?php echo $serviceInfo->referencia; ?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-3">
                            <label for="FechaInicio">Fecha de inicio</label>
                            <div class="input-group">
                                <input name="FechaInicio" size="35" id="FechaInicio" class="form-control" required="" type="date" value="<?php echo $serviceInfo->fecha_inicio;?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="FechaFin">Fecha de fin</label>
                            <div class="input-group">
                                <input name="FechaFin" size="35" id="FechaFin" class="form-control" required="" type="date" value="<?php echo $serviceInfo->fecha_fin; ?>">
                            </div>
                        </div>
					</div>

					 <div class="row">
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="infoestado">Información rápida sobre estado del servicio</label>
                            <div class="input-group">
                                <input name="InfoEstado" id="infoestado" class="form-control" type="text" placeholder="Información rápida sobre estado del servicio" value="<?php echo $serviceInfo->info_estado; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="fechaReservasInicio">Fecha de reservas inicial</label>
                            <div class="input-group">
                                <input name="fechaReservasInicio" id="fechaReservasInicio" class="form-control" required="" type="date" value="<?php echo $serviceInfo->fecha_inicio_valido; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="fechaReservasFin">Fecha de reservas final</label>

                            <div class="input-group">
                                <input name="fechaReservasFin" id="fechaReservasFin" class="form-control" required="" type="date" value="<?php echo date_format(date_create($serviceInfo->fecha_fin_valido), 'Y-m-d');?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12">
                            <input value="Actualizar Servicio" name="submit" class="btn btn-md btn-primary" type="submit">
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="banner">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-md-offset-2">
                        <div id="formBanner">
                            <?php echo form_open_multipart(base_url('admin/services/updatebanner'), 'id="bannerId"') ?>
                            <?php if (isset($serviceID)) { ?>
                                <input style='display:none;' name="serviceId" id='serviceLabel' value="<?php echo $serviceID; ?>"/>
                            <?php }
							if (isset($serviceInfo->banner) && $serviceInfo->banner != '') { ?>
                                <img width="840" height="240" alt="foto_banner" src="<?php echo $serviceInfo->banner; ?>"/>
                            <?php } else { ?>
								<h6>No hay báner establecido</h6>
							<?php } ?>
							<?php echo form_upload('userfile') ?>
							<?php echo form_submit('submit', 'Actualizar báner', "class='btn btn-primary btn-lg' id='updateBannerService'") ?>
							<?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="paradas">
                <div id="CompleteParadasContent">
                    <div class="row">
                        <div>
                            <div class='col-lg-4 col-md-4'>
                                <select id="selectSellersForParadas">
                                    <?php if (is_array($sellers_saved_paradas)) {
                                        foreach ($sellers_saved_paradas as $seller) {
                                            echo "<option value='".$seller->id_vendedor."' >".$seller->nombre.'</option>';
                                        } } ?>
                                </select>
                            </div>

                            <div class='col-lg-3 col-md-3'>
                                <input type="button" class="btn btn-primary btn-lg addVendedor" value="Añadir vendedor"/>
                            </div>

                            <div style="margin-top: 24px;" class='col-lg-12 col-md-12'>
                                <form id="ParadasForm" method="post">
                                    <div id="listado_paradas">

                                        <?php if (is_array($serviceInfo->paradasServicio)) {
                                            $i = 0;
                                            $paradaVendedor = $serviceInfo->paradasServicio;
                                            while ($i < count($paradaVendedor)) {
                                                $id_seller_actual = $paradaVendedor[$i]->id_vendedor; ?>
                                                <div>
                                                    <div class='col-lg-4 col-md-4 text-center'>
                                                        <span> <?php echo $paradaVendedor[$i]->nombre_vendedor; ?> </span>
                                                        <input name='sellerId' style='display:none;' value='<?php echo $id_seller_actual; ?>'/>
                                                    </div>
                                                    <div class='col-lg-2 col-md-2 addParadaVendedor'>
                                                        <a class='btn btn-warning' style='width: 60px;'><i class='fa fa-plus fa-lg'></i> </a>
                                                    </div>
                                                    <div class='col-lg-6 col-md-6 '>
                                                        <?php $id_seller_parada_procesada = $id_seller_actual;
                                                        while ($id_seller_actual == $id_seller_parada_procesada && $i < count($paradaVendedor)) { ?>
                                                            <div>
                                                                <div class='col-lg-3 col-md-3'>
                                                                    <input class='form-control' name='hora' type='time' value="<?php echo $paradaVendedor[$i]->hora; ?>"/>
                                                                </div>
                                                                <div class='col-lg-8 col-md-8'>
                                                                    <input class='form-control' placeholder='Lugar de la parada'
                                                                           name='parada' type='text' value="<?php echo $paradaVendedor[$i]->parada; ?>"/>
                                                                </div>
                                                                <div class='col-lg-1 col-md-1'>
                                                                    <a class='btn btn-danger deleteParada' style='width: 60px;'><i class='fa fa-times fa-lg'></i> </a>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            ++$i;
                                                            if ($i < count($paradaVendedor)) {
                                                                $id_seller_parada_procesada = $paradaVendedor[$i]->id_vendedor;
                                                            }
                                                        } ?>
                                                    </div>
                                                    <div class='col-lg-12 col-md-12'>
                                                        <hr>
                                                    </div>
                                                </div>
											<?php }
                                        } ?>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <input id="actualizarParadasServicio" class="btn btn-primary btn-lg fullInput" value="Actualizar paradas de los vendedores">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="precios">
                <div id="CompletePreciosContent">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-lg-offset-3 col-md-offset-3">
                            <div id="tabla-precios-defecto" class="well">
                                <!-- Aquí van a ir los precios por defecto (añadidas por JQuery con los precios establecidos) -->
                                <div class="row">
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

                                <div id="tablaPreciosDefecto" class="row">
                                    <?php if (is_array($all_type_clients)) {
                                        foreach ($all_type_clients as $precio) { ?>
                                            <div>
                                                <div class="col-md-4 col-lg-4">
                                                    <input class="id_tipo_cliente" style="display: none;"
                                                           value="<?php echo $precio->id_tipo_cliente; ?>">
                                                    <label class="precio_nombre"><?php echo $precio->nombre; ?></label>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <input class="form-control precio" type="text" placeholder="Precio">
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <input class="form-control comision" type="text"
                                                           placeholder="Comisión">
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
                                        <input id="precioVendedoresBoton" name="submit" class="btn btn-primary btn-lg" value="Aplicar precio por defecto a todos los vendedores">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form id="listadoVendedoresYPreciosForm" method="post">
                            <?php if (is_array($serviceInfo->preciosComisionesServicio)) {
                                foreach ($serviceInfo->preciosComisionesServicio as $sellers) { ?>
                                    <div class="preciosVendedor col-md-4 col-lg-4 panel panel-default">
                                        <div class="text-center panel-heading">
                                            <input style="display: none" readonly="" name="idVendedor" type="text" value="<?php echo $sellers->id_vendedor; ?>">
                                            <h5 class="panel-title"><?php echo $sellers->nombre; ?></h5>
                                        </div>
                                        <?php if (is_array($sellers->preciosComisiones) && count($sellers->preciosComisiones) > 0) {
                                            foreach ($sellers->preciosComisiones as $precio) { ?>
                                                <div class="precios panel-body">
                                                    <div class="col-md-4 col-lg-4">
                                                        <input class="id_tipo_cliente" name="idPrecio" style="display: none;" value="<?php echo $precio->id_tipo_cliente; ?>">
                                                        <label for="precio"><?php echo $precio->tipo_cliente; ?></label>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3">
                                                        <input class="form-control precioOficial" name="precio" type="text" placeholder="Precio" value="<?php echo $precio->valor_monetario; ?>">
                                                    </div>
                                                    <div class="col-md-3 col-lg-3">
                                                        <input class="form-control comisionOficial" name="comision" type="text" placeholder="Comisión" value="<?php echo $precio->comision; ?>">
                                                    </div>
                                                    <div class="col-md-2 col-lg-2">
                                                        <select class="form-control tipoComisionOficial" name="tipo_comision">
                                                            <?php if (is_array($all_commissions)) {
                                                                foreach ($all_commissions as $comision) { ?>
                                                                    <option value="<?php echo $comision->id_tipo_comision; ?>" <?php if ($precio->tipo_comision_fk == $comision->id_tipo_comision) { echo "selected='selected'"; } ?> > <?php echo $comision->nombre; ?> </option>
																<?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
											<?php }
                                        } else {
                                            if (is_array($all_type_clients)) {
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
                                            }
                                        } ?>
                                    </div>
								<?php }
                            } ?>
                            <div class="col-md-12 col-lg-12">
                                <input id="actualizarPreciosComisionesServicio" type="button" name="submit" class="btn btn-primary btn-lg" value="Actualizar precios y comisiones al servicio">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
