<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/user_nav');   ?>

<div class="main-container">

    <div class="panel panel-default panel-properties">
        <div class="row" style="margin-top: 48px;">
            <form method="post" action="<?php echo base_url('user/requests/createnewrequest');?>">
                <input style="display: none;" class="form-control" name="vendedor" type="text" value="<?php echo $id_user;?>">

                <div class="form-group col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">

                    <label for="Modelo">Asunto</label>
                    <div class="input-group">
                        <input class="form-control" name="asunto" required="" type="text" placeholder="Asunto del mensaje" value="<?php if (isset($result)) if ($result == 2) echo $asunto; ?>">
                    </div>

                </div>
                <div class="form-group col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">

                    <label for="peticion">Mensaje</label>
                    <div class="input-group">
                        <textarea type="text"  class="form-control" rows="2" name="descripcion" placeholder="Describa aquí su mensaje..."></textarea>
                    </div>

                </div>
                <div class="form-group col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
                    <input value="Enviar Mensaje" name="submit"
                           class="btn btn-md btn-primary" type="submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('partials/user_footer'); ?>
