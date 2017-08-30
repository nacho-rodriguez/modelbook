<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends CI_Controller
{
    protected static $SELLER = 2;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model', 'reqm');
        $this->load->model('requests_messages_model', 'reqmm');
        $this->load->model('users_model', 'um');
    }

    public function newRequest()
    {
        if ($this->um->imSeller()) {
			$data = array();
			$serviceReference = $this->input->post('asunto');

			$result = 0;
			if ($serviceReference != '') {
				$result = 2;
				$data['asunto'] = 'Petición del servicio: '.$serviceReference;
			}

            $data['backRoute'] = 'user/requests/showrequests';
            $data['id_user'] = $this->session->userdata('id_user');
            $data['result'] = $result;
            $data['title'] = 'Nuevo mensaje';
            $data['user_email'] = $this->session->userdata('user_email');
            $data['user'] = $this->session->userdata('user');
            $this->load->view('user/requests/new_request', $data);
        } else {
            redirect(index_page());
        }
    }

    public function createNewRequest()
    {
		$id_user = $this->session->userdata('id_user');
		$user_email = $this->session->userdata('user_email');
        $asunto = $this->input->post('asunto');
        $primer_mensaje = $this->input->post('descripcion');

        $id_request = $this->reqm->insertNewRequest($asunto, $id_user);
        $this->reqmm->insertNewMessage(self::$SELLER, $primer_mensaje, $id_request);

        // Enviar mensaje de la petición al administrador
        $this->sendEmailNewRequest($asunto, $primer_mensaje, $user_email, $id_user);

        $data['backRoute'] = 'user/requests/showrequests';
        $data['id_user'] = $id_user;
        $data['title'] = 'Nuevo mensaje';
        $data['user_email'] = $user_email;
        $data['user'] = $this->session->userdata('user');
		$data['requests'] = $this->reqm->getRequestsFromSeller($id_user);
        $this->session->set_flashdata('success', "El mensaje se ha enviado correctamente.");
        $this->load->view('user/requests/show_requests', $data);
    }



    public function showRequests()
    {
        $data['backRoute'] = 'user/dashboard';
        $data['id_user'] = $this->session->userdata('id_user');
        $data['requests'] = $this->reqm->getRequestsFromSeller($data['id_user']);
        $data['title'] = 'Peticiones';
        $data['user_email'] = $this->session->userdata('user_email');
        $data['user'] = $this->session->userdata('user');
        $this->load->view('user/requests/show_requests', $data);
    }

    public function detailsRequest()
    {
        $requestID = $this->input->post('requestID');
		$dataRequest = $this->reqm->getRequest($requestID);
		$dataRequest->messages = $this->reqmm->getMessagesFromRequest($requestID);

        $data['backRoute'] = 'user/requests/showrequests';
        $data['id_user'] = $this->session->userdata('id_user');
        $data['requestInfo'] = $dataRequest;
        $data['title'] = 'Detalles de la petición';
        $data['user_email'] = $this->session->userdata('user_email');
        $data['user'] = $this->session->userdata('user');
        $this->load->view('user/requests/details_request', $data);
    }

    public function sendMessage()
    {
        $requestID = $this->input->post('requestID');
        $mensaje = $this->input->post('requestMessage');

        $this->reqmm->insertNewMessage(self::$SELLER, $mensaje, $requestID);

        $data['user'] = $this->session->userdata('user');
        $data['user_email'] = $this->session->userdata('user_email');
        $data['id_user'] = $this->session->userdata('id_user');

        $this->sendEmailNewRequestUser($mensaje, $data['user_email'], $data['user']);

        $dataRequest = $this->reqm->getRequest($requestID);
        $dataRequest->messages = $this->reqmm->getMessagesFromRequest($requestID);

        echo date("d/m/Y, H:i");
    }

    public function sendEmailNewRequest($asunto, $mensaje, $email_seller, $name_seller)
    {
        $this->email->from($email_seller, $name_seller);
        $this->email->to($this->um->getAdminEmail());
        $this->email->subject('Nueva petición: '.$asunto);

        $complete_message = 'Se ha recibido una nueva petición por parte del vendedor '.$name_seller.': '.PHP_EOL.PHP_EOL;
        $complete_message .= 'Asunto: '.PHP_EOL.$asunto.PHP_EOL.PHP_EOL;
        $complete_message .= 'Mensaje: '.PHP_EOL.$mensaje.PHP_EOL;

        $this->email->message($complete_message);
        $this->email->send();
    }

    public function sendEmailNewRequestUser($mensaje, $email_seller, $name_seller)
    {
        $this->email->from($email_seller, $name_seller);
        $this->email->to($this->um->getAdminEmail());
        $this->email->subject('Nuevo mensaje de una petición');

        $complete_message = 'Se ha recibido un nuevo mensaje de una petición por parte del vendedor '.$name_seller.': '.PHP_EOL.PHP_EOL;
        $complete_message .= 'Mensaje: '.PHP_EOL.$mensaje.PHP_EOL;

        $this->email->message($complete_message);
        $this->email->send();
    }
}
