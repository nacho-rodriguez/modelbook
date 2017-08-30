<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('bookings_clients_model', 'bcm');
        $this->load->model('bookings_prices_model', 'booprim');
        $this->load->model('clients_model', 'clim');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
        $this->load->model('services_prices_model', 'sprim');
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('users_model', 'um');
    }

    public function showServices()
    {
        if ($this->um->imSeller()) {
            $data['backRoute'] = 'user/dashboard';
            $data['id_user'] = $this->session->userdata('id_user');
            $data['services_availables'] = $this->serm->getServicesAvailablesShortInfo($data['id_user']);
            $data['title'] = 'Servicios';
            $data['user_email'] = $this->session->userdata('user_email');
            $data['user'] = $this->session->userdata('user');
            $this->load->view('user/bookings/new_booking', $data);
        } else {
            redirect(index_page());
        }
    }

    public function getServiceInformation()
    {
        $id_service = $this->input->post('id_servicio');
        $id_seller = $this->input->post('id_vendedor');

        if ($id_seller == '') {
            $id_seller = $this->session->userdata('id_user');
        }
        $info_service = $this->serm->getService($id_service);
        $pricesTable = $this->sprim->getComisionesFromSellerAndService($id_seller, $id_service);

        $info_service->price_table = $pricesTable;

        echo json_encode($info_service);
    }

    public function newBooking()
    {
        $id_service = $this->input->post('idService');
        $id_user = $this->session->userdata('id_user');

        $data['backRoute'] = 'user/bookings/showservices';
        $data['id_service'] = $id_service;
        $data['id_user'] = $id_user;
        $data['serviceInfo'] = $this->serm->getServiceInformationForBooking($id_service, $id_user);
        $data['title'] = 'Nueva reserva';
        $data['today'] = "'".date("Y-m-d")."'";
        $data['user_email'] = $this->session->userdata('user_email');
        $data['user'] = $this->session->userdata('user');
        $this->load->view('user/bookings/show_clients', $data);
    }


    public function getTypeClient()
    {
        $id_service = $this->input->post('idServicio');
        $fecha_nac = date_create($this->input->post('fecha'));
        $id_seller = $this->session->userdata('id_user');

        $dateServicio = date_create($this->serm->getStartDate($id_service));

        $tipoClienteFinal = array();

        if ($fecha_nac) {
            $edad_cliente = date_diff($dateServicio, $fecha_nac)->format('%y');

            $allPricesServiceForThisSeller = $this->typeclim->getTypeClientForServiceAndSeller($id_service, $id_seller);

            $i = 0;
            while ($i < count($allPricesServiceForThisSeller)) {
                if ($edad_cliente >= $allPricesServiceForThisSeller[$i]->edad_minima && $edad_cliente <= $allPricesServiceForThisSeller[$i]->edad_maxima
                ) {
                    $tipoClienteFinal['id_tipo_cliente'] = $allPricesServiceForThisSeller[$i]->id_tipo_cliente;
                    $tipoClienteFinal['nombre'] = $allPricesServiceForThisSeller[$i]->nombre;
                    $tipoClienteFinal['precio'] = $allPricesServiceForThisSeller[$i]->valor_monetario;

                    $i = count($allPricesServiceForThisSeller);
                }
                ++$i;
            }
        }

        echo json_encode($tipoClienteFinal);
    }

    public function retrieveInfoClient()
    {
        $dni = $this->input->post('dniClient');
        $data_client = $this->clim->getClientByDni($dni);

        echo json_encode($data_client);
    }

    public function saveBooking()
    {
        $id_service = $this->input->post('id_servicio');
        $id_seller = $this->session->userdata('id_user');
        //$id_seller = $this->input->post('id_user');		//phpstorm
        $clients = $this->input->post('dataClientsBooking');
        $num_clients = $this->input->post('numClients');
        $id_parada = $this->input->post('paradaId');
        $main_passenger = $this->input->post('mainPassenger');

        // Comprobar que hay reservas disponibles para este servicio y puedo registrar las actuales.
        $dataCheckBookingisAvailableOrNot = $this->boom->checkBookingAvailability($id_service, $num_clients);

        // Actualizar el contador de billetes
        $numero_billete_reserva = $this->um->increaseBookingNumber();

        $id_booking = 0;
        if ($dataCheckBookingisAvailableOrNot['status'] == "ok") {
            $id_booking = $this->boom->insertNewBooking($numero_billete_reserva, $id_service, $id_seller, $id_parada, $main_passenger);
			$this->session->set_flashdata('success', 'La reserva se ha registrado correctamente.');
        } else {
            // Dejar la reserva como no confirmada
            $id_booking = $this->boom->insertNewBookingNotConfirmed($numero_billete_reserva, $id_service, $id_seller, $id_parada, $main_passenger);
			$this->session->set_flashdata('warning', 'No hay suficientes plazas disponibles para este servicio. La reserva se ha registrado como \'No confirmada\'. Por favor, contacte con el administrador para confirmar la reserva.');
            // Enviar email al administrador informando de que se ha llenado de plazas el servicio
            $this->sendEmailBookingNoConfirmed($id_booking, $id_seller, $id_service, $num_clients);
        }
		$dataCheckBookingisAvailableOrNot['bookingID'] = $id_booking;

        $this->clonePricesOfServiceInThisMomentToThisBooking($id_booking, $id_service, $id_seller);

        // Registrar los clientes a la reserva
        $all_emails_clientes = $this->insertClientsToRecentBooking($id_booking, $clients, $num_clients, $main_passenger);

        // Envio el email de la reserva a los clientes, al vendedor y a gestor
        $this->sendEmailBooking($id_booking, $id_seller, $id_service, $num_clients, $all_emails_clientes);

        echo json_encode($dataCheckBookingisAvailableOrNot);
    }

    public function clonePricesOfServiceInThisMomentToThisBooking($id_booking, $id_service, $id_seller)
    {
        $pricesService = $this->sprim->getComisionesFromSellerAndService($id_seller, $id_service);

		foreach ($pricesService as $priceService) {
        	$this->booprim->insertBookingPrice($priceService, $id_booking);
        }
    }

    public function sendEmailBookingNoConfirmed($id_booking, $id_seller, $id_service, $num_client)
    {
        $data['user'] = $this->session->userdata('user');
        $data['user_email'] = $this->session->userdata('user_email');

        $serviceInfo = $this->serm->getFullNameService($id_service);
        $fullSeller = $this->selm->getSeller($id_seller);
        $bookingInfo = $this->boom->getShortInfo($id_booking);

        $this->email->from('no_reply@modelbook.com', 'Gestor de reservas y viajes');
        $this->email->to($this->um->getAdminEmail());
        $this->email->subject('Reservas no confirmadas: '.$serviceInfo->nombre.' ('.$serviceInfo->referencia.')');

        $complete_message = 'Se ha realizado una reserva con las plazas del servicio agotadas del vendedor '.$fullSeller->nombre.' con los siguientes datos: ';
        $complete_message .= 'Nombre del servicio y código de referencia: '.$serviceInfo->nombre.' ('.$serviceInfo->referencia.')';
        $complete_message .= 'Fecha de inicio: '.$serviceInfo->fecha_inicio;
        $complete_message .= 'Número identificacdor de la reserva: '.$bookingInfo->numero_billete.'/'.$bookingInfo->year_reserva;
        $complete_message .= 'Total personas: '.$num_client;
        $complete_message .= 'Por favor, revise esta reserva.';

        $this->email->message($complete_message);
        $this->email->send();
    }

    public function sendEmailBooking($id_booking, $id_seller, $id_service, $num_client, $emails_clientes)
    {
        $data['user'] = $this->session->userdata('user');
        $data['user_email'] = $this->session->userdata('user_email');

        $serviceInfo = $this->serm->getFullNameService($id_service);
        $fullSeller = $this->selm->getSeller($id_seller);
        $bookingInfo = $this->boom->getShortInfo($id_booking);

        $emailsVendedor = $this->selm->getSellerEmail($id_seller);

        $this->email->from('no_reply@modelbook.com', 'Gestor de reservas y viajes');
        $this->email->to($emailsVendedor.','.$emails_clientes.$this->um->getAdminEmail());
        $this->email->subject('Nueva reserva: '.$serviceInfo->nombre.'/'.$serviceInfo->referencia);

        $complete_message = 'Confirmación de una nueva reserva realizada por '.$fullSeller->nombre.' con los siguientes datos:\n';
        $complete_message .= 'Nombre del servicio y código de referencia: '.$serviceInfo->nombre.'/'.$serviceInfo->referencia.'\n';
        $complete_message .= 'Fecha de inicio: '.$serviceInfo->fecha_inicio.'\n';
        $complete_message .= 'Número ID reserva: '.$bookingInfo->numero_billete.'/'.$bookingInfo->year_reserva;
        $complete_message .= 'Total personas: '.$num_client;

        $this->email->message($complete_message);
        $this->email->send();
    }

    public function insertClientsToRecentBooking($id_booking, $clientsFullList, $num_clients, $main_passenger)
    {
        $allEmails = "";
        $clientsList = explode('#', $clientsFullList);

        if (strcmp($main_passenger, 'true') === 0) {
                $dataClientList = $clientsList[1];
                $dataClientListParsed = explode('&', $dataClientList);

                $dniFULL = explode('=', $dataClientListParsed[0]);
                $fechanacFULL = explode('=', $dataClientListParsed[1]);
                $fullName = explode('=', $dataClientListParsed[2]);
                $fullSurname = explode('=', $dataClientListParsed[3]);
                $fullPhone = explode('=', $dataClientListParsed[4]);
                $emailFULL = explode('=', $dataClientListParsed[5]);

                $dni = $dniFULL[1];
                $fecha_nac = $fechanacFULL[1];
                $name = $fullName[1];
                $surname = $fullSurname[1];
                $phone = $fullPhone[1];
                $email = $emailFULL[1];

            if ($email != "") {
                $allEmails .= $email . ",";
            }
                $id_client = $this->clim->getIDClientByDni($dni);
            if ($id_client !== 0) {
                $this->clim->updateClient($id_client, $dni, $name, $surname, $fecha_nac, $phone, $email);
            } else {
                $id_client = $this->clim->insertNewClient($dni, $name, $surname, $fecha_nac, $phone, $email);
            }

                $this->bcm->insertNewRelationBookingClient($id_booking, $id_client);

                // Add rest of the passengers
            for ($i = 1; $i < $num_clients; $i++) {
                $dataClientList = $clientsList[$i+1];

                $fechanacFULL = explode('=', $dataClientList);
                $fecha_nac = $fechanacFULL[1];

                $id_client = $this->clim->insertNewClient("Sin DNI", '', '', $fecha_nac, '', '');
                $this->bcm->insertNewRelationBookingClient($id_booking, $id_client);
            }
        } else {
            for ($i = 1; $i < count($clientsList); $i++) {

                $dataClientList = $clientsList[$i];
                $dataClientListParsed = explode('&', $dataClientList);

                $dniFULL = explode('=', $dataClientListParsed[0]);
                $fechanacFULL = explode('=', $dataClientListParsed[1]);
                $fullName = explode('=', $dataClientListParsed[2]);
                $fullSurname = explode('=', $dataClientListParsed[3]);
                $fullPhone = explode('=', $dataClientListParsed[4]);
                $emailFULL = explode('=', $dataClientListParsed[5]);

                $dni = $dniFULL[1];
                $fecha_nac = $fechanacFULL[1];
                $name = $fullName[1];
                $surname = $fullSurname[1];
                $phone = $fullPhone[1];
                $email = $emailFULL[1];

                if ($email != "") {
                    $allEmails .= $email . ",";
                }
                $id_client = $this->clim->getIDClientByDni($dni);

                if ($id_client !== 0) {
                    $this->clim->updateClient($id_client, $dni, $name, $surname, $fecha_nac, $phone, $email);
                } else {
                    $id_client = $this->clim->insertNewClient($dni, $name, $surname, $fecha_nac, $phone, $email);
                }
                $this->bcm->insertNewRelationBookingClient($id_booking, $id_client);
            }
        }

        return $allEmails;
    }

    public function showBookings()
    {
        $id_user = $this->session->userdata('id_user');

        $data['backRoute'] = 'user/bookings/showservices';
        $data['bookingData'] = $this->boom->getAllBookingFromSeller($id_user);
        $data['id_user'] = $id_user;
        $data['title'] = 'Reservas';
        $data['user'] = $this->session->userdata('user');
        $this->load->view('user/bookings/show_bookings', $data);
    }

    public function getDataToBookingDetails()
    {
        $id_user = $this->session->userdata('id_user');
		$id_booking = $this->input->post('bookingID');

		$data['codeBack'] = $this->input->post('codeBack') ? $this->input->post('codeBack') : 1;

        $data['bookingInfo'] = $this->boom->getBooking($id_booking, $id_user);
        $data['id_user'] = $id_user;
        $data['result'] = $this->input->post('result');
        $data['title'] = 'Detalles de la reserva';
        $data['user'] = $this->session->userdata('user');
        return $data;
    }

    public function detailsBooking()
    {
        $data = $this->getDataToBookingDetails();

        $this->load->view('user/bookings/details_booking', $data);
    }

    public function bookingDetailsFromNew()
    {
        $data = $this->getDataToBookingDetails();

        $data['idService'] = $this->input->post('idService');
        $this->load->view('user/bookings/details_booking', $data);
    }

    public function createBookingPdf()
    {
        $id_booking = $this->input->post('bookingID');

        $dataSeller = $this->boom->getSellerFromBooking($id_booking);
        //load the view and saved it into $html variable
        $data['companyData'] = $this->um->getConfig();
        $data['sellerData'] = $this->selm->getSeller($dataSeller->id_vendedor);
        $data['bookingInfo'] = $this->boom->getBooking($id_booking, $dataSeller->id_vendedor);
        $data['result'] = $this->input->post('result');
        $html = $this->load->view('user/bookings/pdf_bookings', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFileName = 'reserva.pdf';
        header('Content-Type: application/pdf', false);

        $pdf = new mPDF('utf-8');
        $pdf->allow_charset_conversion = true;
		//generate the PDF from the given html
		$pdf->SetHTMLFooter('<div class="col-lg-12 col-md-12 text-center"><span>'.$data['companyData']->empresa.' - C.I.: '.$data['companyData']->codigo_identificacion.' - CIF: '.$data['companyData']->cif.'</span><br><span>'.$data['companyData']->direccion.' - '.$data['companyData']->poblacion.' ('.$data['companyData']->provincia.')</span><br> 		<span>Tlf: '.$data['companyData']->telefono.' - Email: '.$data['companyData']->email_empresa.'</span></div>');

		$pdf->AddPage('', '', '', '', '', '', '',
			'', // margin top
	        30); // margin bottom

        //generate the PDF from the given html
        $pdf->WriteHTML(file_get_contents('./assets/css/theme/bootstrap.min.css'), 1);
        $pdf->WriteHTML($html, 2);

        //download it.
        $pdf->Output($pdfFileName, 'D');
    }
}
