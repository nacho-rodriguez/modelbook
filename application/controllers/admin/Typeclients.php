<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typeclients extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('users_model', 'um');
    }

    public function showTypeClients()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/config/showconfig';
            $data['tipoClientes'] = $this->typeclim->getAllTypeClients();
            $data['title'] = 'Tipos de clientes';
            $this->load->view('admin/typeclients/show_typeclients', $data);
        } else {
            redirect(index_page());
        }
    }

    public function newTypeClient()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/typeclients/showtypeclients';
            $data['title'] = 'Nuevo tipo de cliente';
            $this->load->view('admin/typeclients/new_typeclient', $data);
        } else {
            redirect(index_page());
        }
    }

    public function createNewTypeClient()
    {
        $name = $this->input->post('nombre');
		$status = $this->input->post('estado');
        $edad_min = $this->input->post('edadMinima');
        $edad_max = $this->input->post('edadMaxima');

        $this->typeclim->insertNewTypeClient($name, $status, $edad_min, $edad_max);
        $this->session->set_flashdata('success', 'Se ha creado el tipo de cliente correctamente.');

        $this->showTypeClients();
    }

    public function detailsTypeClient()
    {
        $id_typeclient = $this->input->post('price');

        $data['backRoute'] = 'admin/typeclients/showtypeclients';
        $data['tipoCliente'] = $this->typeclim->getTypeClient($id_typeclient);
        $data['title'] = 'Detalles del tipo de cliente';
        $this->load->view('admin/typeclients/details_typeclient', $data);
    }

    public function updateTypeClient()
    {
        $id_typeclient = $this->input->post('idPrice');
        $name = $this->input->post('nombre');
        $edad_min = $this->input->post('edadMinima');
        $edad_max = $this->input->post('edadMaxima');
        $status = $this->input->post('estado');

        $this->typeclim->updateTypeClientM($id_typeclient, $name, $edad_min, $edad_max, $status);
        $this->session->set_flashdata('success', 'Se ha actualizado el tipo de cliente correctamente.');

        $this->showTypeClients();
    }
}
