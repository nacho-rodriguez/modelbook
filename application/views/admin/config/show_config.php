<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="form-group col-lg-6 col-md-6">
                <a href="<?php echo base_url('admin/typeservices/showtypeservices') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> <?php echo $string['msg_config_tiposservicio']; ?></a>
            </div>
            <div class="form-group col-lg-6 col-md-6 text-right">
                <a href="<?php echo base_url('admin/typeclients/showtypeclients') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> <?php echo $string['msg_config_tiposclientes']; ?></a>
            </div>
        </div>

        <ul class="nav nav-tabs nav-justified" id="servicetabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo $string['msg_config_infoempresa']; ?></a></li>
            <li role="presentation"><a href="#banner" aria-controls="banner" role="tab" data-toggle="tab"><?php echo $string['msg_config_bannerempresa']; ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <form id="formUpdateConfig" action="<?php echo base_url('admin/config/updateconfig'); ?>" method="post">
                    <div class="row">

						<div class="form-group col-lg-2 col-md-2">
                            <label for="Empresa"><?php echo $string['msg_config_empresa']; ?></label>

                            <div class="input-group">
                                <input name="Empresa" id="Empresa" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_empresa']; ?>" value="<?php echo $configData->empresa; ?>">
                            </div>
                        </div>
						<div class="form-group col-lg-2 col-md-2">
							<label for="CI"><?php echo $string['msg_config_ci']; ?></label>
							<div class="input-group">
								<input name="CI" class="form-control" required="" type="text"
									   placeholder="<?php echo $string['msg_config_ci']; ?>" value="<?php echo $configData->codigo_identificacion; ?>">
							</div>
						</div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="CIF"><?php echo $string['msg_config_nif']; ?></label>

                            <div class="input-group">
                                <input name="CIF" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_nif']; ?>" value="<?php echo $configData->cif; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Direccion"><?php echo $string['msg_config_direccion']; ?></label>

                            <div class="input-group">
                                <input name="Direccion" id="Direccion" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_direccion']; ?>" value="<?php echo $configData->direccion; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Poblacion"><?php echo $string['msg_config_poblacion']; ?></label>

                            <div class="input-group">
                                <input name="Poblacion" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_poblacion']; ?>" value="<?php echo $configData->poblacion; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Provincia"><?php echo $string['msg_config_provincia']; ?></label>

                            <div class="input-group">
                                <input name="Provincia" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_provincia']; ?>" value="<?php echo $configData->provincia; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="Telefono"><?php echo $string['msg_config_telefono']; ?></label>

                            <div class="input-group">
                                <input name="Telefono" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_telefono']; ?>" value="<?php echo $configData->telefono; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3">
                            <label for="Email"><?php echo $string['msg_config_email']; ?></label>
                            <div class="input-group">
                                <input name="Email" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_email']; ?>" value="<?php echo $configData->email_empresa; ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-lg-offset-5 col-md-offset-5">
                            <label for="contador"><?php echo $string['msg_config_contador']; ?></label>
                            <div class="input-group">
                                <input name="contador" class="form-control" required="" type="text"
                                       placeholder="<?php echo $string['msg_config_contador']; ?>" value="<?php echo $configData->contador ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12">
                            <input name="submit" type="submit" class="btn btn-primary btn-lg" value="<?php echo $string['msg_config_actualizarinfo']; ?>"/>
                        </div>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="banner">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-md-offset-2">
                        <div id="formBanner">
                            <?php if (isset($configData->logo)) { ?>
                                    <img width="840" height="240" src="<?php echo $configData->logo; ?>"/>
                            <?php } else { ?>
                                <h6><?php echo $string['msg_config_nohaybanner']; ?></h6>
                            <?php } ?>
                            <div class="form-group">
                                <?php echo form_open_multipart(base_url('admin/config/updatelogo')) ?>
                                <?php echo form_upload('userfile') ?>
                                <?php echo form_submit('submit', $string['msg_config_actualizabanner'], "class='btn btn-primary btn-lg'") ?>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
