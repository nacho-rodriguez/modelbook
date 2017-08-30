<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Closeouts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('closeouts_model', 'clom');
        $this->load->model('users_model', 'um');
    }

    public function detailsCloseouts()
    {
        $id_seller = $this->session->userdata('id_user');

        if ($this->um->imSeller()) {
            $data['backRoute'] = 'user/dashboard';
            $data['cancelledBookings'] = $this->boom->getCancelledBookings($id_seller);
            $data['pendingPaymetsBooking'] = $this->boom->getPendingPaymentsBooking($id_seller);
            $data['resumeInfo'] = $this->boom->getResumeInfo($id_seller);
			$data['title'] = 'Liquidaciones de '. $this->selm->getSeller($id_seller)->nombre;
            $data['user'] = $this->session->userdata('user');
            $this->load->view('user/closeouts/details_closeouts', $data);
        } else {
            redirect(index_page());
        }
    }

    public function showEmissions()
    {
        $id_seller = $this->session->userdata('id_user');
        $closeoutSelect = $this->input->post('optionSelected');
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

        $data['backRoute'] = 'user/closeouts/detailscloseouts';
        $data['endDateBegin'] = $endDateBegin;
        $data['endDateEnd'] = $endDateEnd;
        $data['id_user'] = $id_seller;
        $data['startDateBegin'] = $startDateBegin;
        $data['startDateEnd'] = $startDateEnd;
		$data['title'] = 'Emisiones de reservas de '. $this->selm->getSeller($id_seller)->nombre;
        $data['user'] = $this->session->userdata('user');

        if ($closeoutSelect == 1) { // Pendientes
            $data['pendingPaymetsBooking'] = $this->boom->getPendingPaymentsBookingFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd);
            $data['optionSelected'] = 1;
        } else { // Liquidadas
            $data['pastPaymentsBooking'] = $this->boom->getPastPaymentsBooking($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd);
            $data['optionSelected'] = 2;
        }

        $this->load->view('user/closeouts/show_emissions', $data);
    }

    public function showCloseouts()
    {
        $id_seller = $this->session->userdata('id_user');
        $closeoutSelect = $this->input->post('optionSelected') ? $this->input->post('optionSelected') : 1;
        $startDateBegin = $this->input->post('startDateBegin') ? $this->input->post('startDateBegin') : '';
        $endDateBegin = $this->input->post('endDateBegin') ? $this->input->post('endDateBegin') : '';
        $startDateEnd = $this->input->post('startDateEnd') ? $this->input->post('startDateEnd') : '';
        $endDateEnd = $this->input->post('endDateEnd') ? $this->input->post('endDateEnd') : '';

        $data['backRoute'] = 'user/closeouts/detailscloseouts';
        $data['title'] = 'Documentos de liquidación de '. $this->selm->getSeller($id_seller)->nombre;
        $data['idSeller'] = $id_seller;
        $data['startDateBegin'] = $startDateBegin;
        $data['endDateBegin'] = $endDateBegin;
        $data['startDateEnd'] = $startDateEnd;
        $data['endDateEnd'] = $endDateEnd;
        $data['optionSelected'] = $closeoutSelect;

        $data['closeoutDocuments'] = $this->clom->getCloseoutDocumentsBySellerFromDates($id_seller, $startDateBegin, $endDateBegin, $startDateEnd, $endDateEnd, $closeoutSelect);

        $this->load->view('user/closeouts/show_closeouts', $data);
    }
}
