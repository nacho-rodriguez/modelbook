<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve todos los clientes
    public function getAllClients()
    {
        return $this->db->select('id_cliente,dni,nombre,apellidos,telefono')
            ->from('clientes')
            ->where('dni !=', '')
            ->where('dni !=', 'Sin DNI')
            ->order_by('apellidos', 'asc')
            ->get()->result();
    }

    //devuelve el identificidador del cliente con ese dni
    public function getIDClientByDni($dni)
    {
        $query = $this->db->from('clientes')->where('dni', $dni)->get();

        if ($query->num_rows() > 0) {                        //existe
            return $query->result()[0]->id_cliente;
        }
        return 0;
    }

    //devuelve la información del cliente con ese dni
    public function getClientByDni($dni)
    {
        $query = $this->db->from('clientes')->where('dni', $dni)->get();

        if ($query->num_rows() > 0) {                        //existe
            return $query->result()[0];
        }
        return 0;
    }

    //devuelve la información del cliente con ese id
    public function getClientById($id_client)
    {
        return $this->db->select('id_cliente,dni,clientes.nombre,apellidos,telefono,fecha_nacimiento,email')
            ->from('clientes')
            ->where('id_cliente', $id_client)
            ->get()->result()[0];
    }

    //añade un nuevo cliente
    public function insertNewClient($dni, $name, $surname, $fecha_nac, $phone, $email)
    {
        $data = array(
            'dni' => $dni,
            'nombre' => $name,
            'apellidos' => $surname,
            'telefono' => $phone,
            'email' => $email,
            'fecha_nacimiento' => $fecha_nac
        );
        $this->db->insert('clientes', $data);

        return $this->db->insert_id();
    }

    //añade un nuevo cliente
    public function insertNewClientWithMoreInfo($dni, $name, $surname, $fecha_nac, $phone, $email)
    {
        $data = array(
            'dni' => $dni,
            'nombre' => $name,
            'apellidos' => $surname,
            'telefono' => $phone,
            'email' => $email,
            'fecha_nacimiento' => $fecha_nac
        );
        $this->db->insert('clientes', $data);

        return $this->db->insert_id();
    }

    //actualiza un cliente
    public function updateClient($id_client, $dni, $name, $surname, $fecha_nac, $phone, $email)
    {
        $data = array(
            'dni' => $dni,
            'nombre' => $name,
            'apellidos' => $surname,
            'telefono' => $phone,
            'fecha_nacimiento' => $fecha_nac,
            'email' => $email
        );

        $this->db->where('id_cliente', $id_client)
            ->update('clientes', $data);
    }

    //actualiza un cliente
    public function updateClientWithMoreInfo($id, $dni, $name, $surname, $fecha_nac, $phone, $email)
    {
        $data = array(
            'dni' => $dni,
            'nombre' => $name,
            'apellidos' => $surname,
            'telefono' => $phone,
            'fecha_nacimiento' => $fecha_nac,
            'email' => $email
        );

        $this->db->where('id_cliente', $id)
            ->update('clientes', $data);
    }
}
