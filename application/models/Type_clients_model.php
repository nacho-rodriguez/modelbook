<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_Clients_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve todos los tipos de clientes activos
    public function getTypeClients()
    {
        return $this->db->from('tipos_clientes')->where('estado', 1)->order_by('edad_minima', 'asc')->get()->result();
    }

    //devuelve el tipo de cliente
    public function getTypeClient($id_typeclient)
    {
        return $this->db->from('tipos_clientes')->where('id_tipo_cliente', $id_typeclient)->get()->result()[0];
    }

    //devuelve todos los tipos de clientes
    public function getAllTypeClients()
    {
        return $this->db->from('tipos_clientes')->order_by('edad_minima', 'asc')->get()->result();
    }

    //devuelve la información de los precios de un vendedor
    public function getTypeClientForServiceAndSeller($id_service, $id_seller)
    {
        return $this->db->select('id_tipo_cliente,nombre,edad_minima,edad_maxima,valor_monetario,comision,tipo_comision_fk')
            ->from('tipos_clientes,servicios_precios')
            ->where('tipo_cliente_fk', 'id_tipo_cliente', false)
            ->where('servicio_fk', $id_service)
            ->where('vendedor_fk', $id_seller)
            ->where('estado', 1)
            ->where('valor_monetario !=', 0)
			->order_by('edad_minima', 'asc')
            ->get()->result();
    }

    //devuelve el número de tipos de clientes activos
    public function noOfTypeClients()
    {
        return $this->db->from('tipos_clientes')->where('estado', 1)->get()->num_rows();
    }

    //añade un tipo de cliente
    public function insertNewTypeClient($name, $status, $edad_min, $edad_max)
    {
        $data = array(
            'nombre' => $name,
			'estado' => $status,
            'edad_minima' => $edad_min,
            'edad_maxima' => $edad_max,
        );
        $this->db->insert('tipos_clientes', $data);
    }

    //actualiza el tipo de cliente
    public function updateTypeClientM($id_typeclient, $name, $edad_min, $edad_max, $status)
    {
        $data = array(
            'nombre' => $name,
            'edad_minima' => $edad_min,
            'edad_maxima' => $edad_max,
            'estado' => $status,
        );

        $this->db->where('id_tipo_cliente', $id_typeclient)
            ->update('tipos_clientes', $data);
    }
}
