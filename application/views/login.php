<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

<link href="<?php echo base_url("/assets/css/login.less"); ?>" rel="stylesheet/less">

</head>
<body>
<div style="margin-top: 80px;" class="row margin-title">
    <div class="col-lg-12 col-md-12 text-center box">
        <h1 style="color: #ffffff;">Acceso a ModelBook</h1>
    </div>
</div>
<?php $this->load->view('partials/validation_errors'); ?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-8 col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2 box-inverse">
        <form role="form" action="<?php echo base_url('users/login'); ?>" method="post">
            <div class="form-group">
                <label for="InputLogin">Usuario (email)</label>
                <div class="input-group">
                    <input class="form-control" name="InputLogin" id="InputLogin" placeholder="Usuario (email)" required=""
                           typeee="">
                </div>
            </div>
            <div class="form-group">
                <label for="InputPassword">Contraseña</label>
                <div class="input-group">
                    <input class="form-control" name="InputPassword" id="InputPassword" placeholder="Contraseña"
                           required="" type="password">
                </div>
            </div>

            <div class="padding-vertical">
                <a href="#" data-toggle='modal' data-target='#forgotPasswordModal'>¿Ha olvidado su contraseña?</a><br>
                <span>Si desea registrarse como nuevo vendedor,
                    <a href="<?php echo base_url('users/newseller'); ?>">pulse aquí</a></span>
            </div>
            <div class="submit-container">
                <input name="submit" id="submit" value="Acceder" class="btn btn-primary" type="submit">
            </div>
        </form>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5>Ponga su correo electrónico y le enviaremos un email para que pueda reestablecer su contraseña.</h5>
            </div>
            <div class="modal-body">
                <div style="padding-top:0px; padding-bottom: 8px;" class="row">
                    <form role="form" action="<?php echo base_url('users/forgotpassword'); ?>" method="post">
                        <input class="form-control" name="Email" placeholder="Introduzca su email ..." required="required" type="email">
                        <input name="submit" id="submit" value="Enviar" class="btn btn-md btn-primary" type="submit">
                    </form>
                </div>
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-8 col-md-8" style="text-align: left;">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<?php $this->load->view('partials/footer'); ?>
