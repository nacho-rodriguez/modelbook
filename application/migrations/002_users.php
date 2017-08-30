<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Users extends CI_Migration
{
    public function up()
    {
        //tabla gestor
        $this->dbforge->add_field(
            array(
                'id_gestor' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'auto_increment' => true
                ),
                'empresa' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => false
                ),
                'codigo_identificacion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'cif' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 12,
                    'null' => false
                ),
                'direccion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'poblacion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'provincia' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'telefono' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 12,
                    'null' => false
                ),
                'email_empresa' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => false
                ),
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ),
                'contador' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'unsigned' => true,
                ),
                'logo' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 250,
                    'null' => false,
                ))
        );
        $this->dbforge->add_key('id_gestor', true);
        $this->dbforge->create_table('gestor');

        //tabla vendedores
        $this->dbforge->add_field(
            array(
                'id_vendedor' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'cif' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'nombre' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'direccion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'poblacion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'provincia' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'telefono' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 10,
                    'null' => false
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'unique' => true,
                    'null' => false
                ),
                'estado' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 0,
                    'null' => false
                ),
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ),
                'mostrar_info_reserva' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 1,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_vendedor', true);
        $this->dbforge->create_table('vendedores');
    }

    public function down()
    {
        $this->dbforge->drop_table('gestor', true);
        $this->dbforge->drop_table('vendedores', true);
    }
}
