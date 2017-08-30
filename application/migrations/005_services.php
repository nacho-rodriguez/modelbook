<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Services extends CI_Migration
{
    public function up()
    {
        //tabla servicios
        $this->dbforge->add_field(
            array(
                'id_servicio' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'modelo' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'nombre' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'descripcion' => array(
                    'type' => 'text',
                    'null' => false
                ),
                'recomendaciones' => array(
                    'type' => 'text',
                    'null' => false
                ),
                'referencia' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 25,
                    'null' => false
                ),
                'foto' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => base_url('assets/imgs/photo_150x200.png'),
                    'null' => false
                ),
                'banner' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => base_url('assets/imgs/banner_bus.png'),
                    'null' => false
                ),
                'fecha_inicio' => array(
                    'type' => 'DATE',
                    'null' => false
                ),
                'localidad_inicio' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 25,
                    'null' => false
                ),
                'fecha_fin' => array(
                    'type' => 'DATE',
                    'null' => false
                ),
                'localidad_fin' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 25,
                    'null' => false
                ),
                'hora_inicio' => array(
                    'type' => 'TIME',
                    'null' => false
                ),
                'hora_fin' => array(
                    'type' => 'TIME',
                    'null' => false
                ),
                'min_personas' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'null' => false
                ),
                'max_personas' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'null' => false
                ),
                'estado' => array(
                    'type' => 'INT',
                    'constraint' => 1,
                    'default' => 1,
                    'null' => false
                ),
                'info_estado' => array(
                    'type' => 'text',
                    'null' => false
                ),
                'fecha_inicio_valido' => array(
                    'type' => 'DATE',
                    'null' => false
                ),
                'fecha_fin_valido' => array(
                    'type' => 'DATE',
                    'null' => false
                ),
                'unique_passenger' => array(
                    'type' => 'INT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false
                ),
                'tipo_servicio_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ),
                'fecha_modif' => array(
                    'type' => 'TIMESTAMP',
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_servicio', true);
        $this->dbforge->create_table('servicios');
        $this->db->query('ALTER TABLE `servicios` ADD FOREIGN KEY(`tipo_servicio_fk`) REFERENCES tipos_servicios(`id_tipo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down()
    {
        $this->db->query('set foreign_key_checks = 0');
        $this->dbforge->drop_table('servicios', true);
        $this->db->query('set foreign_key_checks = 1');
    }
}
