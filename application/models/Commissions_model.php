<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commissions_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //devuelve todos los tipos de comisiones
    public function getAllCommissions()
    {
        return $this->db->from('tipos_comisiones')->get()->result();
    }
}
