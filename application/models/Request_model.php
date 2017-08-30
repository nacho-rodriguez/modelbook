<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve todas las peticiones
    public function getAllRequests()
    {
        return $this->db->select('id_peticion,asunto,peticiones.estado,vendedor_fk,nombre,DATE_FORMAT(fecha_peticion,"%d/%m/%Y, %H:%i") as fecha_apertura,fecha_peticion')
            ->from('peticiones,vendedores')
            ->where('vendedor_fk', 'id_vendedor', false)
            ->order_by('estado', 'asc')
            ->order_by('fecha_apertura', 'desc')
            ->get()->result();
    }

    //devuelve la petición
    public function getRequest($id_request)
    {
        return $this->db->select('id_peticion,asunto,peticiones.estado,vendedor_fk,nombre,DATE_FORMAT(fecha_peticion,"%d/%m/%Y, %H:%i") as fecha_apertura')
            ->from('peticiones,vendedores')
            ->where('vendedor_fk', 'id_vendedor', false)
            ->where('id_peticion', $id_request)
            ->get()->result()[0];
    }

    //cierra la petición
    public function closeRequest($id_request)
    {
        $data = array('estado' => 1);

        $this->db->where('id_peticion', $id_request)
            ->update('peticiones', $data);
    }

    //devuelve las peticiones del vendedor
    public function getRequestsFromSeller($id_seller)
    {
        return $this->db->select('id_peticion,asunto,peticiones.estado,vendedor_fk,nombre,DATE_FORMAT(fecha_peticion,"%d/%m/%Y, %H:%i") as fecha_apertura')
            ->from('peticiones,vendedores')
            ->where('vendedor_fk', 'id_vendedor', false)
            ->where('vendedor_fk', $id_seller)
            ->order_by('estado', 'asc')
            ->order_by('fecha_apertura', 'desc')
            ->get()->result();
    }

    //añade un mensaje a la petición y devuelve el id
    public function insertNewRequest($asunto, $id_seller)
    {
        $data = array(
            'asunto' => $asunto,
            'vendedor_fk' => $id_seller,
        );
        $this->db->insert('peticiones', $data);

        return $this->db->insert_id();
    }
}
