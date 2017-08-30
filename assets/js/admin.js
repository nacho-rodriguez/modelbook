$(document).ready(function () {
	console.log("jsadmin");

	//aviso de la eliminación de reservas
	$("#estado").on("change", function () {
		if (this.value == 2)
			$("#cancelOptionMessage").css('display', 'block');
		else
			$("#cancelOptionMessage").css('display', 'none');
		}
	);

	//controla el banner del modelo
	$('#updateBannerModel').click(function (e) {
		if (!$("#modelLabel").val()) {
			$("#mensajeWarning").css('display', 'block').text("Para añadir un banner, primero ha de crear el modelo en la pestaña anterior.");
			e.preventDefault();
		} else {
			$('#bannerId').submit();
		}
	});

	//controla el banner del servicio
	$('#updateBannerService').click(function (e) {
		if (!$("#serviceLabel").val()) {
			$("#mensajeWarning").css('display', 'block').text("Para añadir un banner, primero ha de crear el servicio en la pestaña anterior.");
			e.preventDefault();
		} else {
			$('#bannerId').submit();
		}
	});

	//añade las paradas en el backend en la creación del modelo
	$('#crearParadasModelo').click(function () {
		if (!$("#modelLabel").val()) {
			$("#mensajeWarning").css('display', 'block').text("Para guardar las paradas, primero ha de crear el modelo en la primera pestaña.");
		} else {
			$('#crearParadasModelo').prop('disable', true).val("Guardando paradas ...");
			var dataForm = $("#ParadasForm").serialize();
			var form2 = dataForm.split('%3A').join(':').split('&sellerId').join('#sellerId');

			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/admin/models/createstopsformodel",
				data: {
					idModelo: parseInt($("#modelID").val()),
					paradasModelo: form2
				}
			}).done(function () {
				$("#CompleteParadasContent").css('display', 'none');
				$("#mensajeSuccess").css('display', 'block').text("Se han creado correctamente las paradas del modelo. Por favor, continúe con los precios y las comisiones.");
			});
		}
	});

	//añade las paradas en el backend en la creación del servicio
	$('#crearParadasServicio').click(function () {
		if ($("#serviceID").length == 0) {
			$("#mensajeWarning").css('display', 'block').text("Para guardar las paradas, primero ha de crear el servicio en la primera pestaña.");
		} else {
			$('#crearParadasServicio').prop('disable', true).val("Guardando paradas ...");
			var dataForm = $("#ParadasForm").serialize();
			var form2 = dataForm.split('%3A').join(':').split('&sellerId').join('#sellerId');

			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/admin/services/createstopsforservice",
				data: {
					idServicio: parseInt($("#serviceID").val()),
					paradasServicio: form2
				}
			}).done(function () {
				$("#CompleteParadasContent").css('display', 'none');
				$("#mensajeSuccess").css('display', 'block').text("Se han creado correctamente las paradas del servicio. Por favor, contínue con los precios y comisiones.");
			});
		}
	});

	//añade el vendedor al modelo/servicio en el frontend para poder asignarle paradas
	$('.addVendedor').click(function (event) {
		var optionSelected = $('#selectSellersForParadas option:selected');
		var nombre_vendedor_seleccionado = optionSelected.text();
		var id_vendedor_seleccionado = optionSelected.val();

		if ($('#selectSellersForParadas option').length == 0) {
			alert("No hay más vendedores disponibles para añadir.");
		} else {
			optionSelected.remove();

			$("#listado_paradas").append("<div><div class='col-lg-4 col-md-4 text-center'><span>" + nombre_vendedor_seleccionado + "</span> <input name='sellerId' style='display:none;' value='" + id_vendedor_seleccionado + "' /> </div> <div class='col-lg-2 col-md-2 addParadaVendedor'> <a class='btn btn-warning' style='width: 60px;'><i class='fa fa-plus fa-lg'></i> </a> </div> <div class='col-lg-6 col-md-6 '><div> <div class='col-lg-3 col-md-3'> <input class='form-control' name='hora' type='time' /> </div> <div class='col-lg-8 col-md-8'> <input class='form-control' placeholder='Lugar de la parada' name='parada' type='text' /> </div> <div class='col-lg-1 col-md-1'> <a class='btn btn-danger deleteParada' style='width: 60px;'><i class='fa fa-times fa-lg'></i> </a> </div> </div> </div> <div class='col-lg-12 col-md-12'> <hr> </div></div>");
		}
	});

	//añade una parada al modelo/servicio en el frontend
	$('.addParadaVendedor').click(function (event) {
		// Si solo hay una parada, entonces eliminamos la parada entera
		var paradasVendedorDiv = $(this).next();

		paradasVendedorDiv.append("<div> <div class='col-lg-3 col-md-3'> <input class='form-control' name='hora' type='time' /> </div> <div class = 'col-lg-8 col-md-8'><input class='form-control' placeholder='Lugar de la parada' name='parada' type='text'/> </div> <div class='col-lg-1 col-md-1'> <a class='btn btn-danger deleteParada' style='width: 60px;'><i class='fa fa-times fa-lg'></i> </a> </div> </div>");
	});

	//elimina parada del modelo/servicio en el frontend
	$('.deleteParada').click(function (event) {
		var currentParadaRowToDelete = $(this).parent().parent();
		var listaParadasVendedor = currentParadaRowToDelete.parent();
		var vendedorRow = listaParadasVendedor.parent();

		$(this).parent().parent().remove();
		var infoVendedor = vendedorRow.children().first();

		if (listaParadasVendedor.children().length == 0) {
			vendedorRow.remove();
			$('#selectSellersForParadas').append('<option value="' + infoVendedor.children().eq(1).val() + '">' + infoVendedor.first().text() + '</option>');
		}
	});

	//actualiza las paradas del modelo en el backend
	$('#actualizarParadasModelo').click(function () {
		$('#actualizarParadasModelo').prop('disable', true).val("Actualizando paradas...");
		var dataForm = $("#ParadasForm").serialize();
		var form2 = dataForm.split('%3A').join(':').split('&sellerId').join('#sellerId');

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/models/updatestopsformodel",
			data: {
				idModelo: parseInt($("#modelID").val()),
				paradasModelo: form2
			}
		}).done(function () {
			$("#mensajeSuccess").css('display', 'block').text("Las paradas del modelo se han actualizado correctamente.");
			$('#actualizarParadasModelo').prop('disable', false).val("Actualizar paradas de los vendedores");
		});
	});

	//actualiza las paradas del servicio en el backend
	$('#actualizarParadasServicio').click(function () {
		$('#actualizarParadasServicio').prop('disable', true).val("Actualizando paradas...");
		var dataForm = $("#ParadasForm").serialize();
		var form2 = dataForm.split('%3A').join(':').split('&sellerId').join('#sellerId');

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/services/updatestopsforservice",
			data: {
				idServicio: parseInt($("#serviceID").val()),
				paradasServicio: form2
			}
		}).done(function () {
			$("#mensajeSuccess").css('display', 'block').text("Las paradas del servicio se han actualizado correctamente.");
			$('#actualizarParadasServicio').prop('disable', false).val("Actualizar paradas de los vendedores");
		});
	});

	$('#choose-type-service input:radio').addClass('input_hidden');
	$('#choose-type-service label').click(function () {
		$(this).addClass('selected').siblings().removeClass('selected');
	});

	//actualiza los precios del vendedor
	$("#actualizarPreciosServicio").on("click", function () {
		var dataForm = $("#listadoPreciosServicio").serialize();

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/sellers/updatepriceforoneseller",
			data: {
				id_vendedor: parseInt($("#sellerLab").text()),
				id_servicio: parseInt($("#serviceLab").text()),
				numberPrices: parseInt($("#numberPricesLab").text()),
				comisionesServicio: dataForm
			}
		}).done(function () {
			$("#mensajeSuccess").css('display', 'block').text("Los precios y comisiones del servicio se han actualizado correctamente.");
		});
	});

	$('#updateSellerSubmit').on("click", function () {
		$('#formUpdateSeller').submit();
	});

	//aplicar precios del modelo/servicio por defecto a todos los vendedores
	$("#precioVendedoresBoton").on("click", function () {
		var array = [];
		$('#tablaPreciosDefecto').children('div').each(function (i) {
			var arrayActual = [];

			arrayActual.push($(this).find('.id_tipo_cliente').val());
			arrayActual.push($(this).find('.precio').val());
			arrayActual.push($(this).find('.comision').val());
			arrayActual.push($(this).find('.tipo_comision').val());
			array.push(arrayActual);
		});
		var i = 0;
		$('#listadoVendedoresYPreciosForm').children('.preciosVendedor').each(function (i) {
			$(this).children('.precios').each(function (i) {
				var j = 0;
				$(this).find(".precioOficial").val(array[i][++j]);
				$(this).find(".comisionOficial").val(array[i][++j]);
				$(this).find(".tipoComisionOficial").val(array[i][++j]);
			});
			i++;
		});
	});

	//guarda los precios y comisiones del modelo en el backend
	$("#guardarPreciosComisionesModelo").on("click", function () {
		if (!$("#modelLabel").val()) {
			$("#finalizarBoton").css('display', 'none');
			$("#mensajeWarning").css('display', 'block').text("Para guardar los precios de los vendedores, primero ha de crear el modelo en la primera pestaña.");
		} else {
			var dataForm = $("#listadoVendedoresYPreciosForm").serialize();
			var dataFormParsed = dataForm.split('&idVendedor').join('#idVendedor');

			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/admin/models/savepriceandcommissionsformodel",
				data: {
					idModelo: parseInt($("#modelLabel").val()),
					comisionesServicio: dataFormParsed
				}
			}).done(function () {
				$("#CompletePreciosContent").css('display', 'none');
				$("#mensajeWarning").css('display', 'block').text("Los precios y comisiones se han guardado satisfactoriamente en cada uno de los vendedores. Por favor, pulse en FINALIZAR para dar de alta definitivamente al modelo.");
				$("#finalizarBoton").css('display', 'block');
			});
		}
	});

	//actualiza los precios y comisiones del modelo en el backend
	$("#actualizarPreciosComisionesModelo").on("click", function () {
		var dataForm = $("#listadoVendedoresYPreciosForm").serialize();
		var dataFormParsed = dataForm.split('&idVendedor').join('#idVendedor');

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/models/updatepriceandcommissionsformodels",
			data: {
				idModelo: parseInt($("#modelID").val()),
				preciosComisionesModelo: dataFormParsed
			}
		}).done(function () {
			$("#mensajeSuccess").css("display", "block").text("Los precios y comisiones del modelo se han actualizado correctamente.");
		});
	});

	//guarda los precios y comisiones del servicio en el backend
	$("#guardarPreciosComisionesServicio").on("click", function () {
		if ($("#serviceID").length == 0) {
			$("#finalizarBoton").css('display', 'none');
			$("#mensajeWarning").css('display', 'block').text("Para guardar los precios de los vendedores, primero ha de crear el servicio en la primera pestaña.");
		} else {
			var dataForm = $("#listadoVendedoresYPreciosForm").serialize();
			var dataFormParsed = dataForm.split('&idVendedor').join('#idVendedor');

			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/admin/services/savepriceandcommissionsforservices",
				data: {
					idServicio: parseInt($("#serviceID").val()),
					comisionesServicio: dataFormParsed
				}
			}).done(function () {
				$("#CompletePreciosContent").css('display', 'none');
				$("#mensajeWarning").css('display', 'block').text("Los precios y comisiones se han guardado satisfactoriamente en cada uno de los vendedores. Por favor, pulse en FINALIZAR para dar de alta definitivamente al servicio.");
				$("#finalizarBoton").css('display', 'block');
			});
		}
	});

	//actualiza los precios y comisiones del servicio en el backend
	$("#actualizarPreciosComisionesServicio").on("click", function () {
		var dataForm = $("#listadoVendedoresYPreciosForm").serialize();
		var dataFormParsed = dataForm.split('&idVendedor').join('#idVendedor');

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/services/updatepriceandcommissionsforservices",
			data: {
				idServicio: parseInt($("#serviceID").val()),
				comisionesServicio: dataFormParsed
			}
		}).done(function () {
			$("#mensajeSuccess").css('display', 'block').text("Los precios y comisiones del servicio se han actualizado correctamente.");
		});
	});

	/*Reservas*/
	$("#confirmBooking").on("click", function () { //TODO revisar
		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/admin/bookings/confirmbooking",
			data: {
				idReserva: parseInt($("input[name='bookingID']").val())
			}
		}).done(function () {
			$("#estadoReserva").val("Confirmada");
		});
	});

	//actualiza la conversación
	$('#enviarMensaje').on("click", function () {
		var requestID = $('#requestID').val();
		var requestMessage = $('#peticionMensaje').val();
		var sellerID = $('#sellerID').text();

		if (requestMessage == "") {
			alert("Escriba un mensaje");
		} else {
			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/admin/requests/sendmessage",
				data: {
					requestID: requestID,
					requestMessage: requestMessage,
					sellerID: sellerID
				}
			}).done(function (sendDate) {
				$('#messagesListRequest').append("<div class=' col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4'> <div class='well'> <span>" + requestMessage + "</span> <div style='width: 100%;text-align: right'> <span>" + sendDate + "</span> </div> </div></div>");
				$('#peticionMensaje').val("");
			});
		}
	});

	$('#confirmGenerateDocuments').on("click", function (e) {
		e.preventDefault();
		var input1 = $("<input>").attr("type", "hidden").attr("name", "startDateBegin").val($('input[name*="startDateBegin"]').val());
		var input2 = $("<input>").attr("type", "hidden").attr("name", "endDateBegin").val($('input[name*="endDateBegin"]').val());
		var input3 = $("<input>").attr("type", "hidden").attr("name", "startDateEnd").val($('input[name*="startDateEnd"]').val());
		var input4 = $("<input>").attr("type", "hidden").attr("name", "endDateEnd").val($('input[name*="endDateEnd"]').val());

		$('#tableConfirmCloseout').append($(input1)).append($(input2)).append($(input3)).append($(input4)).submit();
	});

	/* MAKE CLOSEOUTS OF SELECTED ROWS */
	$('#makeLiquidaciones').on("click", function () {
		var sellersIDSeleccionadas = getCloseoutsSelections();

		if ($('#dateCloseOutSelected').val() && sellersIDSeleccionadas.length > 0) {
			$('#rowsSelected').val(sellersIDSeleccionadas);

			$("#openModal").trigger("click");
		} else if (sellersIDSeleccionadas.length == 0) {
			alert("No ha seleccionado ninguna reserva para liquidar.");
		} else {
			alert("Seleccione una fecha para liquidar las reservas seleccionadas.");
		}
	});

	$('#confirmLiquidacionesDocuments').on("click", function (e) {
		e.preventDefault();
		var input1 = $("<input>").attr("type", "hidden").attr("name", "startDateBegin").val($('input[name*="startDateBegin"]').val());
		var input2 = $("<input>").attr("type", "hidden").attr("name", "endDateBegin").val($('input[name*="endDateBegin"]').val());
		var input3 = $("<input>").attr("type", "hidden").attr("name", "startDateEnd").val($('input[name*="startDateEnd"]').val());
		var input4 = $("<input>").attr("type", "hidden").attr("name", "endDateEnd").val($('input[name*="endDateEnd"]').val());

		$('#formConfirmCloseoutsDocuments').append($(input1)).append($(input2)).append($(input3)).append($(input4)).submit();
	});

	$('#makeLiquidacionesDocumentos').on("click", function () {
		var sellersIDSeleccionadas = getCloseoutsSelections();

		if ($('#dateCloseOutSelected').val() && sellersIDSeleccionadas.length > 0) {
			$('#rowsSelected').val(sellersIDSeleccionadas);
			$("#openModal").trigger("click");
		} else if (sellersIDSeleccionadas.length == 0) {
			alert("No ha seleccionado ningún documento para liquidar.");
		} else {
			alert("Seleccione una fecha de cobro para los documentos seleccionados.");
		}
	});

	function getCloseoutsSelections() {
		return $.map($('#tableCurrentPaymentsBookingList').bootstrapTable('getSelections'), function (row) {
			return row['_1_data']['booking'];
		});
	}

	//modal para confirmar reservas seleccionadas
	$('#confirmBookingNonConfirmed').on("click", function () {
		var sellersIDSeleccionadas = getNonConfirmedBookingSelections();
		$('#rowsSelected').val(sellersIDSeleccionadas);

		if (sellersIDSeleccionadas.length > 0) {
			$("#openModal").trigger("click");
		} else {
			alert("No ha seleccionado ninguna reserva.");
		}
	});

	//model para confirmar reservas
	$('#confirmReservasNoConfirmed').on("click", function () {
		$('#formUpdateBookingNonConfirmed').submit();
	});

	function getNonConfirmedBookingSelections() {
		return $.map($('#tableBookingNonConfirmed').bootstrapTable('getSelections'), function (row) {
			return row['_1_data']['booking'];
		});
	}

});
