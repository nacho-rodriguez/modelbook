<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">
    <div class="panel panel-default panel-properties">
	    <div class="row">
	        <div class="form-group col-lg-12 col-md-12 text-right">
	            <a href="<?php echo base_url('admin/sellers/showsellers') ?>" class="fa fa-archive fa-2x btn btn-lg btn-info"> Ver vendedores</a>
	        </div>
	    </div>

		<div class="row">
	        <label id="sellerLab" style="display: none;"><?php if (isset($id_seller)) { echo $id_seller;
	       } ?> </label>
	        <form id="formNewPreSeller" action="<?php echo base_url('admin/sellers/createseller'); ?>" method="post">
	            <div class="row">
	                <div class="form-group col-lg-1 col-md-1">
	                    <label for="CIF">CIF</label>
	                    <div class="input-group">
	                        <input name="CIF" id="CIF" class="form-control" required="" type="text" placeholder="CIF">
	                    </div>
	                </div>
	                <div class="form-group col-lg-3 col-md-3">
	                    <label for="Nombre">Nombre comercial</label>

	                    <div class="input-group">
	                        <input name="Nombre" class="form-control" required="" type="text" placeholder="Nombre comercial">
	                    </div>
	                </div>

	                <div class="form-group col-lg-4  col-md-4">
	                    <label for="Direccion">Dirección</label>
	                    <div class="input-group">
	                        <input name="Direccion" id="Direccion" class="form-control" required="" type="text" placeholder="Direccion">
	                    </div>
	                </div>
	                <div class="form-group col-lg-2 col-md-2">
	                    <label for="Poblacion">Población</label>

	                    <div class="input-group">
	                        <input name="Poblacion" class="form-control" required="" type="text" placeholder="Poblacion">
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
	                <div class="form-group col-lg-2 col-md-2">
	                    <label for="Email">Email </label>
	                    <div class="input-group">
	                        <input id="Email" name="Email" class="form-control" required="" type="email" placeholder="Email">
	                    </div>
	                </div>
	                <div class="form-group col-lg-2 col-md-2">
	                    <label for="Estado">Estado</label>
	                    <div class="input-group">
	                        <select id="estado_select" name="estado_select">
	                            <option value="0">Sin acceso</option>
	                            <option value="1" selected="selected">Con acceso</option>
	                        </select>
	                    </div>
	                </div>
	                <div class="form-group col-lg-4 col-md-4">
	                    <label for="Password">Contraseña</label>
	                    <div class="input-group">
	                        <input name="Password" class="form-control" required="" type="text" placeholder="Contraseña">
	                    </div>
	                </div>
	                <div class="form-group col-lg-12 col-md-12">
	                    <div class="input-group">
	                        <input type="checkbox" checked="checked" name="mostrar_info"> Mostrar información del vendedor al realizar la reserva impresa
	                    </div>
	                </div>
	                <div class="form-group col-lg-12 col-md-12">
	                    <input id="newPreSellerSubmit" value="Crear Vendedor" name="submit" class="btn btn-md btn-primary" type="submit">
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
