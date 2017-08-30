<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="form-group col-lg-4 col-md-4 col-lg-offset-2 col-md-offset-2">
                <label for="Modelo"><b>Asunto</b></label>
                <div>
                    <span><i><?php echo $requestInfo->asunto; ?></i></span>
                </div>

            </div>
            <div class="form-group col-lg-2 col-md-2">
                <label for="Vendedor"><b>Vendedor</b></label>
                <div>

                    <span><i><?php echo $requestInfo->nombre; ?></i></span>
                </div>
            </div>

                <div class="form-group col-lg-2 col-md-2 text-right">
                    <?php if ($requestInfo->estado == 0) { ?>
                        <form action="<?php echo base_url('admin/requests/closerequest'); ?>" method="post">
                            <input style="display: none;" id="requestID" name="peticionID" required="" type="text"
                                   value="<?php echo $requestInfo->id_peticion; ?>">
                            <input value="Cerrar petición" name="action" id="cerrar"
                                   class="btn btn-lg btn-danger input-group" type="submit">
                        </form>
                    <?php } else
                        {?>
                            <label for="estado"><b>Estado</b></label>
                                <div>
                                    <span><i>Cerrada</i></span>
                                </div>
                    <?php } ?>
                </div>
        </div>

        <div id="messagesListRequest" class="row">
            <?php if (is_array($requestInfo->messages)) {
                foreach ($requestInfo->messages as $message) { ?>
                <?php if ($message->tipo == 2) { ?>
                    <div class=" col-lg-6 col-md-6 col-lg-offset-2 col-md-offset-2">
                <?php } elseif ($message->tipo == 1) { ?>
                    <div class=" col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4">
                <?php } ?>
                    <div class="well">
                        <span><?php echo $message->mensaje; ?></span></br>
                        <div style="width: 100%;text-align: right">
                            <span><?php echo date_format(date_create($message->fecha_hora), 'd/m/Y, H:i'); ?>
                        </div>
                    </div>
                </div>
                <?php }
            } ?>
            </div>
            <?php if ($requestInfo->estado == 0) {
                    ?>
                <div class="row">
                    <span style="display: none;" id="sellerID"><?php echo $requestInfo->vendedor_fk; ?></span>
                    <div class="form-group col-lg-6 col-md-6 col-lg-offset-2 col-md-offset-2">
                        <div class="input-group">
                            <textarea type="text"  class="form-control" rows="2" name="mensaje" id="peticionMensaje" placeholder="Escriba aquí su mensaje..."></textarea>
                        </div>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 ">
                        <input value="Enviar Mensaje" name="action" id="enviarMensaje" class="btn btn-lg btn-primary input-group" type="submit">
                    </div>
                </div>
            <?php } ?>
		</div>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
