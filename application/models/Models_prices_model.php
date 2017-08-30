<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models_prices_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //añade un precio a un modelo
    public function insertNewIndividualPriceModel($id_typeclient, $valor, $comision, $tipo_comision, $id_model, $id_seller)
    {
        $data = array(
            'tipo_cliente_fk' => $id_typeclient,
            'valor_monetario' => $valor,
            'comision' => $comision,
            'tipo_comision_fk' => $tipo_comision,
            'modelo_fk' => $id_model,
            'vendedor_fk' => $id_seller,
        );
        $this->db->insert('modelos_precios', $data);
    }

    //devuelve las comisiones del modelo y vendedor
    public function getPreciosComisionesModelo($id_model, $id_seller)
    {
        return $this->db->select('id_modelo_precio,valor_monetario,comision,tipo_comision_fk,id_tipo_cliente,nombre as tipo_cliente')
            ->from('modelos_precios, tipos_clientes')
            ->where('id_tipo_cliente', 'tipo_cliente_fk', false)
            ->where('vendedor_fk', $id_seller)
            ->where('modelo_fk', $id_model)
            ->order_by('tipo_cliente_fk', 'asc')
            ->get()->result();
    }

    //elimina todos los precios de un modelo
    public function deleteAllPricesFromModel($id_model)
    {
        $this->db->where('modelo_fk', $id_model)
            ->delete('modelos_precios');
    }
}
