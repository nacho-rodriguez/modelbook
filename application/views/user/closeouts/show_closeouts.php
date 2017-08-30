<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/user_nav'); ?>

<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <form action="<?php echo base_url('user/closeouts/showcloseouts'); ?>" method="post">
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
                        <label>Desde (fecha cobro):</label>
                        <div class="input-group">
                            <input class="form-control" name="startDateEnd"
                                   type="date" <?php if ($startDateEnd != '') {
                                echo "value='".$startDateEnd."'";
                            } ?> >
                        </div>
                    </div>
                    <div class='col-lg-3 col-md-3'>
                        <label>Hasta:</label>
                        <div class="input-group">
                            <input class="form-control" name="endDateEnd"
                                   type="date" <?php if ($endDateEnd != '') {
                                echo "value='".$endDateEnd."'";
                            } ?> >
                        </div>
                    </div>
                <?php } ?>
                <div class='col-lg-3 col-md-3'>
                    <label>Tipo:</label>
                    <div class="input-group">
                        <select class="form-control" name="optionSelected">
                            <option value="1" <?php if ($optionSelected == 1) {
                                echo "selected='selected'";
                            } ?> >Pendiente de pago
                            </option>
                            <option value="2" <?php if ($optionSelected == 2) {
                                echo "selected='selected'";
                            } ?> >Liquidada
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

        <form id="formCloseoutDocuments" action="<?php echo base_url('admin/closeouts/closeoutdocpdf'); ?>" method="post">

            <table id="tableCloseoutDocuments" data-toggle="table" data-pagination="true" data-locale="es-SP" data-search="true"
			class="table table-striped table-hover" data-show-filter="true" data-events="operateGeneratePDFCloseoutU">
                <thead>
                <tr>
                    <th data-sortable="true">Nº documento</th>
                    <th data-sortable="true">Fecha de emisión</th>
                    <?php if ($optionSelected == 2) { ?>
                        <th data-sortable="true">Fecha de cobro</th>
                    <?php } ?>
                    <th data-sortable="true">Nº reservas asociadas</th>
                    <th data-events="operateGeneratePDFCloseoutU">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php if (is_array($closeoutDocuments)) {
                    foreach ($closeoutDocuments as $closeout) { ?>
                        <tr>
                            <td data-booking="<?php echo $closeout->id_liquidacion; ?>"><?php echo $closeout->id_liquidacion; ?></td>
                            <td><?php echo $closeout->fecha_emision_liquidacion; ?></td>
                            <?php if ($optionSelected == 2) { ?>
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

<?php $this->load->view('partials/user_footer'); ?>
