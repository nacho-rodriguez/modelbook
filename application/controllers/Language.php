<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    function switchLang() {
		switch ($this->session->userdata('site_lang')) {
			case 'spanish':
				$language = 'english';
				break;
			case 'english':
			default:
				$language = 'spanish';
		}
        $this->session->set_userdata('site_lang', $language);
		$this->session->set_flashdata('success', $this->lang->line("msg_lang"));

		redirect($_SERVER['HTTP_REFERER']);
    }
}
