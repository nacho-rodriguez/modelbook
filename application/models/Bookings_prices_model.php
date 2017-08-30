<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings_Prices_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //añade un precio de reserva
    public function insertBookingPrice($pricesService, $id_booking)
    {
        $data = array(
            'tipo_cliente_fk' => $pricesService->tipo_cliente_fk,
            'valor_monetario' => $pricesService->valor_monetario,
            'comision' => $pricesService->comision,
            'tipo_comision_fk' => $pricesService->tipo_comision_fk,
            'reserva_fk' => $id_booking,
        );
        $this->db->insert('reservas_precios', $data);
    }
}
