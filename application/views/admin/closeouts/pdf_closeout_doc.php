<html>
<body>
	<div class="row">
	    <?php if ($companyData->logo != '') { ?>
	        <div class="col-lg-12 col-md-12" align="center">
	            <img src="<?php echo $companyData->logo; ?>" alt="Logo" width="840" height="240">
	        </div><br/>
	    <?php } ?>
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
	        <?php if (is_array($closeoutDocument['reservas']) && count($closeoutDocument['reservas']) > 0) { ?>

	        <h4 class="text-center">Documento de liquidación <?php echo $idCloseoutDoc; ?>
	        </h4>
	        <h5 class="text-center">Fecha de emisión: <?php echo $closeoutDocument['reservas'][0]->fecha_emision_liquidacion; ?> - Fecha de cobro: <?php echo $closeoutDocument['reservas'][0]->fecha_cobro_liquidacion ? $closeoutDocument['reservas'][0]->fecha_cobro_liquidacion : ' - '; ?></h5>
	        <div class="panel panel-default ">
	            <div class="panel-body">
	                <table style="width: 100%;" class="table borderless">
	                    <thead>
	                    <tr>
	                        <th style="width: 20%;">ID reserva</th>
	                        <th style="width: 25%;">Servicio</th>
	                        <th style="width: 15%;" class="text-right">Nº clientes</th>
	                        <th style="width: 20%;" class="text-right">Total reserva</th>
	                        <th style="width: 20%;" class="text-right">Total comisión</th>
	                    </tr>
	                    </thead>
	                    <tbody>
	                    <?php

	                    foreach ($closeoutDocument['reservas'] as $reserva) { ?>
	                        <tr>
	                            <td style="width: 20%;"><?php echo $reserva->numero_billete.' / '.$reserva->reserva_year; ?></td>
	                            <td style="width: 25%;"><?php echo $reserva->nombre; ?></td>
	                            <td style="width: 15%;"
	                                class="text-right"><?php echo count($reserva->clientes['clientes']); ?></td>
	                            <td style="width: 20%;"
	                                class="text-right"><?php echo sprintf("%.2f", $reserva->totalReserva).' €'; ?></td>
	                            <td style="width: 20%;"
	                                class="text-right"><?php echo sprintf("%.2f", $reserva->totalComision).' €'; ?></td>
	                        </tr> <?php
						} ?>
	                    </tbody>
	                </table>
	                <?php
				} ?>
	            </div>
	        </div>

	        <div class="well text-right">
	            <h4> Total reserva: <?php echo sprintf("%.2f", $closeoutDocument['totalReservaGlobal']).' €'; ?> - Total comisión: <?php echo sprintf("%.2f", $closeoutDocument['totalComisionGlobal']).' €'; ?> </h4>
	        </div>
	        <div class="text-right" style="margin-right: 75px;">
	            <strong>Firmado:</strong>
	            <br><br><br>
	        </div>
	    </div>
	</div>
</body>
</html>
