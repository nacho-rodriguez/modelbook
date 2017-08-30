<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typeservices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('type_services_model', 'typeserm');
        $this->load->model('users_model', 'um');
    }

    public function showTypeServices()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/config/showconfig';
            $data['title'] = 'Tipos de servicios';
            $data['typeData'] = $this->typeserm->getAllTypeServices();
            $this->load->view('admin/typeservices/show_typeservices', $data);
        } else {
            redirect(index_page());
        }
    }

    public function newTypeService()
    {
        if ($this->um->imAdmin()) {
            $data['title'] = 'Nuevo tipo de servicio';
            $data['backRoute'] = 'admin/typeservices/showtypeservices';
            $this->load->view('admin/typeservices/new_typeservice', $data);
        } else {
            redirect(index_page());
        }
    }

    public function createNewTypeService()
    {
        $name = $this->input->post('nombre');
        $status = $this->input->post('estado');
        $order = $this->input->post('orden');

        $this->typeserm->insertNewTypeService($name, $status, $order);
        $this->session->set_flashdata('success', 'El nuevo tipo de servicio se ha creado correctamente.');

        $this->showTypeServices();
    }

    public function detailsTypeService()
    {
        $id_typeservice = $this->input->post('idTypeService');
        $data['backRoute'] = 'admin/typeservices/showtypeservices';
        $data['typeService'] = $this->typeserm->getTypeService($id_typeservice);
        $data['title'] = 'Detalles del tipo de servicio';
        $this->load->view('admin/typeservices/details_typeservice', $data);
    }

    public function updateTypeService()
    {
        $id_typeservice = $this->input->post('idTypeService');
        $name = $this->input->post('nombre');
        $status = $this->input->post('estado');
        $order = $this->input->post('orden');

        $this->typeserm->updateTypeService($id_typeservice, $name, $status, $order);
        $this->session->set_flashdata('success', 'Se ha actualizado el nuevo tipo de servicio correctamente.');

        $this->showTypeServices();
    }
}
