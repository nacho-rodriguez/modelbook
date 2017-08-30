<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_Paradas_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve las paradas del servicio
    public function getAllParadasFromService($id_service)
    {
        return $this->db->select('id_servicio_parada,hora,parada,id_vendedor,nombre as nombre_vendedor')
            ->from('servicios_paradas,vendedores')
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('servicio_fk', $id_service)
            ->order_by('nombre_vendedor', 'asc')
            ->get()->result();
    }

    //devuelve las paradas del servicio del vendedor
    public function getAllParadasFromServiceFromSeller($id_service, $id_seller)
    {
        return $this->db->select('id_servicio_parada,parada,DATE_FORMAT(hora,"%H:%i") as hora_parada')
            ->from('servicios_paradas')
            ->where('vendedor_fk', $id_seller)
            ->where('servicio_fk', $id_service)
            ->order_by('hora_parada', 'asc')
            ->get()->result();
    }

    //devuelve la informacion de la parada
    public function getParadaInformation($id_parada)
    {
        return $this->db->select('DATE_FORMAT(hora,"%H:%i") as hora_parada,parada')
            ->from('servicios_paradas')
            ->where('id_servicio_parada', $id_parada)
            ->get()->result()[0];
    }

    //añade la parada en el servicio
    public function insertParadaService($hora, $parada, $id_seller, $id_service)
    {
        $data = array(
            'hora' => $hora,
            'parada' => $parada,
            'servicio_fk' => $id_service,
            'vendedor_fk' => $id_seller,
        );
        $this->db->insert('servicios_paradas', $data);
    }

    //elimina todas las paradas del servicio
    public function deleteAllParadasFromService($id_service)
    {
        $this->db->where('servicio_fk', $id_service)
            ->delete('servicios_paradas');
    }
}
