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
        if ($this->um->imSeller()) {
			$data['iAmInTheMainPanel'] = true;
			$data['id_user'] = $this->session->userdata('id_user');
			$data['string'] = $this->lang->language;
			$data['title'] = $this->lang->line("msg_dashboard_user");
			$data['user_email'] = $this->session->userdata('user_email');
			$data['user'] = $this->session->userdata('user');
            $this->load->view('user/dashboard', $data);
        } else {
            redirect(index_page());
        }
    }
}
