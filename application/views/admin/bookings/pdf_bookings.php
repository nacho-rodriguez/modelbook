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
	        <div class="well text-center">
	            <h3> Servicio: <?php echo $pdfStructure->nombre.' ('.$pdfStructure->referencia.')'; ?></h3>
	        </div>

	        <h4> Confirmadas (<?php
	            switch ($pdfStructure->confirmadas['totalPersonas']) {
	        case 0: echo 'No hay reservas';
	            break;
	        case 1: echo 'Hay 1 persona';
	            break;
	        default: echo 'Hay '.$pdfStructure->confirmadas['totalPersonas'].' personas';
	            } ?>)</h4>
	        <?php
	        if (is_array($pdfStructure->confirmadas['paradas']) && $pdfStructure->confirmadas['totalPersonas'] > 0) {
	            foreach ($pdfStructure->confirmadas['paradas'] as $parada) { ?>
	                <div class="panel panel-default ">
	                    <div class="panel-body">
	                        <h5> Parada:  <?php echo $parada->lugar_parada; ?>  a las <?php echo $parada->hora_parada; ?>
	                        (<?php
	                            switch ($parada->totalPersonasParada) {
	                        case 0: echo 'No hay reservas';
	                            break;
	                        case 1: echo 'Hay 1 persona';
	                            break;
	                        default: echo 'Hay '.$parada->totalPersonasParada.' personas';
	                            } ?>)</h5>

	                        <?php if (is_array($parada->reservas) && count($parada->reservas) > 0) { ?>
	                            <table style="width: 100%;" class="table borderless">
	                                <thead>
	                                <tr>
	                                    <th style="width: 27%;">Nombre y apellidos</th>
	                                    <th style="width: 13%;" class="text-right">Teléfono</th>
	                                    <th style="width: 12%;" class="text-right">ID reserva</th>
	                                    <th style="width: 18%;" class="text-right">Vendedor</th>
	                                    <th style="width: 20%;" class="text-right">Fecha emisión</th>
	                                    <th style="width: 10%;" class="text-right">Pers.</th>
	                                </tr>
	                                </thead>
	                                <tbody>
	                                    <?php foreach ($parada->reservas as $reserva) { ?>
	                                        <tr>
	                                            <td><?php echo $reserva->nombre.' '.$reserva->apellidos; ?></td>
	                                            <td class="text-right"><?php echo $reserva->telefono; ?></td>
	                                            <td class="text-right"><?php echo $reserva->identificador_reserva; ?></td>
	                                            <td class="text-right"><?php echo $reserva->nombre_vendedor; ?></td>
	                                            <td class="text-right"><?php echo $reserva->fecha_emision_reserva; ?></td>
	                                            <td class="text-right"><?php echo $reserva->totalPersonas ?></td>
	                                        </tr>
	                                    <?php } ?>
	                                </tbody>
	                            </table>
	                        <?php } ?>
	                    </div>
	                </div>
	            <?php }
	        } ?>

	        <h4> No confirmadas (<?php
	            switch ($pdfStructure->noConfirmadas['totalPersonas']) {
	        case 0: echo 'No hay reservas';
	            break;
	        case 1: echo 'Hay 1 persona';
	            break;
	        default: echo 'Hay '.$pdfStructure->noConfirmadas['totalPersonas'].' personas';
	            } ?>)</h4>
	        <?php
	        if (is_array($pdfStructure->noConfirmadas['paradas']) && $pdfStructure->noConfirmadas['totalPersonas'] > 0) {
	            foreach ($pdfStructure->noConfirmadas['paradas'] as $parada) { ?>

	                <div class="panel panel-default ">
	                    <div class="panel-body">
	                        <h5> Parada:  <?php echo $parada->lugar_parada; ?>  a las <?php echo $parada->hora_parada; ?>
	                            (<?php switch ($parada->totalPersonasParada) {
	                            case 0: echo 'No hay reservas';
	                                break;
	                            case 1: echo 'Hay 1 persona';
	                                break;
	                            default: echo 'Hay '.$parada->totalPersonasParada.' personas';
							} ?>)</h5>

	                        <?php if (is_array($parada->reservas) && count($parada->reservas) > 0) { ?>
	                            <table class="table">
	                                <thead>
	                                    <tr>
	                                        <th style="width: 27%;">Nombre y apellidos</th>
	                                        <th style="width: 13%;" class="text-right">Teléfono</th>
	                                        <th style="width: 12%;" class="text-right">ID reserva</th>
	                                        <th style="width: 18%;" class="text-right">Vendedor</th>
	                                        <th style="width: 20%;" class="text-right">Fecha emisión</th>
	                                        <th style="width: 10%;" class="text-right">Pers.</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                <?php foreach ($parada->reservas as $reserva) {?>
	                                    <tr>
	                                        <td ><?php echo $reserva->nombre.' '.$reserva->apellidos; ?></td>
	                                        <td class="text-right"><?php echo $reserva->telefono ?></td>
	                                        <td class="text-right"><?php echo $reserva->identificador_reserva; ?></td>
	                                        <td class="text-right"><?php echo $reserva->nombre_vendedor; ?></td>
	                                        <td class="text-right"><?php echo $reserva->fecha_emision_reserva; ?></td>
	                                        <td class="text-right"><?php echo $reserva->totalPersonas ?></td>
	                                    </tr>
	                                <?php } ?>
	                                </tbody>
	                            </table>
	                        <?php
						} ?>
	                    </div>
	                </div>
	            <?php }
	        } ?>

	        <h4> Anuladas (<?php
	            switch ($pdfStructure->anuladas['totalPersonas']) {
	        case 0: echo 'No hay reservas';
	            break;
	        case 1: echo 'Hay 1 persona';
	            break;
	        default: echo 'Hay '.$pdfStructure->anuladas['totalPersonas'].' personas';
	            } ?>)</h4>
	        <?php if (is_array($pdfStructure->anuladas['paradas']) && $pdfStructure->anuladas['totalPersonas'] > 0) {
	            foreach ($pdfStructure->anuladas['paradas'] as $parada) { ?>
	                <div class="panel panel-default ">
	                    <div class="panel-body">
	                        <h5> Parada:  <?php echo $parada->lugar_parada; ?>  a las <?php echo $parada->hora_parada; ?>
	                            (<?php
	                            switch ($parada->totalPersonasParada) {
	                            case 0: echo 'No hay reservas';
	                                break;
	                            case 1: echo 'Hay 1 persona';
	                                break;
	                            default: echo 'Hay '.$parada->totalPersonasParada.' personas';
	                            } ?>)</h5>
	                        <?php if (is_array($parada->reservas) && count($parada->reservas) > 0) { ?>
	                            <table class="table borderless">
	                                <thead>
	                                <tr>
	                                    <th style="width: 27%;">Nombre y apellidos</th>
	                                    <th style="width: 13%;" class="text-right">Teléfono</th>
	                                    <th style="width: 12%;" class="text-right">ID reserva</th>
	                                    <th style="width: 18%;" class="text-right">Vendedor</th>
	                                    <th style="width: 20%;" class="text-right">Fecha emisión</th>
	                                    <th style="width: 10%;" class="text-right">Pers.</th>
	                                </tr>
	                                </thead>
	                                <tbody>
	                                    <?php foreach ($parada->reservas as $reserva) { ?>
	                                        <tr>
	                                            <td><?php echo $reserva->nombre.' '.$reserva->apellidos; ?></td>
	                                            <td class="text-right"><?php echo $reserva->telefono ?></td>
	                                            <td class="text-right"><?php echo $reserva->identificador_reserva; ?></td>
	                                            <td class="text-right"><?php echo $reserva->nombre_vendedor; ?></td>
	                                            <td class="text-right"><?php echo $reserva->fecha_emision_reserva; ?></td>
	                                            <td class="text-right"><?php echo $reserva->totalPersonas ?></td>
	                                        </tr>
	                                    <?php } ?>
	                                </tbody>
	                            </table>
	                        <?php } ?>
	                    </div>
	                </div>
	            <?php }
			} ?>
	    </div>
	</div>
</body>
</html>
