<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Gestor extends CI_Migration
{
    public function up()
    {
		$this->db->set(
			array(
			'empresa' => 'Gestor ModelBook',
			'codigo_identificacion' => '12345-1',
			'cif' => 'X123456789',
			'direccion' => 'El Punto',
			'poblacion' => 'Conil',
			'provincia' => 'Cádiz',
			'telefono' => '956445566',
			'email_empresa' => 'modelbook@modelbook.com',
			'email' => 'admin@modelbook.com',
			'password' => $this->encryption->encrypt('admin'),
			'contador' => '0',
			'logo' => base_url('assets/imgs/banner_mix.png')
			)
		)->insert('gestor');
    }

    public function down()
    {
		$this->db->query('set foreign_key_checks = 0');
		$this->db->truncate('gestor', true);
		$this->db->query('set foreign_key_checks = 1');
    }
}
