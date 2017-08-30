<html>
<body>
	<div class="row">
	    <?php if ($companyData->logo != '') {?>
	        <div class="col-lg-12 col-md-12" align="center">
	            <img src="<?php echo $companyData->logo; ?>" alt="Logo" width="840" height="240">
	        </div>
	    <?php }?>
	</div>
	<div class="container">
	    <div class="row">
	        <?php if ($sellerData->mostrar_info_reserva == 1) { ?>
	            <div style="padding-left: 250px; padding-top: 25px;" class="text-right">
	                <div class="well">
	                    <span><strong><?php echo $sellerData->nombre; ?></strong></span><br>
	                    <span><?php echo $sellerData->direccion; ?></span><br>
	                    <span><?php echo $sellerData->poblacion." (".$sellerData->provincia.")"; ?></span><br>
	                    <span><?php echo "Tlf: ".$sellerData->telefono." - Email: ".$sellerData->email; ?></span>
	                </div>
	            </div>
	        <?php } ?>
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">
	                    <strong><?php echo $bookingInfo->nombreServicio." (".$bookingInfo->referencia.")"; ?></strong></h3>
	            </div>
	            <div class="panel-body">
	                <table id="descripcion" class="table borderless">
	                    <thead>
	                    <tr>
	                        <th style="width: 60%;">Descripción</th>
	                        <th style="width: 40%;">Recomendaciones</th>
	                    </tr>
	                    </thead>
	                    <tbody>
	                    <tr>
	                        <td style="width: 60%; ">
	                            <?php echo $bookingInfo->descripcion; ?>
	                        </td>
	                        <td style="width: 40%; ">
	                            <?php echo $bookingInfo->recomendaciones; ?>
	                        </td>
	                    </tbody>
	                </table>


	                <label><strong>Comienzo: </strong></label>
	                <span>En <strong><?php echo $bookingInfo->localidad_inicio; ?></strong> el día <strong><?php echo " ".$bookingInfo->fecha_inicio_reserva; ?></strong> en la parada <strong> <?php echo $bookingInfo->lugar_parada; ?></strong> a las <strong><?php echo " ".$bookingInfo->hora_parada."."; ?></strong> </span><br>

	                <label ><strong>Finalización: </strong></label>
					<span>En <strong><?php echo $bookingInfo->localidad_fin; ?></strong> el día <strong><?php echo " ".$bookingInfo->fecha_fin_reserva; ?></strong> a las <strong><?php echo " ".$bookingInfo->hora_fin_reserva."."; ?></strong> </span><br><br>

	                <label ><strong>Datos de la reserva</strong></label><br>
	                <span>ID: <strong><?php
	                        $longitud = strlen($bookingInfo->numero_billete);
	                        $identificador = "";
			                for ($i = 0; $i < (4 - $longitud); $i++) {
			                    $identificador .= "0";
			                }
	                        $identificador .= $bookingInfo->numero_billete."/".$bookingInfo->reservas_year;
	                        echo $identificador; ?></strong> emitida en la fecha:
	                    <strong><?php echo $bookingInfo->fecha_emision_reserva."."; ?></strong>
	                </span>
	            </div>

	            <?php if ($bookingInfo->banner != '') {?>
	                <div class="col-lg-12 col-md-12">
	                    <img src="<?php echo $bookingInfo->banner; ?>" width="840" height="240">
	                </div>
	            <?php }?>

	            <div class="panel-body">
	                <table class="table table-bordered">
	                    <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>DNI</th>
	                        <th>Nombre y apellidos</th>
	                        <th>Teléfono</th>
	                        <th>Tipo de reserva</th>
	                        <th class="text-right">Precio</th>
	                    </tr>
	                    </thead>
	                    <tbody>
	                    <?php
	                    if (is_array($bookingInfo->clients)) {
	                        $index = 1;
	                        foreach ($bookingInfo->clients as $client) { ?>
	                            <tr>
	                                <td><?php echo $index; ?></td>
	                                <td><?php echo strcmp($client->dni, 'noDNI') === 0 ?
	                                        '-' : $client->dni; ?></td>
	                                <td><?php echo strcmp($client->dni, 'noDNI') !== 0 ?
	                                        $client->nombre." ".$client->apellidos : 'Acompañante';  ?></td>
	                                <td><?php echo $client->telefono; ?></td>
	                                <td><?php echo $client->tipo_cliente; ?></td>
	                                <td class="text-right"><?php echo  sprintf("%.2f", $client->valor_monetario)." €"; ?></td>
	                            </tr>

	                        <?php  $index++;
	                        }
	                    } ?>
	                    </tbody>
	                </table>
	            </div>
	            <div class="panel-footer text-right">
	                <label>Importe total (IVA incluido): </label><span style="font-weight: bold; font-size: 18px;"><?php echo sprintf("%.2f", $bookingInfo->totalReserva)." €"; ?></span>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>
