<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Paradas extends CI_Migration
{
    public function up()
    {
        //tabla servicios_paradas
        $this->dbforge->add_field(
            array(
                'id_servicio_parada' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'hora' => array(
                    'type' => 'TIME',
                    'null' => false
                ),
                'parada' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'servicio_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ),
                'vendedor_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_servicio_parada', true);
        $this->dbforge->create_table('servicios_paradas');
        $this->db->query('ALTER TABLE `servicios_paradas` ADD FOREIGN KEY(`servicio_fk`) REFERENCES servicios(`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `servicios_paradas` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');


    }

    public function down()
    {
        $this->db->query('set foreign_key_checks = 0');
        $this->dbforge->drop_table('servicios_paradas', true);
        $this->db->query('set foreign_key_checks = 1');
    }
}
