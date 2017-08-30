<?php
defined('BASEPATH') or exit('No direct script access allowed');

final class Users_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //logueo de admin
    public function loginAdmin($email, $password)
    {
        $query = $this->db->from('gestor')->where('email', $email)->get();

        if ($query->num_rows() === 1) {
            $user_row = $query->row();
            if ($this->encryption->decrypt($user_row->password) === $password) {
                //los datos son correctos
                $this->session->set_userdata(
                    array(
                    'user' => 'Administrador',
                    'type_user' => 'admin',
                    'id_user' => 0,
                    'user_email' => $user_row->email,
                    )
                );
                return true;
            }
        }

        return false;
    }

    //devuelve si la sesión iniciada es de administrador
    public function imAdmin()
    {
        $data_session = $this->session->all_userdata();
        return ($data_session['type_user'] === 'admin') ? true : false;
    }

    //devuelve el array de datos de la empresa
    public function getConfig()
    {
        return $this->db->from('gestor')->get()->result()[0];
    }

    //actualiza el logo
    public function updateLogoCompany($logo)
    {
        $data = array('logo' => $logo);

        $this->db->where('id_gestor', 1)
            ->update('gestor', $data);
    }

    //devuelve el mail de la empresa
    public function getAdminEmail()
    {
        return $this->db->from('gestor')->get()->result()[0]->email_empresa;
    }

    //actualiza la configuración
    public function updateConfig($empresa, $codigo_identificacion, $cif, $direccion, $poblacion, $provincia, $phone, $email)
    {
        $data = array(
            'empresa' => $empresa,
            'codigo_identificacion' => $codigo_identificacion,
            'cif' => $cif,
            'direccion' => $direccion,
            'poblacion' => $poblacion,
            'provincia' => $provincia,
            'telefono' => $phone,
            'email_empresa' => $email
        );

        $this->db->where('id_gestor', 1)->update('gestor', $data);
    }

    //incrementa el contador de billetes vendidos y devuelve el anterior
    public function increaseBookingNumber()
    {
        $this->db->set('contador', 'contador+1', false)
            ->where('id_gestor', 1)
            ->update('gestor');

        return $this->db->from('gestor')->where('id_gestor', 1)->get()->result()[0]->contador - 1;
    }

    //logueo de vendedor
    public function loginSeller($email, $password)
    {
        $query = $this->db->from('vendedores')->where('email', $email)->get();

        if ($query->num_rows() === 1) {
            $user_row = $query->row();
            if ($this->encryption->decrypt($user_row->password) === $password) {
                //los datos son correctos
                $this->session->set_userdata(
                    array(
                        'user' => $user_row->nombre,
                        'type_user' => 'seller',
                        'id_user' => $user_row->id_vendedor,
                        'user_email' => $user_row->email
                    )
                );
                return true;
            }
        }
        return false;
    }

    //devuelve si la sesión iniciada es de vendedor
    public function imSeller()
    {
        $data_session = $this->session->all_userdata();
        return ($data_session['type_user'] === 'seller') ? true : false;
    }

    //cierra la sesión del usuario
    public function logout()
    {
        $this->session->sess_destroy();
    }
}
