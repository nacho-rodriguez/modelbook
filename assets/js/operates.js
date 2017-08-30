/******************************************************************************/
/* admin - admin - admin - admin - admin - admin - admin - admin - admin - ad */
/******************************************************************************/

//añade id al acceder a un modelo disponible
window.operateCurrentModels = {
	'click input': function (e, value, row, index) {
		var modelID = row['_0_data']['model'];
		var input = $("<input>").attr("type", "hidden").attr("name", "model").val(modelID);
		$('#formCurrentListModels').append($(input));
	}
};

//añade id al acceder a un modelo no disponible
window.operatePastModels = {
	'click input': function (e, value, row, index) {
		var modelID = row['_0_data']['model'];
		var input = $("<input>").attr("type", "hidden").attr("name", "model").val(modelID);
		$('#formPastListModels').append($(input));
	}
};

//añade id al crear un servicio basado en un modelo
window.operateModelForService = {
	'click input': function (e, value, row, index) {
		var modelID = row['_0_data']['model'];
		var input = $("<input>").attr("type", "hidden").attr("name", "model").val(modelID);
		$('#formListModelsForServices').append($(input));
	}
};

//añade id al acceder a un servicio disponible
window.operateCurrentServices = {
	'click input': function (e, value, row, index) {
		var serviceID = row['_0_data']['service'];
		var input = $("<input>").attr("type", "hidden").attr("name", "service").val(serviceID);
		$('#formCurrentServices').append($(input));
	}
};

//añade id al acceder a un servicio no disponible
window.operatePastServices = {
	'click input': function (e, value, row, index) {
		var serviceID = row['_0_data']['service'];
		var input = $("<input>").attr("type", "hidden").attr("name", "service").val(serviceID);
		$('#formPastServices').append($(input));
	}
};

//añade el id antes de acceder a los detalles de la reserva
window.operateSearchBookingA = {
	'click input': function (e, value, row, index) {
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(row['_0_data']['booking']);

		$('#formCustomBookingSearchList').append($(input));
	}
};

window.operateClient = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['client'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idCliente").val(cID);
		$('#formListClients').append($(input));
	}
};

window.operateBookingClient = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];

		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "result").val(1);
		var input3 = $("<input>").attr("type", "hidden").attr("name", "idCliente").val($('#idCliente').val());

		$('#formBookingListClient').append($(input)).append($(input2)).append($(input3));
	}
};

window.operateBookingConfirmedFromSeller = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "idService").val($('#serviceID').val());
		var input3 = $("<input>").attr("type", "hidden").attr("name", "nameService").val($('#nameService').val());

		$('#formConfirmedBookingList').append($(input)).append($(input2)).append($(input3));
	}
};

window.operateBookingNonConfirmedFromSeller = {
	'click input': function (e, value, row) {
		var cID = row['_1_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "idService").val($('#serviceID').val());
		var input3 = $("<input>").attr("type", "hidden").attr("name", "nameService").val($('#nameService').val());

		$('#formNonConfirmedBookingList').append($(input)).append($(input2)).append($(input3));
	}
};

window.operateCancelledBooking = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "idService").val($('#serviceID').val());
		var input3 = $("<input>").attr("type", "hidden").attr("name", "nameService").val($('#nameService').val());

		$('#cancelledBookingForm').append($(input)).append($(input2)).append($(input3));
	}
};

//añade el id antes de acceder a los datos de la reserva
window.operateBookingServices = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['service'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idService").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "nameService").val(row[1]);
		var input3 = $("<input>").attr("type", "hidden").attr("name", "dateService").val(row[2] + " - " + row[3]);
		$('#formFilterByServiceBooking').append($(input)).append($(input2)).append($(input3)).submit();
	}
};

window.operateCurrentCloseoutA = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);
		$('#formCurrentPaymentsBookingList').append($(input));
	}
};

window.operateCurrentCloseoutOnSearch = {
	'click input': function (e, value, row) {
		var cID = row['_1_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);

		$('#formCurrentPaymentsBookingList').append($(input));
	}
};

window.operateGeneratePDFCloseoutA = {
	'click input': function (e, value, row) {
		var cID = row['_1_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idCloseoutDocument").val(cID);

		$('#formCloseoutDocuments').append($(input));
	}
};

window.operateCancelBookingA = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idBooking").val(cID);

		$('#formCancelledBookings').append($(input));
	}
};

window.operateBookingSellers = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['seller'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idSeller").val(cID);
		var input2 = $("<input>").attr("type", "hidden").attr("name", "nameSeller").val(row['1']);
		$('#formFilterBySellerBooking').append($(input)).append($(input2)).submit();
	}
};

window.operateCloseoutsSeller = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['seller'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idSeller").val(cID);
		$('#formListSellers').append($(input));
	}
};

/*Peticiones*/
window.operateRequests = {
	'click input': function (e, value, row, index) {
		var requestID = row['_0_data']['request'];
		var input = $("<input>").attr("type", "hidden").attr("name", "request").val(requestID);
		$('#formListRequests').append($(input));
		//$('#formListServices').submit();
	}
};

window.operateRequest = {
	'click input': function (e, value, row) {
		var requestID = row['_0_data']['request'];
		var input = $("<input>").attr("type", "hidden").attr("name", "requestID").val(requestID);

		$('#formListRequests').append($(input));
	}
};

window.operatePrices = {
	'click input': function (e, value, row, index) {
		var requestID = row['_0_data']['price'];
		var input = $("<input>").attr("type", "hidden").attr("name", "price").val(requestID);

		$('#formListTypePrices').append($(input));
	}
};

window.operateTypeServices = {
	'click input': function (e, value, row, index) {
		var requestID = row['_0_data']['typeservice'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idTypeService").val(requestID);

		$('#formListTypeServices').append($(input));
	}
};

/******************************************************************************/
/* seller - seller - seller - seller - seller - seller - seller - seller - se */
/******************************************************************************/

window.operateSeller = {
	'click input': function (e, value, row, index) {
		var sellerID = row['_0_data']['seller'];
		var input = $("<input>").attr("type", "hidden").attr("name", "seller").val(sellerID);

		$('#formListSellers').append($(input));
	}
};

window.operateEvents = {
	'click input': function (e, value, row, index) {
		var serviceID = row['_0_data']['service'];
		var input = $("<input>").attr("type", "hidden").attr("name", "service").val(serviceID);
		//var input = $("<input>").attr("type", "hidden").attr("name", "service").val(row['_0_data']['service']);

		var sellerID = parseInt($("#sellerLab").text());
		var input2 = $("<input>").attr("type", "hidden").attr("name", "seller").val(sellerID);
		$('#formListServices').append($(input)).append($(input2));
		$('#formListNServices').append($(input)).append($(input2));
	}
};

/******************************************************************************/
/* user - user - user - user - user - user - user - user - user - user - user */
/******************************************************************************/

//añade el id antes de acceder a los detalles de la reserva
window.operateSearchBookingU = {
	'click input': function (e, value, row, index) {
		var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(row['_0_data']['booking']);

		$('#formCustomBookingSearchList').append($(input));
	}
};

window.operateCancelBookingU = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];

		var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(cID);
		var inputRes = $("<input>").attr("type", "hidden").attr("name", "result").val(0);
		var inputCodeBack = $("<input>").attr("type", "hidden").attr("name", "codeBack").val(3); // Consult booking from closeouts

		$('#formCancelledBookings').append($(input)).append($(inputRes)).append($(inputCodeBack));
	}
};

window.operateBooking = {
	'click input': function (e, value, row) {
		var serviceID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(serviceID);
		var inputRes = $("<input>").attr("type", "hidden").attr("name", "result").val(0);
		$('#formCurrentBookingList').append($(input)).append($(inputRes));
	}
};

window.operatePastBooking = {
	'click input': function (e, value, row) {
		var serviceID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(serviceID);
		var inputRes = $("<input>").attr("type", "hidden").attr("name", "result").val(0);
		$('#formPastBookingList').append($(input)).append($(inputRes));
	}
};

window.operateGeneratePDFCloseoutU = {
	'click input': function (e, value, row) {
		var cID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "idCloseoutDocument").val(cID);
		$('#formCloseoutDocuments').append($(input));
	}
};

window.operateCurrentCloseoutU = {
	'click input': function (e, value, row) {
		var serviceID = row['_0_data']['booking'];
		var input = $("<input>").attr("type", "hidden").attr("name", "bookingID").val(serviceID);
		var inputRes = $("<input>").attr("type", "hidden").attr("name", "result").val(0);
		var inputCodeBack = $("<input>").attr("type", "hidden").attr("name", "codeBack").val(3); // Consult booking from closeouts
		$('#formCurrentPaymentsBookingList').append($(input)).append($(inputRes)).append($(inputCodeBack));
	}
};
