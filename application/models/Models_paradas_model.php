<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models_Paradas_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve las paradas del modelo
    public function getAllParadasFromModel($id_model)
    {
        return $this->db->select('id_modelo_parada,hora,parada,id_vendedor,nombre as nombre_vendedor')
            ->from('modelos_paradas,vendedores')
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('modelo_fk', $id_model)
            ->order_by('nombre_vendedor', 'asc')
            ->get()->result();
    }

    //inserta la parada en el modelo
    public function insertParadaModel($hora, $parada, $id_seller, $id_model)
    {
        $data = array(
            'hora' => $hora,
            'parada' => $parada,
            'modelo_fk' => $id_model,
            'vendedor_fk' => $id_seller,
        );
        $this->db->insert('modelos_paradas', $data);
    }

    //elimina todas las paradas del modelo
    public function deleteAllParadasFromModel($id_model)
    {
        $this->db->where('modelo_fk', $id_model)
            ->delete('modelos_paradas');
    }
}
