<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>
<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <form action="<?php echo base_url('admin/closeouts/showcloseouts'); ?>" method="post">
            <input style="display: none;" type="text" name="idSeller" value="<?php echo $idSeller; ?>">
            <div class="row">
                <div class='col-lg-3 col-md-3'>
                    <label>Desde (fecha emisión):</label>
                    <div class="input-group">
                        <input class="form-control" name="startDateBegin" type="date" <?php if ($startDateBegin != '') { echo "value='".$startDateBegin."'"; } ?> >
                    </div>
                </div>
                <div class='col-lg-3 col-md-3'>
                    <label>Hasta:</label>
                    <div class="input-group">
                        <input class="form-control" name="endDateBegin" type="date" <?php if ($endDateBegin != '') { echo "value='".$endDateBegin."'"; } ?> >
                    </div>
                </div>
                <?php if ($optionSelected == 2) { ?>
	                <div class="clearfix"></div>
	                <div class='col-lg-3 col-md-3 '>
	                    <label>Buscar desde (fecha cobro):</label>
	                    <div class="input-group">
	                        <input class="form-control" name="startDateEnd" type="date" <?php if ($startDateEnd != '') { echo "value='".$startDateEnd."'"; } ?> >
	                    </div>
	                </div>
	                <div class='col-lg-3 col-md-3'>
	                    <label>Hasta:</label>
	                    <div class="input-group">
	                        <input class="form-control" name="endDateEnd" type="date" <?php if ($endDateEnd != '') { echo "value='".$endDateEnd."'"; } ?> >
	                    </div>
	                </div>
                <?php } ?>
                <div class='col-lg-3 col-md-3'>
                    <label>Tipo:</label>
                    <div class="input-group">
                        <select class="form-control" name="optionSelected">
                            <option value="1" <?php if ($optionSelected == 1) { echo "selected='selected'"; } ?> >Pendiente de cobro
                            </option>
                            <option value="2" <?php if ($optionSelected == 2) { echo "selected='selected'"; } ?> >Liquidada
                            </option>
                        </select>
                    </div>
                </div>
                <div class='col-lg-2 col-md-2 col-lg-offset-1 col-md-offset-1'>
                    <div class="input-group">
                        <input class="btn btn-primary" value="Buscar" name="submit" type="submit">
                    </div>
                </div>

            </div>
        </form>

        <?php if ($optionSelected == 1) { ?>
        <div class="col-lg-12 col-md-12 text-right well" style="padding: 24px; margin-top: 40px;">
            <div class="col-lg-64 col-md-4 text-center">
                <form id="formConfirmCloseoutsDocuments" action="<?php echo base_url('admin/closeouts/closeoutpayment'); ?>" method="post">
                    <label style="font-weight: bold;">Fecha de cobro</label>
                    <input class="form-control" type="date" name="dateCloseout" id="dateCloseOutSelected">
                    <input style="display: none;" type="text" name="idCliente" value="<?php echo $idSeller; ?>">
                    <input style="display: none;" id="rowsSelected" name="closeoutSelected" type="text"/>
                </form>
            </div>
            <div class="col-lg-8 col-md-8">
                <button style="margin-left: 5px; margin-bottom: 5px;" id="makeLiquidacionesDocumentos" class="btn btn-warning btn-lg"> Liquidar elementos seleccionados
                </button>

                <button type="button" id="openModal" style="display:none" data-toggle="modal" data-target="#confirmarLiquidacionesModal">
                </button>
            </div>
        </div>
        <?php
	} ?>
        <form id="formCloseoutDocuments" action="<?php echo base_url('admin/closeouts/closeoutdocpdf'); ?>"
              method="post">

            <table id="tableCurrentPaymentsBookingList"
                   data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true" class="table table-striped table-hover"
				   data-show-filter="true" data-events="operateGeneratePDFCloseoutA">
                <thead>
                <tr>
                    <th data-field="checkbox" data-checkbox="true">CheckList</th>
                    <th data-sortable="true">Nº documento</th>
                    <th data-sortable="true">Fecha de emisión</th>
                    <?php if ($optionSelected == 2) { ?>
                        <th data-sortable="true">Fecha de cobro</th>
                    <?php } ?>
                    <th data-sortable="true">Nº reservas asociadas</th>
                    <th data-events="operateGeneratePDFCloseoutA">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php if (is_array($closeoutDocuments)) {
                    foreach ($closeoutDocuments as $closeout) { ?>
                        <tr>
                            <td></td>
                            <td data-booking="<?php echo $closeout->id_liquidacion; ?>"><?php echo $closeout->id_liquidacion; ?></td>
                            <td><?php echo $closeout->fecha_emision_liquidacion; ?></td>
                        <?php if ($optionSelected == 2) {
                            ?>
                            <td><?php  echo $closeout->fecha_cobro_liquidacion; ?></td>
                        <?php } ?>
                            <td><?php echo $closeout->totalReservasAsociadas; ?></td>
                            <td><input class="btn btn-primary" name="submitTable" type="submit" value="Generar PDF"></td>
                        </tr>
                        <?php }
                } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarLiquidacionesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5>¿Está seguro que desea realizar la liquidación de los documentos seleccionados?</h5>
            </div>
            <div class="modal-footer">
				<div class="col-lg-5 col-md-5" style="text-align: left;">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
				<div class="col-lg-4 col-md-4" style="padding-left: 0 !important;">
	                <button type="button" id="confirmLiquidacionesDocuments" class="btn btn-md btn-success">Confirmar liquidación de documentos </button>
				</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
