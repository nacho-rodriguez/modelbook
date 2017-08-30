<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests_Messages_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve los mensajes de la petición
    public function getMessagesFromRequest($id_request)
    {
        return $this->db->select('id_peticion_mensaje,fecha_hora,tipo,mensaje')
            ->from('peticiones_mensajes')
            ->where('peticion_fk', $id_request)
            ->order_by('fecha_hora', 'asc')
            ->get()->result();
    }

    //añade un mensaje a la petición
    public function insertNewMessage($who, $message, $id_request)
    {
        $data = array(
            'tipo' => $who,
            'mensaje' => $message,
            'peticion_fk' => $id_request,
        );
        $this->db->insert('peticiones_mensajes', $data);
    }
}
