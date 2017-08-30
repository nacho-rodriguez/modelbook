<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model', 'um');
    }

    public function index()
    {
        if ($this->um->imAdmin()) {
			$data['iAmInTheMainPanel'] = true;
			$data['string'] = $this->lang->language;
			$data['title'] = $this->lang->line("msg_dashboard_admin");
            $this->load->view('admin/dashboard', $data);
        } else {
            //redirect('', 'refresh');
            redirect(index_page());
        }
    }
}
