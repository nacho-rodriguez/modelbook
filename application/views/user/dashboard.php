<?php $this->load->view('partials/user_head'); ?>
<!--?php echo basename(__FILE__, '.php');  ?-->

</head>
<body>
<?php  $this->load->view('partials/user_nav'); ?>

    <div class="main-menu-container">
        <div class="panel panel-default panel-properties">

            <div class="row">
                <div class="col-lg-4 col-md-4 text-center">
                    <form role="form" action="<?php echo base_url('user/bookings/showservices'); ?>" method="post">
                        <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
							<i class="fa fa-ticket fa-2x"></i><br> <?php echo $string['msg_dashboard_serviciosyreservas']; ?></button>
                    </form>
				</div>
                <div class="col-lg-4 col-md-4 text-center">
                    <form role="form" action="<?php echo base_url('user/closeouts/detailscloseouts'); ?>" method="post">
                        <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                            <i class="fa fa-dashboard fa-2x"></i><br> <?php echo $string['msg_dashboard_liquidaciones']; ?></button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <form role="form" action="<?php echo base_url('user/requests/showrequests'); ?>" method="post">
                        <button class="btn btn-lg btn-primary main-menu-buttons" type="submit">
                            <i class="fa fa-envelope fa-2x"></i><br> <?php echo $string['msg_dashboard_mensajes']; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('partials/user_footer'); ?>
