<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Clients extends CI_Migration
{
    public function up()
    {
        //tabla clientes
        $this->dbforge->add_field(
            array(
                'id_cliente' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'fecha_registro' => array(
                    'type' => 'TIMESTAMP',
                    'null' => false
                ),
                'dni' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'nombre' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'apellidos' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'telefono' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'fecha_nacimiento' => array(
                    'type' => 'date',
                    'null' => false
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_cliente', true);
        $this->dbforge->create_table('clientes');



        //tabla tipos_clientes
        $this->dbforge->add_field(
            array(
                'id_tipo_cliente' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'nombre' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'edad_minima' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'null' => false
                ),
                'edad_maxima' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'null' => false
                ),
                'estado' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_tipo_cliente', true);
        $this->dbforge->create_table('tipos_clientes');

		$this->db->set(
			array(
				'nombre' => 'Niño (1-3)',
				'edad_minima' => 1,
				'edad_maxima' => 3,
				'estado' => 1,
			)
		)->insert('tipos_clientes');
		$this->db->set(
			array(
				'nombre' => 'Niño (4-12)',
				'edad_minima' => 4,
				'edad_maxima' => 12,
				'estado' => 1,
			)
		)->insert('tipos_clientes');
		$this->db->set(
			array(
				'nombre' => 'Adolescente (13-17)',
				'edad_minima' => 13,
				'edad_maxima' => 17,
				'estado' => 1,
			)
		)->insert('tipos_clientes');
    }

    public function down()
    {
        $this->dbforge->drop_table('clientes', true);
        $this->dbforge->drop_table('tipos_clientes', true);
    }
}
