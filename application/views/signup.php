<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

<link href="<?php echo base_url("/assets/css/login.less"); ?>" rel="stylesheet/less">

</head>
<body>
<div style="margin-top: 80px;" class="row margin-title">
    <div class="col-lg-12 col-md-12 text-center box">
        <h1 style="color: #ffffff;">Nuevo vendedor</h1>
    </div>
</div>
<?php $this->load->view('partials/validation_errors'); ?>
<div class="main-container">
    <div class="panel panel-default panel-properties box-inverse">
        <form id="formNewPreSeller" action="<?php echo base_url('users/signup'); ?>" method="post">
            <div class="row">
                <div class="form-group col-lg-2 col-md-2">
                    <label for="CIF">CIF</label>
                    <div class="input-group">
                        <input name="CIF" id="CIF" class="form-control" type="text" placeholder="CIF">
                    </div>
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label for="Nombre">Nombre comercial</label>
                    <div class="input-group">
                        <input name="Nombre" class="form-control" required="" type="text" placeholder="Nombre comercial">
                    </div>
                </div>
                <div class="form-group col-lg-3  col-md-3">
                    <label for="Direccion">Dirección</label>
                    <div class="input-group">
                        <input name="Direccion" id="Direccion" class="form-control" required="" type="text"
                               placeholder="Dirección">
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="Poblacion">Población</label>
                    <div class="input-group">
                        <input name="Poblacion" class="form-control" required="" type="text" placeholder="Población">
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="Provincia">Provincia</label>
                    <div class="input-group">
                        <input name="Provincia" class="form-control" required="" type="text" placeholder="Provincia">
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="Telefono">Teléfono</label>
                    <div class="input-group">
                        <input name="Telefono" class="form-control" required="" type="text" placeholder="Teléfono">
                    </div>
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label for="Email">Email</label>

                    <div class="input-group">
                        <input name="Email" class="form-control" required="" type="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="Password">Contraseña</label>
                    <div class="input-group">
                        <input name="Password" class="form-control" required="" type="password"
                               placeholder="Contraseña">
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="RepitaPassword">Repita su contraseña</label>
                    <div class="input-group">
                        <input name="RepitaPassword" class="form-control" required="" type="password"
                               placeholder="Repita su contraseña">
                    </div>
                </div>
                <div class="form-group col-lg-12 col-md-12">
                    <input id="newPreSellerSubmit" name="submit" id="submit" value="Enviar datos del vendedor"
                           class="btn btn-primary" type="submit">
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('partials/footer'); ?>
