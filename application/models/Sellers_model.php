<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('models_prices_model', 'mprem');
        $this->load->model('services_prices_model', 'sprim');
    }

    //devuelve true si el vendedor con dicho mail existe
    public function sellerExists($email)
    {
        $query = $this->db->from('vendedores')
            ->where('email', $email)->get();
        return ($query->num_rows() > 0)? 1 : 0;
    }

    //devuelve true si el vendedor con dicho mail tiene acceso al panel
    public function accessGranted($email)
    {
        $query = $this->db->from('vendedores')
            ->where('email', $email)
            ->where('estado', 1)->get();

        return ($query->num_rows() > 0)? true : false;
    }

    //devuelve el password asociado a dicho mail
    public function getPassword($email)
    {
        return $this->encryption->decrypt($this->db->from('vendedores')->where('email', $email)->get()->result()[0]->password);
    }

    //creación de un nuevo vendedor
    public function newSeller($cif, $name, $direccion, $poblacion, $provincia, $email, $phone, $status, $password, $show_info)
    {
        $data = array(
            'cif' => $cif,
            'nombre' => $name,
            'direccion' => $direccion,
            'poblacion' => $poblacion,
            'provincia' => $provincia,
            'telefono' => $phone,
            'email' => $email,
            'password' => $this->encryption->encrypt($password),
            'estado' => $status,
            'mostrar_info_reserva' => $show_info
        );
        $this->db->insert('vendedores', $data);

        return $this->db->insert_id();
    }

    //actualiza al vendedor
    public function updateSellerM($id_seller, $cif, $name, $direccion, $poblacion, $provincia, $email, $phone, $status, $show_info)
    {
        $data = array(
            'cif' => $cif,
            'nombre' => $name,
            'direccion' => $direccion,
            'poblacion' => $poblacion,
            'provincia' => $provincia,
            'email' => $email,
            'telefono' => $phone,
            'estado' => $status,
            'mostrar_info_reserva' => $show_info
        );

        $this->db->where('id_vendedor', $id_seller)
            ->update('vendedores', $data);
    }

    //creación de un nuevo prevendedor desde el login
    public function newPreSeller($cif, $name, $direccion, $poblacion, $provincia, $phone, $email, $password)
    {
        $query = $this->db->from('vendedores')->where('cif', $cif)->get();

        if ($query->num_rows() > 0) {
            return true;        //existe
        } else {
            $data = array(
                'cif' => $cif,
                'nombre' => $name,
                'direccion' => $direccion,
                'poblacion' => $poblacion,
                'provincia' => $provincia,
                'telefono' => $phone,
                'email' => $email,
                'password' => $this->encryption->encrypt($password),
            );
            $this->db->insert('vendedores', $data);

            $this->sendEmailNewPreSeller($cif, $name, $direccion, $poblacion, $provincia, $phone, $email);
        }
        return false;        //no existe
    }

    //envío de mail una vez creado el usuario
    public function sendEmailNewPreSeller($cif, $name, $direccion, $poblacion, $provincia, $phone, $email)
    {
        $this->email->from($email, $name);
        $this->email->to('altas@modelbook.com');
        $this->email->subject('Registro de nuevo vendedor: '. $name);

        $message = 'Se ha registrado un nuevo vendedor con los siguientes datos:\n'.
                    'CIF: '.$cif.'\n'.
                    'NOMBRE: '.$name.'\n'.
                    'DIRECCIÓN: '.$direccion.'\n'.
                    'POBLACION: '.$poblacion.'\n'.
                    'PROVINCIA: '.$provincia.'\n'.
                    'TELEFONO: '.$phone.'\n'.
                    'EMAIL: '.$email.'\n'.
                    'Actualmente este vendedor no tiene acceso al sistema. Deberá ir al panel de administración y darle acceso manualmente.\n\n'.
                    'Para cualquier consulta, no dude en ponerse en contacto con nosotros.\nModelBook '. date("Y");
        $this->email->message($message);
        $this->email->send();
    }

    //devuelve todos los vendedores
    public function getAllSellers()
    {
        return $this->db->from('vendedores')->order_by('id_vendedor', 'asc')->get()->result();
    }

    //devuelve al vendedor
    public function getSeller($id_seller)
    {
        return $this->db->from('vendedores')->where('id_vendedor', $id_seller)->get()->result()[0];
    }

    //devuelve el mail del vendedor
    public function getSellerEmail($id_seller)
    {
        return $this->db->from('vendedores')->where('id_vendedor', $id_seller)->get()->result()[0]->email;
    }

    //devuelve las paradas guardadas del modelo
    public function getSellerSavedParadasFromModel($id_model)
    {
        return $this->db->select('id_vendedor, nombre, hora')
            ->from('vendedores')
            ->join('modelos_paradas', 'modelo_fk = '.$id_model.' AND id_vendedor = vendedor_fk', 'left')
            ->where('vendedor_fk', null)
            ->get()->result();
    }

    //devuelve las paradas guardadas del servicio
    public function getSellerSavedParadasFromService($id_service)
    {
        return $this->db->select('id_vendedor, nombre, hora')
            ->from('vendedores')
            ->join('servicios_paradas', 'servicio_fk = '.$id_service.' AND id_vendedor = vendedor_fk', 'left')
            ->where('vendedor_fk', null)
            ->get()->result();
    }

    //activa al vendedor
    public function activateSeller($id_seller)
    {
        $data = array('estado' => 1);
        $this->db->where('id_vendedor', $id_seller)
            ->update('vendedores', $data);
    }

    //deshabilita al vendedor
    public function deleteSeller($id_seller)
    {
        $data = array('estado' => 0);

        $this->db->where('id_vendedor', $id_seller)
            ->update('vendedores', $data);
    }

    //devuelve las comisiones de los vendedores del modelo
    public function getPreciosComisionesSellersFromModel($id_model)
    {
        $query = $this->db->select('id_vendedor,nombre')
            ->from('vendedores')
            ->order_by('id_vendedor', 'asc')
            ->get()->result();

        foreach ((array)$query as $vendedor) {
            $vendedor->preciosComisiones = $this->mprem->getPreciosComisionesModelo($id_model, $vendedor->id_vendedor);
        }

        return $query;
    }

    //devuelve las comisiones de los vendedores del servicio
    public function getPreciosComisionesSellersFromService($id_service)
    {
        $query = $this->db->select('id_vendedor,nombre')
            ->from('vendedores')
            ->order_by('id_vendedor', 'asc')
            ->get()->result();

        foreach ((array)$query as $vendedor) {
            $vendedor->preciosComisiones = $this->sprim->getPreciosComisionesService($id_service, $vendedor->id_vendedor);
        }

        return $query;
    }
}
