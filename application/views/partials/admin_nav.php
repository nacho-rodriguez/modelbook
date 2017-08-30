<div id="header-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top fondo-transparente-menu">
        <div class="row">
            <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4 text-left">
                <?php if (!isset($iAmInTheMainPanel)) { ?>
                    <?php if (!isset($codeBack)) { ?>
                        <div class="inlineDiv" style="margin-left: 12px;">
							<a href="<?php echo site_url($backRoute); ?>" class="fa fa-arrow-left fa-2x btn btn-warning" role="button"></a>
                        </div>
                        <!-- If I have come from booking service list-->
                    <?php } elseif ($codeBack == 1) { ?>
                        <div class="inlineDiv" style="margin-left: 12px;">
							<form role="form" action="<?php echo site_url('admin/bookings/showbookings'); ?>" method="post">
								<input type="text" name="idService" style="display:none;" value="<?php echo $idService; ?>"/>
								<input type="text" name="nameService" style="display:none;" value="<?php echo $nameService; ?>"/>
								<button class="btn btn-lg btn-warning" type="submit">
									<i class="fa fa-arrow-left fa-2x"></i>
								</button>
							</form>
                        </div>
                    <?php } elseif ($codeBack == 2) { ?>
                        <div class="inlineDiv" style="margin-left: 12px;">
							<form role="form" action="<?php echo site_url('admin/closeouts/detailscloseouts'); ?>" method="post">
								<input style="display: none;" type="text" name="idSeller" value="<?php echo $idSeller; ?>">
								<button class="btn btn-lg btn-warning" type="submit">
									<i class="fa fa-arrow-left fa-2x"></i>
								</button>
							</form>
                        </div>
					<?php } elseif ($codeBack == 3) { ?>
                        <div class="inlineDiv" style="margin-left: 12px;">
							<form role="form" action="<?php echo site_url('admin/sellers/detailsseller'); ?>" method="post">
								<input style="display: none;" type="text" name="seller" value="<?php echo $seller; ?>">
								<button class="btn btn-lg btn-warning" type="submit">
									<i class="fa fa-arrow-left fa-2x"></i>
								</button>
							</form>
                        </div>
					<?php } elseif ($codeBack == 4) { ?>
						<div class="inlineDiv" style="margin-left: 12px;">
							<form role="form" action="<?php echo site_url('admin/clients/showclients'); ?>" method="post">
								<input style="display: none;" type="text" name="idCliente" value="<?php echo $idCliente; ?>">
								<button class="btn btn-lg btn-warning" type="submit">
									<i class="fa fa-arrow-left fa-2x"></i>
								</button>
							</form>
						</div>
					<?php }
				} ?>
                <?php if (!isset($iAmInTheMainPanel)) { ?>
                    <div class="inlineDiv" style="margin-left: 12px;">
                        <a href="<?php echo base_url('admin/dashboard') ?>" class="fa fa-home fa-2x btn btn-success" role="button"></a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4 text-center">
                <?php if (isset($title)) { ?>
                    <h4 class="text-center"> <?php echo $title; ?></h4>
                <?php } ?>
            </div>
            <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4 text-right">
                <?php if (!isset($iAmInTheMainPanel)) { ?>
                    <div class="inlineDiv" style="margin-left: 12px;">
                        <a href="<?php echo base_url('admin/requests/showrequests') ?>" class="fa fa-envelope fa-2x btn btn-info" role="button"></a>
                    </div>
                <?php } else {?>
                    <div class="inlineDiv" style="margin-left: 12px;">
                        <a href="<?php echo base_url('language/switchlang') ?>" class="fa fa-language fa-2x btn btn-info" role="button"> </a>
                    </div>
                <?php }?>
                <div class="inlineDiv" style="margin-left: 12px;">
                    <a href="<?php echo base_url('users/closesession') ?>" class="fa fa-sign-out fa-2x btn btn-danger" role="button"></a>
                </div>
            </div>
        </div>
    </nav>
</div>

<?php $this->load->view('partials/validation_errors'); ?>
