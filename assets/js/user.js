$(document).ready(function () {
	console.log("jsuser");

	//muestra más información del servicio
	$('.more-details-button').on("click", function () {
		$("#sendMessage").css("display", "none");
		$("#loadingTabs").css("display", "none");

		var id_servicio = $(this).parent().parent().parent().find(".service").text();
		$("#serviceIDModal").text(id_servicio);

		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/user/bookings/getserviceinformation",
			data: {
				id_servicio: parseInt(id_servicio),
				id_vendedor: $("#sellerIDModal").text()
			}
		}).done(function (result) {
			var serviceObject = jQuery.parseJSON(result);

			$("#myModalTitle").text(serviceObject.nombre);
			var asunto = serviceObject.nombre + ", Referencia: " + serviceObject.referencia;
			$('#requestTopic').val(asunto);

			$('#descripcion').text(serviceObject.descripcion);
			$('#recomendaciones').text(serviceObject.recomendaciones);
			$('#referencia').text(serviceObject.referencia);
			$('#fechaFinValida').text(serviceObject.fecha_finalizacion_reservas);
			$('#minPersonas').text(serviceObject.min_personas);
			$('#maxPersonas').text(serviceObject.max_personas);
			$('#fechaInicio').text(serviceObject.fecha_comienzo);
			$('#localidadInicio').text(serviceObject.localidad_inicio);
			$('#fechaFin').text(serviceObject.fecha_finalizacion);
			$('#localidadFin').text(serviceObject.localidad_fin);
			$('#horaInicio').text(serviceObject.hora_inicio);
			$('#horaFin').text(serviceObject.hora_fin);

			var priceTable = serviceObject.price_table;

			$('#preciosServicios').empty();

			for (var i = 0; i < priceTable.length; i++) {
				$('#preciosServicios').append("<tr><td>" + priceTable[i]['nombre'] + "</td><td>" + priceTable[i]['valor_monetario'] + " €</td></tr>");
			}

			$("#loadingTabs").css("display", "block");
		});
	});

	//añade información al crear una reserva
	$(".booking-button").on("click", function () {
		var id_servicio = $(this).parent().parent().parent().parent().find(".service").text();
		var name_servicio = $(this).parent().parent().parent().parent().find(".name_service").text();
		var input = $("<input>").attr("type", "hidden").attr("name", "idService").val(id_servicio);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "nameService").val(name_servicio);

		$('.formBookingService').append($(input)).append($(input2));
	});

	var vista = 0;

	$('#cambiarVista').click(function () {
		if ($('#vistaTabla').hasClass("show")) {
			$('#vistaListaTab').removeClass('hide').addClass('show');
			$('#vistaListaContent').removeClass('hide').addClass('show');
			$('#vistaTabla').removeClass('show').addClass('hide');
		} else {
			$('#vistaTabla').removeClass('hide').addClass('show');
			$('#vistaListaTab').removeClass('show').addClass('hide');
			$('#vistaListaContent').removeClass('show').addClass('hide');
		}
	});

	$('#onlyMainPassenger').change(function () {

		var numero_reservas_seleccionadas = $("#numeroReservasSelect").val();
		$("#listado_clientes_reservas").empty();

		if ($(this).is(":checked")) {

			if (!$("#numeroReservasSelect").val()) {
				$("#numeroReservasSelect").val('1');
			}

			var check_info = $("#checkInfo").val();
			$('#totalReserva').text("Total: 0 €");

			$("#listado_clientes_reservas").append("<div class='row clientBooking'> <div class='col-lg-12 col-md-12'> <h4> Pasajero principal </h4> </div></div> <div class='col-lg-2 col-md-2'> <label for='dni'>DNI </label> <div class='input-group'> <input name='dni' class='form-control' required='required' type='text' placeholder='DNI'> </div></div> <div class='col-lg-2 col-md-2'> <a class='btn btn-warning searchDni' ><i style='padding-top:12px; width: 40px; height: 40px;' class='fa fa-search fa-lg'></i> Buscar DNI</a> </div> <div class='col-lg-3 col-md-3'> <label for='fecha_nacimiento'>Fecha de Nacimiento </label> <div class='input-group'> <input name='fecha_nacimiento' max='" + currentDate + "' class='form-control fechaNacimiento' required='required' type='date' /> </div></div> <div class='col-lg-5 col-md-5'> <label>Tipo de Cliente</label> <div class='form-control'> <input class='validPrice' type='checkbox' required='required' onclick='return false'> <span style='margin-right: 10px; font-weight: bold; font-size: medium;' class='nombreTipoCliente'></span><span style='font-weight: bold; font-size: medium;' class='precioTipoCliente'></span> <span style='display:none;font-weight: bold; font-size: medium;' class='moneda'> €</span> </div></div> <div class='col-lg-2 col-md-2'> <label for='nombre'>Nombre </label> <div class='input-group'> <input name='nombre' class='form-control' required='required' type='text' placeholder='Nombre'> </div></div> <div class='col-lg-2 col-md-2'> <label for='apellidos'>Apellidos </label> <div class='input-group'> <input name='apellidos' class='form-control' required='required' type='text' placeholder='Apellidos'> </div></div> <div class='col-lg-2 col-md-2'> <label for='telefono'>Teléfono </label> <div class='input-group'> <input name='telefono' class='form-control' required='' type='text' placeholder='Teléfono'> </div></div> <div class='col-lg-3 col-md-3'> <label for='email'>Email </label> <div class='input-group'> <input name='email' class='form-control'  type='email' placeholder='Email'> </div></div> </div>");

			if (check_info == 1) {
				$("#listado_clientes_reservas").append("<div class='col-lg-2 col-md-2'>" +
					"<label for='dni_lugar_expedido'>DNI Expedido en </label>" +
					"<div class='input-group'>" +
					"<input name='dni_lugar_expedido' class='form-control' required='required' type='text' placeholder='DNI Expedido en'>" +
					"</div></div>" +
					"<div class='col-lg-2 col-md-2'>" +
					"<label for='dni_fecha_expedicion'>Fecha Caducidad DNI</label>" +
					"<div class='input-group'>" +
					"<input name='dni_fecha_expedicion' min='" + currentDate + "' max='2050-01-01' class='form-control' required='required' type='date' placeholder='Fecha Expedición DNI'>" + "</div></div>" + "<div class='col-lg-2 col-md-2'>" + "<label for='nacionalidad'>Nacionalidad </label>" + "<div class='input-group'>" + "<input name='nacionalidad' class='form-control' required='required' type='text' placeholder='Nacionalidad'>" + "</div></div>" + "<div class='col-lg-2 col-md-2'>" + "<label for='lugar_nacimiento'>Lugar Nacimiento </label>" + "<div class='input-group'>" + "<input name='lugar_nacimiento' class='form-control' required='required' type='text' placeholder='Lugar Nacimiento'>" + "</div></div>" + "<div class='col-lg-2 col-md-2'>" + "<label for='profesion'>Profesión </label>" + "<div class='input-group'>" + "<input name='profesion' class='form-control' required='required' type='text' placeholder='Profesión'>" + "</div></div>" + "<div class='col-lg-2 col-md-2'>" + "<label for='pais_residencia_habitual'>País Residencia Habitual </label>" + "<div class='input-group'>" + "<input name='pais_residencia_habitual' class='form-control' required='required' type='text' placeholder='País Residencia Habitual'>" + "</div></div>");
			}

			for (var i = 1; i < numero_reservas_seleccionadas; i++) {

				$("#listado_clientes_reservas").append("<div class='row clientBooking'>" +
					"<div class='col-lg-12 col-md-12'>" +
					"<h4>Pasajero " + (i + 1) + " </h4>" + "</div></div>" + "<div class='col-lg-4 col-md-4'>" + "<label for='fecha_nacimiento'>Fecha de Nacimiento </label>" + "<div class='input-group'> <input name='fecha_nacimiento_clean' max='" + currentDate + "' class='form-control fechaNacimiento' required='required' type='date' />" + "</div></div>" + "<div class='col-lg-8 col-md-8'>" + "<label>Tipo de Cliente</label>" + "<div class='form-control'>" + "<input class='validPrice' type='checkbox' required='required' onclick='return false'>" + "<span style='margin-right: 10px; font-weight: bold; font-size: medium;' class='nombreTipoCliente'></span>  " + "<span style='font-weight: bold; font-size: medium;' class='precioTipoCliente'></span>" + "<span style='display:none;font-weight: bold; font-size: medium;' class='moneda'> €</span>" + "</div></div>");

			}

			$("#listado_clientes_reservas").append("<div class='col-lg-12 col-md-12'>" +
				"<hr></div></div>");

			$("#listado_clientes_reservas").append("<div class='row'> <div class='col-lg-12 col-md-12'> <input class='btn btn-primary btn-lg' name='submit' type='submit' id='realizarReserva'  value='Hacer la reserva'> </div></div>");
		} else {
			addBookingToList();
		}
	});

	$("#numeroReservasSelect").change(function () {
		$('#onlyMainPassenger').attr('checked', false); // Unchecks it
		addBookingToList();
	});

	var addBookingToList = function () {
		var numero_reservas_seleccionadas = $("#numeroReservasSelect").val();

		$('#totalReserva').text("Total: 0 €");
		$("#listado_clientes_reservas").empty();

		for (var i = 0; i < numero_reservas_seleccionadas; i++) {
			$("#listado_clientes_reservas").append("<div class='row clientBooking'> <div class='col-lg-12 col-md-12'> <h4>Pasajero " + (i + 1) + " </h4> </div></div> <div class='col-lg-2 col-md-2'> <label for='dni'>DNI </label> <div class='input-group'> <input name='dni' class='form-control' required='required' type='text' placeholder='DNI'> </div></div> <div class='col-lg-2 col-md-2'> <a class='btn btn-warning searchDni' ><i style='padding-top:12px; width: 40px; height: 40px;'  class='fa fa-search fa-lg'></i> Buscar DNI</a> </div> <div class='col-lg-3 col-md-3'> <label for='fecha_nacimiento'>Fecha de Nacimiento </label> <div class='input-group'> <input name='fecha_nacimiento' max='" + currentDate + "' class='form-control fechaNacimiento' required='required' type='date' /> </div></div> <div class='col-lg-5 col-md-5'> <label>Tipo de Cliente</label> <div class='form-control'> <input class='validPrice' type='checkbox' required='required' onclick='return false'> <span style='margin-right: 10px; font-weight: bold; font-size: medium;' class='nombreTipoCliente'></span> <span style='font-weight: bold; font-size: medium;' class='precioTipoCliente'></span> <span style='display:none;font-weight: bold; font-size: medium;' class='moneda'> €</span> </div></div> <div class='col-lg-2 col-md-2'> <label for='nombre'>Nombre </label> <div class='input-group'> <input name='nombre' class='form-control' required='required' type='text' placeholder='Nombre'> </div></div> <div class='col-lg-2 col-md-2'> <label for='apellidos'>Apellidos </label> <div class='input-group'> <input name='apellidos' class='form-control' required='required' type='text' placeholder='Apellidos'> </div></div> <div class='col-lg-2 col-md-2'> <label for='telefono'>Teléfono </label> <div class='input-group'> <input name='telefono' class='form-control' required='' type='text' placeholder='Teléfono'> </div></div> <div class='col-lg-3 col-md-3'> <label for='email'>Email </label> <div class='input-group'> <input name='email' class='form-control'  type='email' placeholder='Email'> </div></div> <div class='col-lg-3 col-md-3'> </div></div>");

			$("#listado_clientes_reservas").append("<div class='col-lg-12 col-md-12'>" +
				"<hr></div></div>");
		}

		if (numero_reservas_seleccionadas > 0) {
			$("#listado_clientes_reservas").append("<div class='row'> <div class='col-lg-12 col-md-12'> <input class='btn btn-primary btn-lg' name='submit' type='submit' id='realizarReserva' value='Hacer la reserva'> </div></div>");
		}
	};

	//indica el tipo de cliente
	var calculoTipoCliente = function (dateInput) {
		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/user/bookings/gettypeclient",
			data: {
				idServicio: $('#serviceID').val(),
				fecha: dateInput.val()
			}
		}).done(function (result) {
			var tipoClienteInfo = jQuery.parseJSON(result);
			var tipo_cliente_block = dateInput.parent().parent().next();

			if (isEmpty(tipoClienteInfo)) {
				tipo_cliente_block.find(".nombreTipoCliente").text("No hay precio asignado");
				tipo_cliente_block.find(".validPrice").prop('checked', false);
				tipo_cliente_block.find(".precioTipoCliente").text("");
			} else {
				var todos = $('#listado_clientes_reservas').find(".precioTipoCliente");
				var totalReserva = 0;
				tipo_cliente_block.find(".nombreTipoCliente").text(tipoClienteInfo.nombre + "  -");
				tipo_cliente_block.find(".validPrice").prop('checked', true);
				tipo_cliente_block.find(".precioTipoCliente").text(tipoClienteInfo.precio);
				tipo_cliente_block.find(".moneda").css('display', 'inline');

				todos.each(function (index, element) {
					if ($(element).text() != "")
						totalReserva += parseFloat($(element).text());
					}
				);
				$('#totalReserva').text("Total: " + totalReserva + " €");
			}
		});
	};

	//actualiza el tipo de cliente al cambiar la fecha de nacimiento
	$(document).on("change", '.fechaNacimiento', function () {
		calculoTipoCliente($(this));
	});

	//rellena los datos a partir del DNI
	$(document).on("click", '.searchDni', function () {
		var rowDivClick = $(this).parent();
		var rowBeforeClick = rowDivClick.prev();
		var dni = rowBeforeClick.find("input[name='dni']").val();

		if (dni.length > 0) {
			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/user/bookings/retrieveinfoclient",
				data: {
					dniClient: dni
				}
			}).done(function (clientData) {

				var clientObject = jQuery.parseJSON(clientData);

				if (!isEmpty(clientObject)) {
					var fecha_nacimiento_block = rowDivClick.next();
					var fechaNacimientoInput = fecha_nacimiento_block.find("input[name='fecha_nacimiento']");
					fechaNacimientoInput.val(clientObject.fecha_nacimiento);
					calculoTipoCliente(fechaNacimientoInput);
					var nombre_block = fecha_nacimiento_block.next().next();
					nombre_block.find("input[name='nombre']").val(clientObject.nombre);
					var last_name_block = nombre_block.next();
					last_name_block.find("input[name='apellidos']").val(clientObject.apellidos);
					var phone_block = last_name_block.next();
					phone_block.find("input[name='telefono']").val(clientObject.telefono);
					var email_block = phone_block.next();
					email_block.find("input[name='email']").val(clientObject.email);
				} else {
					alert("No se ha encontrado ningún cliente");
				}
			});
		} else {
			alert("DNI no válido");
		}
	});

	//confirmamos con el modal
	$(document).on('submit', '#ReservasForm', function (e) {
		e.preventDefault();
		$("#openModal").trigger("click");
	});

	$(document).on('click', '#confirmarReserva', function () {
		$(this).prop('disabled', true);
		$(this).val('Enviando reserva ...');
		$("#cerrarConfirmarReserva").trigger("click");

		var numero_personas = $('#numeroReservasSelect').val();
		var parada_id = $('#paradaSelect').val();
		var id_servicio = $("#serviceID").val();

		var dataForm = decodeURI($('#ReservasForm').serialize());
		var dataForm1 = dataForm.replace(/\+/g, '%20'); // 'Friday%20September%2013th'
		var dataForm2 = decodeURIComponent(dataForm1); // 'Friday September 13th'

		var dataFormParsed = dataForm2.split('&dni=').join('#dni=');
		if ($('#onlyMainPassenger').is(":checked")) {
			dataFormParsed = dataFormParsed.split('&fecha_nacimiento_clean=').join('#fecha_nacimiento_clean=');
		}
		$.ajax({
			method: "POST",
			url: window.location.origin + "/Dropbox/modelbook/user/bookings/savebooking",
			data: {
				id_servicio: id_servicio,
				paradaId: parada_id,
				dataClientsBooking: dataFormParsed,
				numClients: numero_personas,
				mainPassenger: $('#onlyMainPassenger').is(":checked")
			}
		}).done(function (data) {
			var dataResult = jQuery.parseJSON(data);

			var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(dataResult.bookingID);
			var input2 = $("<input>").attr("type", "hidden").attr("name", "idService").val(id_servicio);

			$('#finalForm').append($(input)).append($(input2)).submit();
		}).fail(function () {
			$(this).prop('disabled', false);
			$(this).val('Confirmar Reserva');
			$('#mensajeError').css('display', 'block').text("Se ha producido un error inesperado al realizar la reserva.");
		});
	});

	//actualiza la conversación
	$('#enviarMensaje').on("click", function () {
		var requestID = $('#requestID').val();
		var requestMessage = $('#peticionMensaje').val();

		if (requestMessage == "") {
			alert("Escriba un mensaje");
		} else {
			$.ajax({
				method: "POST",
				url: window.location.origin + "/Dropbox/modelbook/user/requests/sendmessage",
				data: {
					requestID: requestID,
					requestMessage: requestMessage
				}
			}).done(function (sendDate) {
				$('#messagesListRequest').append("<div class=' col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4'><div class='well'><span>" + requestMessage + "</span> <div style='width: 100%;text-align: right'> <span>" + sendDate + "</span> </div> </div></div>");
				$('#peticionMensaje').val("");
			});
		}
	});

	function isEmpty(obj) {
		for (var prop in obj) {
			if (obj.hasOwnProperty(prop))
				return false;
			}
		return true;
	}

});
