<html>
<body>
	<div class="row">
	    <?php if ($companyData->logo != '') { ?>
	        <div class="col-lg-12 col-md-12" align="center">
	            <img src="<?php echo $companyData->logo; ?>" alt="Logo" width="840" height="240">
	        </div>
	    <?php }?>
	</div>
	<div class="container">
	    <div class="row">
	        <div style="padding-left: 250px; padding-top: 25px;" class="text-right">
	            <div class="well">
	                <span><strong><?php echo $sellerData->nombre; ?></strong></span><br>
	                <span><?php echo $sellerData->direccion; ?></span><br>
	                <span><?php echo $sellerData->poblacion.' ('.$sellerData->provincia.')'; ?></span><br>
	                <span><?php echo 'Tlf: '.$sellerData->telefono.' - Email: '.$sellerData->email; ?></span>
	            </div>
	        </div>
	        <?php if (is_array($resumenInfo['servicios']) && count($resumenInfo['servicios']) > 0) {
	            foreach ($resumenInfo['servicios'] as $servicio) { ?>

	                <div class="panel panel-default ">
	                    <div class="panel-heading text-center">
	                        <h3>Servicio: <?php echo $servicio->nombre.' ('.$servicio->referencia.')'; ?></h3>
	                    </div>

	                    <div class="panel-body">
	                        <h5>Reservas pendientes: <?php echo count($servicio->reservas); ?></h5>

	                        <?php
	                        if (is_array($servicio->reservas) && count($servicio->reservas) > 0) {?>
	                            <table style="width: 100%;" class="table borderless">
	                                <thead>
	                                <tr>
	                                    <th style="width: 30%;">ID reserva</th>
	                                    <th style="width: 30%;" class="text-right">Número de clientes</th>
	                                    <th style="width: 20%;" class="text-right">Total reserva</th>
	                                    <th style="width: 20%;" class="text-right">Total comisión</th>
	                                </tr>
	                                </thead>
	                                <tbody>
	                                <?php
	                                if (is_array($servicio->reservas) && count($servicio->reservas) > 0) {
	                                    foreach ($servicio->reservas as $reserva) {
	                                        ?>
	                                        <tr>
	                                            <td style="width: 30%;"><?php echo $reserva->numero_billete.' / '.$reserva->reserva_year; ?></td>
	                                            <td style="width: 30%;"
	                                                class="text-right"><?php echo count($reserva->clientes['clientes']); ?></td>
	                                            <td style="width: 20%;"
	                                                class="text-right"><?php echo sprintf("%.2f", $reserva->totalReserva).' €'; ?></td>
	                                            <td style="width: 20%;"
	                                                class="text-right"><?php echo sprintf("%.2f", $reserva->totalComision).' €'; ?></td>
	                                        </tr>
										<?php }
	                                } ?>
	                                </tbody>
	                            </table>
	                        <?php } ?>
	                    </div>
	                </div>
					<?php }
				} ?>
	        <div class="well text-right">
	            <h4> Total reserva: <?php echo sprintf("%.2f", $resumenInfo['totalReservaGlobal']).' €'; ?>
	                - Total comisión: <?php echo sprintf("%.2f", $resumenInfo['totalComisionGlobal']).' €'; ?> </h4>
	        </div>
	    </div>
	</div>
</body>
</html>
