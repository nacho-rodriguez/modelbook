<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Models extends CI_Migration
{
    public function up()
    {
        //tabla modelos
        $this->dbforge->add_field(
            array(
            'id_modelo' => array(
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
            'minimo_personas' => array(
	            'type' => 'INT',
	            'constraint' => 2,
	            'null' => false
            ),
            'maximo_personas' => array(
	            'type' => 'INT',
	            'constraint' => 2,
	            'null' => false
            ),
            'localidad_inicio' => array(
	            'type' => 'VARCHAR',
	            'constraint' => 25,
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
			'estado' => array(
	            'type' => 'INT',
	            'constraint' => 1,
	            'default' => 1,
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
        $this->dbforge->add_key('id_modelo', true);
        $this->dbforge->create_table('modelos');
        $this->db->query('ALTER TABLE `modelos` ADD FOREIGN KEY(`tipo_servicio_fk`) REFERENCES tipos_servicios(`id_tipo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla modelos_paradas
        $this->dbforge->add_field(
            array(
            'id_modelo_parada' => array(
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
            'modelo_fk' => array(
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
        $this->dbforge->add_key('id_modelo_parada', true);
        $this->dbforge->create_table('modelos_paradas');
        $this->db->query('ALTER TABLE `modelos_paradas` ADD FOREIGN KEY(`modelo_fk`) REFERENCES modelos(`id_modelo`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `modelos_paradas` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla modelos_precios
        $this->dbforge->add_field(
            array(
            'id_modelo_precio' => array(
            'type' => 'INT',
            'constraint' => 10,
            'null' => false,
            'auto_increment' => true
            ),
            'tipo_cliente_fk' => array(
            'type' => 'INT',
            'constraint' => 10,
            'null' => false
            ),
            'valor_monetario' => array(
            'type' => 'DECIMAL',
            'constraint' => '6,2',
            'null' => false
            ),
            'comision' => array(
            'type' => 'DECIMAL',
            'constraint' => '6,2',
            'null' => false
            ),
            'tipo_comision_fk' => array(
            'type' => 'INT',
            'constraint' => 10,
            'null' => false
            ),
            'modelo_fk' => array(
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
        $this->dbforge->add_key('id_modelo_precio', true);
        $this->dbforge->create_table('modelos_precios');
        $this->db->query('ALTER TABLE `modelos_precios` ADD FOREIGN KEY(`tipo_cliente_fk`) REFERENCES tipos_clientes(`id_tipo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `modelos_precios` ADD FOREIGN KEY(`tipo_comision_fk`) REFERENCES tipos_comisiones(`id_tipo_comision`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `modelos_precios` ADD FOREIGN KEY(`modelo_fk`) REFERENCES modelos(`id_modelo`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `modelos_precios` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down()
    {
        $this->db->query('set foreign_key_checks = 0');
        $this->dbforge->drop_table('modelos', true);
        $this->dbforge->drop_table('modelos_paradas', true);
        $this->dbforge->drop_table('modelos_precios', true);
        $this->db->query('set foreign_key_checks = 1');
    }
}
