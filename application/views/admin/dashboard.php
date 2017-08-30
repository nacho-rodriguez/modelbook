<?php $this->load->view('partials/admin_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/admin_nav'); ?>

<div class="main-menu-container">
    <div class="panel panel-default panel-properties">
        <div class="row">
            <div class="col-lg-3 col-md-3 text-center">
                <form role="button" action="<?php echo base_url('admin/models/newmodel'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-columns fa-2x"></i><br> <?php echo $string['msg_dashboard_modelos']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/services/createservice'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-list-alt fa-2x"></i><br> <?php echo $string['msg_dashboard_servicios']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/sellers/newseller'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-building fa-2x"></i><br> <?php echo $string['msg_dashboard_vendedores']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/clients/showclients'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-users fa-2x"></i><br> <?php echo $string['msg_dashboard_clientess']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/bookings/showlistbookings'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-ticket fa-2x"></i><br> <?php echo $string['msg_dashboard_reservas']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/closeouts/showsellers'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-dashboard fa-2x"></i><br> <?php echo $string['msg_dashboard_liquidaciones']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/requests/showrequests'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-envelope fa-2x"></i><br> <?php echo $string['msg_dashboard_mensajes']; ?></button>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 text-center">
                <form role="form" action="<?php echo base_url('admin/config/showconfig'); ?>" method="post">
                    <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                        <i class="fa fa-wrench fa-2x"></i><br> <?php echo $string['msg_dashboard_configuracion']; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partials/admin_footer'); ?>
