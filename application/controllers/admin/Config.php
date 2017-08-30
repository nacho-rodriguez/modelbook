<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model', 'um');
    }

    public function showConfig()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/dashboard';
            $data['configData'] = $this->um->getConfig();
            $data['title'] = $this->lang->line("msg_config_datosgenerales");
			$data['string'] = $this->lang->language;
            $this->load->view('admin/config/show_config', $data);
        } else {
            redirect(index_page());
        }
    }

    public function updateConfig()
    {
        $empresa = $this->input->post('Empresa');
        $codigo_identificacion = $this->input->post('CI');
        $cif = $this->input->post('CIF');
        $direccion = $this->input->post('Direccion');
        $poblacion = $this->input->post('Poblacion');
        $provincia = $this->input->post('Provincia');
        $phone = $this->input->post('Telefono');
        $email = $this->input->post('Email');

        $this->um->updateConfig($empresa, $codigo_identificacion, $cif, $direccion, $poblacion, $provincia, $phone, $email);

        $data['backRoute'] = 'admin/dashboard';
        $data['configData'] = $this->um->getConfig();
        $data['title'] = $this->lang->line("msg_config_datosgenerales");
		$data['string'] = $this->lang->language;
        $this->session->set_flashdata('success', $this->lang->line("msg_config_infoactualizada"));
        $this->load->view('admin/config/show_config', $data);
    }

    public function updateLogo()
    {
        if (!$this->upload->do_upload('userfile')) {
            $this->session->set_flashdata('error', $this->lang->line("msg_config_errorbanner"));
        } else{
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
            $this->um->updateLogoCompany($foto);
            $this->session->set_flashdata('success', $this->lang->line("msg_config_banneractualizado").' '.$foto);
        }

        $data['backRoute'] = 'admin/dashboard';
        $data['configData'] = $this->um->getConfig();
        $data['title'] = $this->lang->line("msg_config_datosgenerales");
		$data['string'] = $this->lang->language;
        $this->load->view('admin/config/show_config', $data);
    }
}
