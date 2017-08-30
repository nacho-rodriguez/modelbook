<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Types extends CI_Migration
{
    public function up()
    {
        //tabla liquidaciones
        $this->dbforge->add_field(
            array(
                'id_liquidacion' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'fecha_emision' => array(
                    'type' => 'date',
                    'null' => false
                ),
                'fecha_creacion_cobro' => array(
                    'type' => 'date',
                    'default' => null
                ),
                'fecha_cobro' => array(
                    'type' => 'date',
                    'default' => null
                ),
                'liquidado' => array(
                    'type' => 'int',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false
                ))
        );

        $this->dbforge->add_key('id_liquidacion', true);
        $this->dbforge->create_table('liquidaciones');

        //tabla tipos_comisiones
        $this->dbforge->add_field(
            array(
                'id_tipo_comision' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'nombre' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 25,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_tipo_comision', true);
        $this->dbforge->create_table('tipos_comisiones');

		$this->db->set(
			array('nombre' => '%')
		)->insert('tipos_comisiones');
		$this->db->set(
			array('nombre' => 'Fijo')
		)->insert('tipos_comisiones');

        //tabla tipos_servicios
        $this->dbforge->add_field(
            array(
                'id_tipo_servicio' => array(
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
                'estado' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 1,
                    'null' => false
                ),
                'orden' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 1,
                    'null' => false
                ))
        );

        $this->dbforge->add_key('id_tipo_servicio', true);
        $this->dbforge->create_table('tipos_servicios');

		$this->db->set(
			array(
				'nombre' => 'Excursión',
				'estado' => 1,
				'orden' => 1
			)
		)->insert('tipos_servicios');
		$this->db->set(
			array(
				'nombre' => 'Ruta',
				'estado' => 1,
				'orden' => 2
			)
		)->insert('tipos_servicios');
    }

    public function down()
    {
        $this->dbforge->drop_table('liquidaciones', true);
        $this->dbforge->drop_table('tipos_comisiones', true);
        $this->dbforge->drop_table('tipos_servicios', true);
    }
}
