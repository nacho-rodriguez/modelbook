<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/user_nav');   ?>
<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-lg-offset-2 col-md-offset-2">
                <label for="Modelo"><b>Asunto</b></label>
                <div class="input-group">
                    <span><i><?php echo $requestInfo->asunto; ?></i></span>
                </div>

            </div>
            <div class="form-group col-lg-2 col-md-2">
                <label for="Modelo"><b>Estado</b></label>
                <div class="input-group">
                    <p><i><?php $status = ($requestInfo->estado == 0) ? 'Abierta' : 'Cerrada'; echo $status;?><i></p>
                </div>
            </div>
        </div>

        <div id="messagesListRequest" class="row">

            <?php
            if (is_array($requestInfo->messages)) {
                foreach ($requestInfo->messages as $message) {
            ?>
                <?php if ($message->tipo == 2) { ?>
                    <div class=" col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4">
                <?php } elseif ($message->tipo == 1) { ?>
                        <div class=" col-lg-6 col-md-6 col-lg-offset-2 col-md-offset-2">
                <?php }?>
                    <div class="well">
                        <span><?php echo $message->mensaje; ?></span></br>
                        <div style="width: 100%;text-align: right">

                        <span><?php echo date_format(date_create($message->fecha_hora), 'd/m/Y, H:i'); ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>

        <?php if ($requestInfo->estado == 0) {?>
            <div class="row">
                <input style="display: none;" id="requestID" name="peticionID" required="" type="text"
                       value="<?php echo $requestInfo->id_peticion; ?>">
                <div class="form-group col-lg-6 col-md-6 col-lg-offset-2 col-md-offset-2">
                    <div class="input-group">
                        <textarea type="text"  class="form-control" rows="2" name="mensaje" id="peticionMensaje"
                                  placeholder="Escriba aquí su mensaje..."></textarea>
                    </div>
                </div>

                <div class="form-group col-lg-2 col-md-2 ">
                    <input value="Enviar Mensaje" name="submit" id="enviarMensaje"
                           class="btn btn-lg btn-primary input-group" type="submit">
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
