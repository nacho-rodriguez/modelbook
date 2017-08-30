<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model', 'um');
        $this->load->model('sellers_model', 'selm');
    }

    public function login()
    {
        $email = $this->input->post('InputLogin');
        $password = $this->input->post('InputPassword');

		$this->session->set_userdata('site_lang', 'spanish');

        if ($this->input->post('submit')) {
            if ($this->um->loginAdmin($email, $password)) {
                $this->session->set_flashdata('success', 'Bienvenido, '.$this->session->userdata('user').'.');
                redirect(base_url('admin/dashboard'));
            } elseif ($this->selm->sellerExists($email)) {
                if (!$this->selm->accessGranted($email)) {
                    $this->session->set_flashdata('error', 'Este usuario existe, pero no tiene permitida la entrada al sistema. Por favor, contacte con el administrador.');
                    $this->load->view('login');
                } elseif ($this->um->loginSeller($email, $password)) {
                    $this->session->set_flashdata('success', 'Bienvenido, '.$this->session->userdata('user').'.');
                    redirect(base_url('user/dashboard'));
                } else {
                    $this->session->set_flashdata('error', 'La contraseña para este usuario no es correcta.');
                    $this->load->view('login');
                }
            } else {
                $this->session->set_flashdata('error', 'El usuario introducido no existe.');
                $this->load->view('login');
            }
        } else {
            redirect(index_page());
        }
    }

    public function closeSession()
    {
        $this->um->logout();
        redirect(index_page());
    }

    public function newSeller()
    {
        $this->load->view('signup');
    }

    public function signup()
    {
        $cif = $this->input->post('CIF');
        $name = $this->input->post('Nombre');
        $direccion = $this->input->post('Direccion');
        $poblacion = $this->input->post('Poblacion');
        $provincia = $this->input->post('Provincia');
        $phone = $this->input->post('Telefono');
        $email = $this->input->post('Email');
        $password = $this->input->post('Password');

        if ($this->input->post('submit')) {
            if ($this->selm->newPreSeller($cif, $name, $direccion, $poblacion, $provincia, $phone, $email, $password)) {
                $this->session->set_flashdata('warning', 'Atención: Este mail ya está registrado en la base de datos.');
                $this->load->view('signup');
            } else {
                $this->session->set_flashdata('success', 'Se ha enviado exitosamente la información del vendedor. Nos pondremos en contacto con usted para verificar los datos y darle acceso al sistema.');
                $this->load->view('login');
            }
        } else {
            $this->load->view('signup');
        }
    }

    public function forgotPassword()
    {
        $email = $this->input->post('Email');

        if ($this->selm->sellerExists($email)) {
            $this->sendEmailPassword($email);
            $this->session->set_flashdata('success', 'Se ha enviado un email a la dirección de correo indicada con su contraseña para acceder al sistema.');
        } else {
            $this->session->set_flashdata('error', 'Ha solicitado restablecer la contraseña de un email que no existe en el sistema. Por favor, contacte con el administrador si no recuerda sus datos de acceso.');
        }
		redirect(index_page());
    }

	//envío de mail para recordar la contraseña
    public function sendEmailPassword($email)
    {
        $this->email->from('info@modelbook.com', 'Modelbook');
        $this->email->to($email);
        $this->email->subject('Envío de Contraseña');

        $message = 'Para acceder al sistema introduzca los siguientes datos:\n' .
                    'Usuario: '.$email.'\n' .
                    'Contraseña: '.$this->selm->getPassword($email).'\n\n' .
                    'Para cualquier consulta, no dude en ponerse en contacto con nosotros.\nModelBook '.date("Y");
        $this->email->message($message);
        $this->email->send();
    }
}
