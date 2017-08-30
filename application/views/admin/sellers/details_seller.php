<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <ul class="nav nav-tabs nav-justified" id="sellerstab" role="tablist">
            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"> 1) Información del vendedor.</a></li>
            <li role="presentation" ><a href="#preciosycomisiones" aria-controls="preciosycomisiones" role="tab" data-toggle="tab"> 2) Precios y comisiones de los servicios disponibles.</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="info">
                <label id="sellerLab" style="display: none;"><?php if (isset($id_seller)) { echo $id_seller;
               } ?> </label>
                <form id="formUpdateSeller" action="<?php echo base_url('admin/sellers/updateseller'); ?>" method="post">
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="CIF">CIF</label>
                            <div class="input-group">
                                <input style="display: none;" name="idSeller" class="form-control" type="text" value="<?php echo $currentSeller->id_vendedor; ?>">
                                <input name="CIF" id="CIF" class="form-control" required="" type="text" placeholder="CIF" value="<?php echo $currentSeller->cif; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="Nombre">Nombre comercial</label>

                            <div class="input-group">
                                <input name="Nombre" class="form-control" required="" type="text" placeholder="Nombre comercial" value="<?php echo $currentSeller->nombre; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="Direccion">Dirección</label>
                            <div class="input-group">
                                <input name="Direccion" id="Direccion" class="form-control" required="" type="text" placeholder="Dirección" value="<?php echo $currentSeller->direccion; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Poblacion">Población</label>

                            <div class="input-group">
                                <input name="Poblacion" class="form-control" required="" type="text" placeholder="Población" value="<?php echo $currentSeller->poblacion; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Provincia">Provincia</label>

                            <div class="input-group">
                                <input name="Provincia" class="form-control" required="" type="text" placeholder="Provincia" value="<?php echo $currentSeller->provincia; ?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Telefono">Teléfono</label>

                            <div class="input-group">
                                <input name="Telefono" class="form-control" required="" type="text" placeholder="Teléfono" value="<?php echo $currentSeller->telefono; ?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-3">
                            <label for="Email">Email </label>

                            <div class="input-group">
                                <input id="Email" name="Email" class="form-control" required="" type="email" placeholder="Email"  value="<?php echo $currentSeller->email; ?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Estado">Estado</label>
                            <div class="input-group">
                                <select id="estado_select" name="estado_select">
                                    <option value="0"  <?php  if ($currentSeller->estado == 0) {
                                        echo "selected='selected'";
                                   } ?> >Sin acceso</option>
                                    <option value="1"  <?php  if ($currentSeller->estado == 1) {
                                        echo "selected='selected'";
                                   } ?> >Con acceso</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-md-12">
                            <div class="input-group">
                                <span><?php $currentSeller->mostrar_info_reserva; ?></span>
                                <input type="checkbox" <?php if ($currentSeller->mostrar_info_reserva == 1) { echo "checked='checked'"; } ?> name="mostrar_info"> Mostrar información del vendedor al realizar la reserva impresa
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12">
                            <input id="updateSellerSubmit" value="Actualizar vendedor" name="submit" class="btn btn-md btn-primary" type="submit">
                        </div>

                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="preciosycomisiones">

                <form id="formListServices" action="<?php echo base_url('admin/sellers/showprices'); ?>" method="post">
                    <table data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
        				class="table table-striped table-hover" data-show-filter="true" data-events="operateEvents">
                        <thead>
                        <tr>
                            <th data-sortable="true">Código de referencia</th>
                            <th data-sortable="true">Título</th>
                            <th data-sortable="true">Fecha de inicio</th>
                            <th data-sortable="true">Fecha fin</th>
                            <th data-events="operateEvents">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($services_availables)) {
                            foreach ($services_availables as $service) { ?>
                                <tr>
                                    <td data-service="<?php echo $service->id_servicio ?>"><?php echo $service->referencia ?></td>
                                    <td><?php echo $service->nombre ?></td>
                                    <td><?php echo $service->fecha_comienzo; ?></td>
                                    <td><?php echo $service->fecha_finalizacion; ?></td>
                                    <td><input class="btn btn-primary" name="submitTable" type="submit" value="Ver precios"> </td>
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
