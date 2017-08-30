<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('clients_model', 'clim');
        $this->load->model('users_model', 'um');
    }

    public function showClients()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/dashboard';
            $data['all_clients'] = $this->clim->getAllClients();
            $data['title'] = 'Lista de clientes';
            $this->load->view('admin/clients/show_clients', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsClient()
    {
        $id_client = $this->input->post('idCliente');

        if ($this->um->imAdmin()) {
			$data['client'] = $this->clim->getClientById($id_client);
			$data['idCliente'] = $id_client;
            $data['backRoute'] = 'admin/clients/showclients';
            $data['clientBooking'] = $this->boom->getBookingsFromClient($id_client);
            $data['title'] = 'Detalles del cliente';
            $this->load->view('admin/clients/details_client', $data);
        } else {
            redirect(index_page());
        }
    }

    public function updateClient()
    {
        $id_client = $this->input->post('idCliente');
        $dni = $this->input->post('DNI');
        $phone = $this->input->post('telefono');
        $name = $this->input->post('Nombre');
        $surname = $this->input->post('Apellidos');
        $fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $email = $this->input->post('Email');

        $this->clim->updateClientWithMoreInfo($id_client, $dni, $name, $surname, $fecha_nacimiento, $phone, $email);

		$data['idCliente'] = $id_client;
        $data['backRoute'] = 'admin/clients/showclients';
        $data['client'] = $this->clim->getClientById($id_client);
        $data['clientBooking'] = $this->boom->getBookingsFromClient($id_client);
        $data['title'] = 'Detalles del cliente';
        $this->session->set_flashdata('success', 'La información del cliente se ha actualizado correctamente.');
        $this->load->view('admin/clients/details_client', $data);
    }
}
