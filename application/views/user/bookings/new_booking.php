<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
			<div class="form-group col-lg-6 col-md-6 col-md-offset-6 text-right">
				<a href="<?php echo base_url('user/bookings/showbookings') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> Ver reservas</a>
			</div>
        </div>
		<ul class="nav nav-tabs show" id="vistaListaTab" role="tablist">

            <?php if (is_array($services_availables)) {
                $index = 0;
                $isActive = false;
                foreach ($services_availables as $serviceType) { ?>

                    <li role="presentation" <?php if (!$isActive) { ?> class="active" <?php $isActive = true;
                    } ?>>
                        <a href="#tab<?php echo $index; ?>" aria-controls="#tab<?php echo $index; ?>"
                           role="tab" data-toggle="tab"><?php echo $serviceType->nombre; ?>
                            <?php if ($serviceType->totalNumber) { ?>
                                <span class="badge"><?php echo $serviceType->totalNumber; ?></span>
                            <?php } ?>
                        </a>
                    </li>
                    <?php $index++;
                }

            } ?>
        </ul>
        <div class="tab-content" id="vistaListaContent">
            <?php if (is_array($services_availables)) {
                $index = 0;
                $isActive = false;
                foreach ($services_availables as $serviceType) { ?>
                    <div role="tabpanel"
                        <?php if (!$isActive) { ?>
                            class="tab-pane fade in active"
                            <?php $isActive = true;
                        } else { ?>
                            class="tab-pane fade"
                        <?php } ?>
                         id="tab<?php echo $index; ?>">
                        <?php if ($serviceType->totalNumber) { ?>
                            <div class="row" >
                                <?php if (is_array($serviceType->result)) {
                                    foreach ($serviceType->result as $service) { ?>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 text-center">
                                                            <div style="position: relative; left: 0; top: 0;">
                                                                <a href="<?php echo $service->foto; ?>" >
                                                                    <img class="image-shadow" style="position: relative; top: 0; left: 0;" src="<?php echo $service->foto; ?>" width="169" width="840" height="240" alt="<?php echo $service->nombre_servicio; ?>"/></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10 col-lg-10">
                                                            <div class="col-md-12 col-lg-12">
                                                                <div class="col-lg-8 col-md-8">
                                                                    <h5 style="color: #000000;font-weight: bold;"
                                                                        class="name_service"><?php echo $service->nombre_servicio; ?></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12">
                                                                <p style="display: none;"
                                                                   class="service"><?php echo $service->id_servicio; ?></p>
                                                                <p class="name_service"
                                                                   style="display: none;"><?php echo $service->nombre_servicio.", ".$service->fecha_comienzo; ?></p>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <p>Empieza el <strong><?php echo $service->fecha_comienzo_dia.", ".$service->fecha_comienzo; ?></strong> <br> Se permiten reservas hasta el <strong><?php echo $service->fecha_fin_reservas_dia.", ".$service->fecha_fin_reservas; ?></strong>
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4">
                                                                    <button class="btn btn-primary btn-lg more-details-button" name="submit" data-toggle="modal" data-target="#detailsservice"> Ver Más Detalles </button>
                                                                </div>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <p class="infoBooking">
                                                                    <?php if ($service->realizarReservas == 1 && $service->plazasRestantes > 0) { ?>
                                                                        Plazas disponibles: <?php echo $service->plazasRestantes; ?> de <?php echo $service->max_personas; ?>
                                                                    <?php } else if ($service->realizarReservas == 0)  { ?>
                                                                        Se ha terminado el plazo para realizar las reservas de este servicio.
                                                                    <?php } else if ($service->plazasRestantes == 0) { ?>
                                                                        Reservas bajo petición.
                                                                    <?php } ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4">
                                                                    <?php if ($service->realizarReservas == 1) { ?>
                                                                        <form class="formBookingService" method="post"
                                                                              action="<?php echo base_url('user/bookings/newbooking'); ?>">
                                                                            <button name="submit" class="btn btn-info btn-lg booking-button"> Reservar </button>
                                                                        </form>
                                                                    <?php } ?>
                                                                </div>
																<div class="col-lg-8 col-md-8" style="margin-top: 8px">
                                                                <?php if ($service->info_estado != "") { ?>
																	<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
																	<?php echo $service->info_estado; ?><br/>
                                                                <?php } ?>
																<?php if ($service->garantizada) { ?>
																	<i class="fa fa-check-circle fa-lg" aria-hidden="true"></i>
																	<span class="messageOK"> ¡Salida garantizada!</span>
                                                                <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <span>No hay ningún servicio disponible.</span>
                                </div>
                            </div>
                        <?php }
                        $index++;
                        ?>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="detailsservice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalTitle"></h4>
                <div id="loadingTabs" style="display: none;">
                    <form method="post" action="<?php echo base_url('user/requests/newrequest/'); ?>">
                        <div class="row">
                            <input id="requestTopic" name="asunto" style="display: none;" type="text"/>
                            <div class="col-md-12 col-lg-12 text-right">
                                <input type="submit" class="btn btn-info btn-lg" value="Enviar Mensaje"/>
                            </div>
                        </div>

                    </form>

                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active"><a href="#descripcionTab" aria-controls="descripcionTab"
                            role="tab" data-toggle="tab">General</a></li>
                        <li role="presentation"><a href="#infoTab" aria-controls="infoTab" role="tab" data-toggle="tab">Detalles</a>
                        </li>
                        <li role="presentation"><a href="#preciosTab" aria-controls="preciosTab" role="tab"
                        	data-toggle="tab">Precios</a></li>
                    </ul>
                    <div class="tab-content">
						<label style="display: none;" id="serviceIDModal"></label>
						<label style="display: none;" id="sellerIDModal"><?php echo $id_user; ?></label>
                        <div role="tabpanel" class="tab-pane active" id="descripcionTab">
							<div class="row">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="text-right"><strong>Descripción</strong></td>
                                        <td id="descripcion"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Recomendaciones</strong></td>
										<td id="recomendaciones"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="infoTab">
                            <div class="row">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="text-right"><strong>Código de referencia</strong></td>
                                        <td id="referencia"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Reservas</strong></td>
                                        <td> Hasta el <strong><span id="fechaFinValida"></span></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Comienzo </strong></td>
                                        <td> En <span id="localidadInicio" class="bold"></span>, el día <span id="fechaInicio" class="bold"></span> (hora según parada) </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Finalización</strong></td>
                                        <td> En <span id="localidadFin" class="bold"></span>, el día <span id="fechaFin" class="bold"></span><strong> a las </strong><span id="horaFin" class="bold"></span> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="preciosTab">
                            <table class='table table-striped table-hover'>
                                <thead>
                                <tr>
                                    <th>Tipo de reserva</th>
                                    <th>Precios</th>
                                </tr>
                                </thead>
                                <tbody id="preciosServicios">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
