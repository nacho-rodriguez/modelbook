<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_Services_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve todos los tipos de servicios activos
    public function getTypeServices()
    {
        return $this->db->from('tipos_servicios')->where('estado', 1)->order_by('orden', 'asc')->get()->result();
    }

    //devuelve todos los tipos de servicios
    public function getAllTypeServices()
    {
        return $this->db->from('tipos_servicios')->order_by('orden', 'asc')->get()->result();
    }

    //devuelve la información del tipo de servicio
    public function getTypeService($id_typeservice)
    {
        return $this->db->from('tipos_servicios')->where('id_tipo_servicio', $id_typeservice)->get()->result()[0];
    }

    //añade un tipo de servicio
    public function insertNewTypeService($name, $status, $order)
    {
        $data = array(
            'nombre' => $name,
            'estado' => $status,
            'orden' => $order,
        );
        $this->db->insert('tipos_servicios', $data);
    }

    //actualiza el tipo de servicio
    public function updateTypeService($id_typeservice, $name, $status, $order)
    {
        $data = array(
            'nombre' => $name,
            'estado' => $status,
            'orden' => $order,
        );

        $this->db->where('id_tipo_servicio', $id_typeservice)
            ->update('tipos_servicios', $data);
    }
}
