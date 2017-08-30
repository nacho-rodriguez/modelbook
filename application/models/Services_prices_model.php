<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_Prices_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
    }
    //añade un precio a un servicio
    public function insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $id_seller)
    {
        $data = array(
            'tipo_cliente_fk' => $id_typeclient,
            'valor_monetario' => $valor,
            'comision' => $comision,
            'tipo_comision_fk' => $tipo_comision,
            'servicio_fk' => $id_service,
            'vendedor_fk' => $id_seller
        );
        $this->db->insert('servicios_precios', $data);
    }

    //devuelve las comisiones del servicio y vendedor
    public function getPreciosComisionesService($id_service, $id_seller)
    {
        return $this->db->select('id_servicio_precio,valor_monetario,comision,tipo_comision_fk,id_tipo_cliente,nombre as tipo_cliente')
            ->from('servicios_precios, tipos_clientes')
            ->where('id_tipo_cliente', 'tipo_cliente_fk', false)
            ->where('vendedor_fk', $id_seller)
            ->where('servicio_fk', $id_service)
            ->order_by('tipo_cliente_fk', 'asc')
            ->get()->result();
    }

    //elimina todos los precios de un modelo
    public function deleteAllPricesFromService($id_service)
    {
        $this->db->where('servicio_fk', $id_service)
            ->delete('servicios_precios');
    }

    //elimina todos los precios del servicio del vendedor
    public function deleteAllPricesFromServiceFromSeller($id_service, $id_seller)
    {
        $this->db->where('servicio_fk', $id_service)
            ->where('vendedor_fk', $id_seller)
            ->delete('servicios_precios');
    }

    //devuelve las comisiones del vendedor
    public function getComisionesFromSellerAndService($id_seller, $id_service)
    {
        return $this->db->select('id_servicio_precio,tipo_cliente_fk,valor_monetario,comision,tipo_comision_fk,id_tipo_cliente,nombre')
            ->from('servicios_precios,tipos_clientes')
            ->where('id_tipo_cliente', 'tipo_cliente_fk', false)
            ->where('servicio_fk', $id_service)
            ->where('vendedor_fk', $id_seller)
            ->where('valor_monetario !=', 0)
            ->get()->result();
    }

    //devuelve datos relativos a servicios y comisiones
    public function getSellerWithAllPricesAndServices($id_seller)
    {
        $fullSeller = $this->selm->getSeller($id_seller);
        $available_services = $this->serm->getAvailableServices();

        foreach ((array)$available_services as $service) {
            $service->prices = $this->getComisionesFromSellerAndService($id_seller, $service->id_servicio);
        }

        $fullSeller->services = $available_services;

        return $fullSeller;
    }
}
