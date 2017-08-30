<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Closeouts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('closeouts_model', 'clom');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('users_model', 'um');
    }

    public function showSellers()
    {
        if ($this->um->imAdmin()) {
            $data['all_sellers'] = $this->selm->getAllSellers();
            $data['backRoute'] = 'admin/dashboard';
            $data['title'] = 'Vendedores disponibles';
            $this->load->view('admin/closeouts/show_sellers', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsCloseouts()
    {
        $id_seller = $this->input->post('idSeller');

        if ($this->um->imAdmin()) {
			$data['backRoute'] = 'admin/closeouts/showsellers';
			$data['cancelledBookings'] = $this->boom->getCancelledBookings($id_seller);
			$data['idSeller'] = $id_seller;
			$data['pendingPaymetsBooking'] = $this->boom->getPendingPaymentsBooking($id_seller);
			$data['resumeInfo'] = $this->boom->getResumeInfo($id_seller);
			$data['title'] = 'Liquidaciones de '. $this->selm->getSeller($id_seller)->nombre;
            $this->load->view('admin/closeouts/details_closeouts', $data);
        } else {
            redirect(index_page());
        }
    }

    public function closeoutEmission()
    {
        $id_seller = $this->input->post('idCliente');
        $selectBooking = $this->input->post('closeoutSelected');
        $dateCloseout = $this->input->post('dateCloseout');
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

        $data = [];

        if ($selectBooking != '') {
            $allBookingID = explode(',', $selectBooking);

            // Make a document with all closeouts selected
            $closeoutID = $this->clom->insertCloseout($dateCloseout);
            $data['liquidacionDone'] = $closeoutID;
            $data['fecha_cobro'] = date_format(date_create($dateCloseout), 'd/m/Y');

			foreach ((array)$allBookingID as $reserva) {
                $this->boom->confirmCloseoutBooking($reserva, $closeoutID);
            }

			$this->session->set_flashdata('success', 'Se ha emitido el documento de liquidación '.$data['liquidacionDone'].' con fecha de cobro '.$data['fecha_cobro'].' correctamente.');
        }

        $data['pendingPaymetsBooking'] = $this->boom->getPendingPaymentsBookingFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd);

        $data['backRoute'] = 'admin/closeouts/detailscloseouts';
        $data['codeBack'] = 2;
        $data['endDateBegin'] = $endDateBegin;
        $data['endDateEnd'] = $endDateEnd;
        $data['idSeller'] = $id_seller;
        $data['optionSelected'] = 1;
        $data['startDateBegin'] = $startDateBegin;
        $data['startDateEnd'] = $startDateEnd;
		$data['title'] = 'Liquidaciones de '. $this->selm->getSeller($id_seller)->nombre;
        $this->load->view('admin/closeouts/show_emissions', $data);
    }

    public function closeoutPayment()
    {
        $id_seller = $this->input->post('idCliente');
        $closeoutSelect = $this->input->post('closeoutSelected') ? $this->input->post('closeoutSelected') : 1;
        $fecha_cobro = $this->input->post('dateCloseout');
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

        $data = [];

        if ($closeoutSelect != '') {
            $allDocumentsIDs = explode(',', $closeoutSelect);
            $data['fecha_cobro'] = date_format(date_create($fecha_cobro), 'd/m/Y');

			foreach ((array)$allDocumentsIDs as $id_closeout) {
                $this->clom->confirmCloseoutDocuments($id_closeout, $fecha_cobro);

			$this->session->set_flashdata('success', 'Se han realizado las liquidaciones de los documentos con fecha de cobro ' .$data['fecha_cobro'].' correctamente.');
            }
        }

        $data['backRoute'] = 'admin/closeouts/detailscloseouts';
        $data['closeoutDocuments'] = $this->clom->getCloseoutDocumentsBySellerFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd, 1);
        $data['codeBack'] = 2;
        $data['endDateBegin'] = $endDateBegin;
        $data['endDateEnd'] = $endDateEnd;
        $data['idSeller'] = $id_seller;
        $data['optionSelected'] = 1;
        $data['startDateBegin'] = $startDateBegin;
        $data['startDateEnd'] = $startDateEnd;
        $data['title'] = 'Documentos de liquidación de '. $this->selm->getSeller($id_seller)->nombre;
        $this->load->view('admin/closeouts/show_closeouts', $data);
    }

    public function showEmissions()
    {
        $id_seller = $this->input->post('idSeller');
        $closeoutSelect = $this->input->post('optionSelected') ? $this->input->post('optionSelected') : 1;
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

		if ($closeoutSelect == 1) { // Pendientes
            $data['pendingPaymetsBooking'] = $this->boom->getPendingPaymentsBookingFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd);
            $data['optionSelected'] = 1;
        } else { // Liquidadas
            $data['pastPaymentsBooking'] = $this->boom->getPastPaymentsBooking($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd);
            $data['optionSelected'] = 2;
        }

		$data['title'] = 'Emisiones de reservas de '. $this->selm->getSeller($id_seller)->nombre;
        $data['backRoute'] = 'admin/closeouts/detailscloseouts';
        $data['codeBack'] = 2;
        $data['endDateBegin'] = $endDateBegin;
        $data['endDateEnd'] = $endDateEnd;
        $data['idSeller'] = $id_seller;
        $data['startDateBegin'] = $startDateBegin;
        $data['startDateEnd'] = $startDateEnd;
        $this->load->view('admin/closeouts/show_emissions', $data);
    }

    public function showCloseouts()
    {
        $id_seller = $this->input->post('idSeller');
        $closeoutSelect = $this->input->post('optionSelected') ? $this->input->post('optionSelected') : 1;
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

        $data['backRoute'] = 'admin/closeouts/detailscloseouts';
        $data['closeoutDocuments'] = $this->clom->getCloseoutDocumentsBySellerFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd, $closeoutSelect);
        $data['codeBack'] = 2;
        $data['endDateBegin'] = $endDateBegin;
        $data['endDateEnd'] = $endDateEnd;
        $data['idSeller'] = $id_seller;
        $data['optionSelected'] = $closeoutSelect;
        $data['startDateBegin'] = $startDateBegin;
        $data['startDateEnd'] = $startDateEnd;
        $data['title'] = 'Documentos de liquidación de '. $this->selm->getSeller($id_seller)->nombre;
        $this->load->view('admin/closeouts/show_closeouts', $data);
    }

    public function closeoutDocPdf()
    {
        $id_closeout = $this->input->post('idCloseoutDocument');

        $dataSeller = $this->clom->getSellerInfoFromCloseoutDocument($id_closeout);
        $data['sellerData'] = $dataSeller;
        $data['idCloseoutDoc'] = $id_closeout;

        //load the view and saved it into $html variable
        $data['closeoutDocument'] = $this->clom->getCloseoutDocumentForPrint($id_closeout);
        $data['companyData'] = $this->um->getConfig();

        $html = $this->load->view('admin/closeouts/pdf_closeout_doc', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFileName = 'documento_liquidacion.pdf';
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

    public function pendingCloseoutsPdf()
    {
        $id_seller = $this->input->post('idSeller');
        $infoSeller = $this->selm->getSeller($id_seller);
		$data['sellerData'] = $infoSeller;

        //load the view and saved it into $html variable
        $data['resumenInfo'] = $this->boom->getResumeInfo($id_seller);
        $data['companyData'] = $this->um->getConfig();

        $html = $this->load->view('admin/closeouts/pdf_pending_closeouts', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFileName = 'liquidaciones_pendientes.pdf';
        header('Content-Type: application/pdf', false);

        $pdf = new mPDF('utf-8');
        $pdf->allow_charset_conversion = true;
        //generate the PDF from the given html
		$pdf->SetHTMLFooter('<div class="col-lg-12 col-md-12 text-center"><span>'.$data['companyData']->empresa.' - C.I.: '.$data['companyData']->codigo_identificacion.' - CIF: '.$data['companyData']->cif.'</span><br><span>'.$data['companyData']->direccion.' - '.$data['companyData']->poblacion.' ('.$data['companyData']->provincia.')</span><br> 		<span>Tlf: '.$data['companyData']->telefono.' - Email: '.$data['companyData']->email_empresa.'</span></div>');

		$pdf->AddPage('', '', '', '', '', '', '',
			'', // margin top
			40); // margin bottom

		$pdf->WriteHTML(file_get_contents('./assets/css/theme/bootstrap.min.css'), 1);
        $pdf->WriteHTML($html, 2);

        //download it.
        $pdf->Output($pdfFileName, 'D');
    }
}
