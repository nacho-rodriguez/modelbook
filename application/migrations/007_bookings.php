<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Bookings extends CI_Migration
{
    public function up()
    {
        //tabla servicios_precios
        $this->dbforge->add_field(
            array(
                'id_servicio_precio' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'tipo_cliente_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
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
        $this->dbforge->add_key('id_servicio_precio', true);
        $this->dbforge->create_table('servicios_precios');
        $this->db->query('ALTER TABLE `servicios_precios` ADD FOREIGN KEY(`tipo_cliente_fk`) REFERENCES tipos_clientes(`id_tipo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `servicios_precios` ADD FOREIGN KEY(`tipo_comision_fk`) REFERENCES tipos_comisiones(`id_tipo_comision`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `servicios_precios` ADD FOREIGN KEY(`servicio_fk`) REFERENCES servicios(`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `servicios_precios` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla reservas
        $this->dbforge->add_field(
            array(
                'id_reserva' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'numero_billete' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                ),
                'year' => array(
                    'type' => 'INT',
                    'constraint' => 4,
                    'null' => false
                ),
                'liquidacion_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 0,
                    'null' => false
                ),
                'estado_reserva' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'default' => 1,
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
                ),
                'fecha_reserva' => array(
                    'type' => 'TIMESTAMP',
                    'null' => false
                ),
                'hora_parada' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 25,
                    'null' => false
                ),
                'lugar_parada' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => false
                ),
                'main' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'null' => false
            ) )
        );
        $this->dbforge->add_key('id_reserva', true);
        $this->dbforge->create_table('reservas');
        //$this->db->query('ALTER TABLE `reservas` ADD FOREIGN KEY(`liquidacion_fk`) REFERENCES liquidaciones(`id_liquidacion`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `reservas` ADD FOREIGN KEY(`servicio_fk`) REFERENCES servicios(`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `reservas` ADD FOREIGN KEY(`vendedor_fk`) REFERENCES vendedores(`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla reservas_precios
        $this->dbforge->add_field(
            array(
                'id_reserva_precio' => array(
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
                    'null' => false,
                ),
                'comision' => array(
                    'type' => 'DECIMAL',
                    'constraint' => '6,2',
                    'null' => false,
                ),
                'tipo_comision_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                ),
                'reserva_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                ))
        );
        $this->dbforge->add_key('id_reserva_precio', true);
        $this->dbforge->create_table('reservas_precios');
        $this->db->query('ALTER TABLE `reservas_precios` ADD FOREIGN KEY(`tipo_cliente_fk`) REFERENCES tipos_clientes(`id_tipo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `reservas_precios` ADD FOREIGN KEY(`tipo_comision_fk`) REFERENCES tipos_comisiones(`id_tipo_comision`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `reservas_precios` ADD FOREIGN KEY(`reserva_fk`) REFERENCES reservas(`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;');

        //tabla reservas_clientes
        $this->dbforge->add_field(
            array(
                'id_reserva_cliente' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'auto_increment' => true
                ),
                'reserva_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ),
                'cliente_fk' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false
                ))
        );
        $this->dbforge->add_key('id_reserva_cliente', true);
        $this->dbforge->create_table('reservas_clientes');
        $this->db->query('ALTER TABLE `reservas_clientes` ADD FOREIGN KEY(`reserva_fk`) REFERENCES reservas(`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;');
        $this->db->query('ALTER TABLE `reservas_clientes` ADD FOREIGN KEY(`cliente_fk`) REFERENCES clientes(`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function down()
    {
        $this->db->query('set foreign_key_checks = 0');
        $this->dbforge->drop_table('servicios_precios', true);
        $this->dbforge->drop_table('reservas', true);
        $this->dbforge->drop_table('reservas_precios', true);
        $this->dbforge->drop_table('reservas_clientes', true);
        $this->db->query('set foreign_key_checks = 1');
    }
}
