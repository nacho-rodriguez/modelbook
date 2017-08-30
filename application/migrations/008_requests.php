<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Requests extends CI_Migration
{
    public function up()
    {
        //tabla peticiones
        $this->dbforge->add_field(
            array(
                'id_peticion' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'fecha_peticion' => array(
                    'type' => 'TIMESTAMP',
                    'null' => false
                ),
                'asunto' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 80,
                    'null' => false
                ),
                'estado' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 0,
                    'null' => false
                ),
                'vendedor_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_peticion', true);
        $this->dbforge->create_table('peticiones');
        $this->db->query('ALTER TABLE `peticiones` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla peticiones_mensajes
        $this->dbforge->add_field(
            array(
                'id_peticion_mensaje' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'fecha_hora' => array(
                    'type' => 'TIMESTAMP',
                    'null' => false
                ),
                'tipo' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'mensaje' => array(
                    'type' => 'TEXT',
                    'constraint' => 10,
                    'null' => false
                ),
                'peticion_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_peticion_mensaje', true);
        $this->dbforge->create_table('peticiones_mensajes');
        $this->db->query('ALTER TABLE `peticiones_mensajes` ADD FOREIGN KEY(`peticion_fk`) REFERENCES peticiones(`id_peticion`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down()
    {
        $this->db->query('set foreign_key_checks = 0');
        $this->dbforge->drop_table('peticiones', true);
        $this->dbforge->drop_table('peticiones_mensajes', true);
        $this->db->query('set foreign_key_checks = 1');
    }
}
