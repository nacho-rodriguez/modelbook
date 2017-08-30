<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
        $this->load->model('users_model', 'um');
    }

    public function showListBookings()
    {
        if ($this->um->imAdmin()) {
            $data['title'] = 'Servicios disponibles';
            $data['backRoute'] = 'admin/dashboard';
            $data['services_availables'] = $this->serm->getServicesCurrentlyAvailables();
            $this->load->view('admin/bookings/show_bookings', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsBooking()
    {
        $id_booking = $this->input->post('idBooking');
        $idService = $this->input->post('idService');
        $nameService = $this->input->post('nameService');
		$dateService = $this->input->post('dateService');
		$idCliente = $this->input->post('idCliente');

        $infoSeller = $this->boom->getSellerFromBooking($id_booking);
        $id_seller = $infoSeller->id_vendedor; //$this->input->post("idCliente");
        $codeBack = $this->input->post('codeBack');

        $data['bookingInfo'] = $this->boom->getBooking($id_booking, $infoSeller->id_vendedor);
        $data['codeBack'] = $codeBack ? $codeBack : 4;
        $data['idSeller'] = $id_seller;
		$data['idService'] = $idService;
		$data['idCliente'] = $idService;
		$data['nameService'] = $nameService;
		$data['dateService'] = $dateService;
        $data['sellerName'] = $infoSeller->nombre;
        $data['title'] = 'Detalles de la reserva';
        $this->load->view('admin/bookings/details_booking', $data);
    }

    public function showBookings()
    {
        $id_service = $this->input->post('idService');
        $name_service = $this->input->post('nameService');
        $dateService = $this->input->post('dateService');

        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/bookings/showlistbookings';
            $data['cancelledBooking'] = $this->boom->getCancelledBookingsFromService($id_service);
            $data['confirmedBooking'] = $this->boom->getBookingsConfirmedByService($id_service);
            $data['idService'] = $id_service;
            $data['nameService'] = $name_service;
			$data['dateService'] = $dateService;
            $data['nonConfirmedBooking'] = $this->boom->getBookingsNotConfirmedByService($id_service);
            $data['title'] = 'Reservas: '.$name_service;
            $this->load->view('admin/bookings/new_booking', $data);
        } else {
            redirect(index_page());
        }
    }

	//cancela la reserva
    public function cancelBooking()
    {
        $id_booking = $this->input->post('bookingID');
        //$infoSeller = $this->boom->getSellerFromBooking($id_booking);

        $this->boom->cancelBooking($id_booking);

		$data['backRoute'] = 'admin/dashboard';
		$data['services_availables'] = $this->serm->getServicesCurrentlyAvailables();
		$data['title'] = 'Servicios';
		$this->session->set_flashdata('success', 'La reserva se ha anulado correctamente.');
		$this->load->view('admin/bookings/show_bookings', $data);
    }

	//confirma las reservas seleccionadas
    public function confirmBooking()
    {
        $id_service = $this->input->post('idService');
        $name_service = $this->input->post('nameService');
        $selectBooking = $this->input->post('bookingSelected');

        if ($selectBooking != '') {
            $allBookingID = explode(',', $selectBooking);

			foreach ((array)$allBookingID as $reserva) {
                $this->boom->confirmBooking($reserva);
            }
        }

        $data['backRoute'] = 'admin/bookings/showbookings';
        $data['cancelledBooking'] = $this->boom->getCancelledBookingsFromService($id_service);
        $data['confirmedBooking'] = $this->boom->getBookingsConfirmedByService($id_service);
        $data['idService'] = $id_service;
        $data['nameService'] = $name_service;
        $data['nonConfirmedBooking'] = $this->boom->getBookingsNotConfirmedByService($id_service);
        $data['title'] = 'Reservas: '.$name_service;
        $this->load->view('admin/bookings/new_booking', $data);
    }

    public function createAllBookingsPdf()
	{
		$idService = $this->input->post('serviceID');
		//load the view and saved it into $html variable
		$data['pdfStructure'] = $this->boom->getServiceStructureToPrint($idService);
		$data['companyData'] = $this->um->getConfig();
		$html = $this->load->view('admin/bookings/pdf_bookings', $data, true);
		//this the the PDF filename that user will get to download
		$pdfFileName = 'lista_de_reservas.pdf';
		header('Content-Type: application/pdf', false);

		$pdf = new mPDF('utf-8');
		$pdf->allow_charset_conversion = true;
		//generate the PDF from the given html
		$pdf->SetHTMLFooter('<div class="col-lg-12 col-md-12 text-center"><span>'.$data['companyData']->empresa.' - C.I.: '.$data['companyData']->codigo_identificacion.' - CIF: '.$data['companyData']->cif.'</span><br><span>'.$data['companyData']->direccion.' - '.$data['companyData']->poblacion.' ('.$data['companyData']->provincia.')</span><br> 		<span>Tlf: '.$data['companyData']->telefono.' - Email: '.$data['companyData']->email_empresa.'</span></div>');

		$pdf->AddPage('', '', '', '', '', '', '',
			'', // margin top
	        30); // margin bottom
			
		$pdf->WriteHTML(file_get_contents('./assets/css/theme/bootstrap.min.css'), 1);
		$pdf->WriteHTML($html, 2);

		//download it.
		$pdf->Output($pdfFileName, 'D');
	}
}
