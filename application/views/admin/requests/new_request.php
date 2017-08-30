<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-container">

    <div class="panel panel-default panel-properties">
        <div class="row">
            <form method="post" action="<?php echo base_url('admin/requests/createnewrequest'); ?>">
                <div class="form-group col-lg-5 col-md-5 col-lg-offset-1 col-md-offset-1">
                    <label for="Modelo">Asunto</label>
                    <div class="input-group">
                        <input class="form-control" name="asunto" required="" type="text" placeholder="Asunto del mensaje">
                    </div>
                </div>
                <div class="form-group col-lg-5 col-md-5 ">
                    <label for="Modelo">Vendedor</label>
                    <div class="input-group">
                        <select class="form-control" name="seller" required="" >
                            <option value="">Elija un vendedor...</option>
                            <?php if (is_array($all_sellers)) {
                                foreach ($all_sellers as $seller) { ?>
                                    <option value="<?php echo $seller->id_vendedor; ?>"> <?php echo $seller->nombre; ?>  </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">
                    <label for="peticion">Mensaje</label>
                    <div class="input-group">
                        <textarea type="text"  class="form-control" rows="2" name="descripcion" placeholder="Describa aquí su mensaje..."></textarea>
                    </div>
                </div>
                <div class="form-group col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">
                    <input value="Enviar Mensaje" name="submit" class="btn btn-md btn-primary" type="submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
