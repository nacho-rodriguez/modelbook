<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends CI_Controller
{
    protected static $ADMIN = 1;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model', 'reqm');
        $this->load->model('requests_messages_model', 'reqmm');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('users_model', 'um');
    }

    public function showRequests()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/dashboard';
            $data['result'] = 0;
            $data['title'] = 'Peticiones';
            $data['all_requests'] = $this->reqm->getAllRequests();
            $this->load->view('admin/requests/show_requests', $data);
        } else {
            redirect(index_page());
        }
    }

    public function newRequest()
    {
        $data['backRoute'] = 'admin/requests/showrequests';
        $data['result'] = 0;
        $data['title'] = 'Nuevo mensaje';
        $data['all_sellers'] = $this->selm->getAllSellers();
        $this->load->view('admin/requests/new_request', $data);
    }

    public function createNewRequest()
    {
        $asunto = $this->input->post('asunto');
        $id_seller = $this->input->post('seller');
        $primer_mensaje = $this->input->post('descripcion');

        $id_request = $this->reqm->insertNewRequest($asunto, $id_seller);
        $this->reqmm->insertNewMessage(self::$ADMIN, $primer_mensaje, $id_request);
		
        // Enviar mensaje de la petición al vendedor
        $email_seller = $this->selm->getSellerEmail($id_seller);
        $email_admin = $this->um->getAdminEmail();

        $this->sendEmailNewRequest($asunto, $primer_mensaje, $email_admin, 'Gestor de reservas y viajes', $email_seller);

		$data['all_requests'] = $this->reqm->getAllRequests();
		$data['backRoute'] = 'admin/dashboard';
		$data['result'] = 0;
		$data['title'] = 'Peticiones';
        $this->session->set_flashdata('success', 'El mensaje se ha enviado correctamente.');
        $this->load->view('admin/requests/show_requests', $data);
    }

    public function detailsRequest()
    {
        $id_request = $this->input->post('request');

        $dataRequest = $this->reqm->getRequest($id_request);
        $dataRequest->messages = $this->reqmm->getMessagesFromRequest($id_request);

        $data['backRoute'] = 'admin/requests/showrequests';
        $data['requestInfo'] = $dataRequest;
        $data['title'] = 'Detalles de la petición';
        $this->load->view('admin/requests/details_request', $data);
    }

    public function closeRequest()
    {
        $id_request = $this->input->post('peticionID');

        $this->reqm->closeRequest($id_request);

        $dataRequest = $this->reqm->getRequest($id_request);
        $dataRequest->messages = $this->reqmm->getMessagesFromRequest($id_request);

        $data['backRoute'] = 'admin/requests/showrequests';
        $data['title'] = 'Petición';
        $data['requestInfo'] = $dataRequest;
        $this->load->view('admin/requests/details_request', $data);
    }

    public function sendMessage()
    {
        $requestID = $this->input->post('requestID');
        $mensaje = $this->input->post('requestMessage');
        $id_seller = $this->input->post('sellerID');

        $fullSeller = $this->selm->getSeller($id_seller);
        $this->reqmm->insertNewMessage(self::$ADMIN, $mensaje, $requestID);

        $this->sendEmailNewRequestAdmin($mensaje, $fullSeller->email);

        $dataRequest = $this->reqm->getRequest($requestID);
        $dataRequest->messages = $this->reqmm->getMessagesFromRequest($requestID);

        echo date("d/m/Y, G:i");
    }

    public function sendEmailNewRequestAdmin($mensaje, $email_seller)
    {
        $this->email->from('reservas@modelbook.com', 'Gestor de reservas y viajes');
        $this->email->to($email_seller);
        $this->email->subject('Nuevo mensaje de una petición');

        $complete_message = 'Se ha recibido una petición de Gestor de reservas y viajes ModelBook: '.PHP_EOL.PHP_EOL;
        $complete_message .= 'Mensaje: '.PHP_EOL.$mensaje.PHP_EOL;

        $this->email->message($complete_message);
        $this->email->send();
    }

    public function sendEmailNewRequest($asunto, $mensaje, $email_admin, $name_admin, $email_seller)
    {
        $this->email->from($email_admin, $name_admin);
        $this->email->to($email_seller);
        $this->email->subject('Nuevo mensaje: '.$asunto);

        $complete_message = 'Se ha recibido un nuevo mensaje por parte de  '.$name_admin.': '.PHP_EOL.PHP_EOL;
        $complete_message .= 'Asunto: '.PHP_EOL.$asunto.PHP_EOL.PHP_EOL;
        $complete_message .= 'Mensaje: '.PHP_EOL.$mensaje.PHP_EOL;

        $this->email->message($complete_message);
        $this->email->send();
    }
}
