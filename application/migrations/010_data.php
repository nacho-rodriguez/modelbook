<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Data extends CI_Migration
{
    public function up()
    {
		//001_types
		$this->db->set(
			array(
				'nombre' => 'Traslado',
				'estado' => 1,
				'orden' => 3
			)
		)->insert('tipos_servicios');

		//002_users
		$this->db->set(
			array(
				'cif' => '123456789',
				'nombre' => 'Vendedor1 Chiclana',
				'direccion' => 'Dirección Vendedor1',
				'poblacion' => 'Chiclana',
				'provincia' => 'Cádiz',
				'telefono' => '956445566',
				'estado' => 1,
				'email' => 'vendedoruno@modelbook.com',
				'password' => $this->encryption->encrypt('vendedoruno'),
			)
		)->insert('vendedores');
		$this->db->set(
			array(
				'cif' => '123456789',
				'nombre' => 'Vendedor2 San Fernando',
				'direccion' => 'Dirección Vendedor2',
				'poblacion' => 'San Fernando',
				'provincia' => 'Cádiz',
				'telefono' => '956445566',
				'estado' => 1,
				'email' => 'vendedordos@modelbook.com',
				'password' => $this->encryption->encrypt('vendedordos'),
			)
		)->insert('vendedores');

		//003_clients
		$this->db->set(
			array(
				'dni' => '44444444',
				'nombre' => 'Antonio',
				'apellidos' => 'Lopez',
				'telefono' => '666555444',
				'fecha_nacimiento' => '1987-01-01',
				'email' => 'antoniolopez@mail.com'
			)
		)->insert('clientes');
		$this->db->set(
			array(
				'dni' => '55555555',
				'nombre' => 'Juan',
				'apellidos' => 'Rodríguez',
				'telefono' => '666555444',
				'fecha_nacimiento' => '1987-01-01',
				'email' => 'juanrodriguez@mail.com'
			)
		)->insert('clientes');

		$this->db->set(
            array(
                'nombre' => 'Adulto (+18)',
                'edad_minima' => 18,
                'edad_maxima' => 99,
                'estado' => 1,
            )
        )->insert('tipos_clientes');

		//004_models
		$this->db->set(
			array(
			'modelo' => 'DOÑANA',
			'nombre' => 'Doñana Tours 1',
			'descripcion' => 'Doñana Tour, gran empresa del sector.',
			'recomendaciones' => 'Recomendaciones Doñana Tour. Pide factura.',
			'minimo_personas' => '5',
			'maximo_personas' => '10',
			'localidad_inicio' => 'Conil',
			'localidad_fin' => 'Doñana',
			'hora_inicio' => '12:00:00',
			'hora_fin' => '21:00:00',
			'estado' => 1,
			'tipo_servicio_fk' => 1
			)
		)->insert('modelos');

		$this->db->set(
            array(
            'hora' => '14:00:00',
            'parada' => 'Primera parada en Chiclana',
            'modelo_fk' => 1,
            'vendedor_fk' => 1
            )
        )->insert('modelos_paradas');
        $this->db->set(
            array(
            'hora' => '15:00:00',
            'parada' => 'Segunda parada en Jerez',
            'modelo_fk' => 1,
            'vendedor_fk' => 1
            )
        )->insert('modelos_paradas');

		$this->db->set(
            array(
            'tipo_cliente_fk' => 1,          //niño 1-3
            'valor_monetario' => '10.00',
            'comision' => '1.00',
            'tipo_comision_fk' => 1,        //efectivo
            'modelo_fk' => 1,
            'vendedor_fk' => 1,             //Vende Dor
            )
        )->insert('modelos_precios');
        $this->db->set(
            array(
            'tipo_cliente_fk' => 2,          //niño 4-12
            'valor_monetario' => '10.00',
            'comision' => '1.00',
            'tipo_comision_fk' => 1,        //efectivo
            'modelo_fk' => 1,
            'vendedor_fk' => 1,             //Vende Dor
            )
        )->insert('modelos_precios');
		$this->db->set(
            array(
            'tipo_cliente_fk' => 3,          //Adolescente 13-12
            'valor_monetario' => '10.00',
            'comision' => '1.00',
            'tipo_comision_fk' => 1,        //efectivo
            'modelo_fk' => 1,
            'vendedor_fk' => 1,             //Vende Dor
            )
        )->insert('modelos_precios');
		$this->db->set(
            array(
            'tipo_cliente_fk' => 4,          //adulto
            'valor_monetario' => '10.00',
            'comision' => '1.00',
            'tipo_comision_fk' => 1,        //efectivo
            'modelo_fk' => 1,
            'vendedor_fk' => 1,             //Vende Dor
            )
        )->insert('modelos_precios');

		//005_services
		$this->db->set(
            array(
                'modelo' => 1,
                'nombre' => 'Doñana en Bus',
                'descripcion' => 'Info: Primero a Sevilla y luego a Huelva.',
                'recomendaciones' => 'Se recomienda calzado cómodo',
                'referencia' => 'REF_1',
				'banner' => base_url('assets/imgs/banner_bus.png'),
                'fecha_inicio' => '2017-10-01',
                'localidad_inicio' => 'Conil',
                'fecha_fin' => '2017-10-01',
                'localidad_fin' => 'Doñana',
                'hora_inicio' => '12:00:00',
                'hora_fin' => '21:00:00',
                'min_personas' => 1,
                'max_personas' => 5,
                'estado' => 1,
                'info_estado' => 'Si llueve se anula.',
                'fecha_inicio_valido' => '2017-06-01',
                'fecha_fin_valido' => '2017-09-30',
                'tipo_servicio_fk' => 1,
            )
        )->insert('servicios');

		$this->db->set(
			array(
				'modelo' => 1,
				'nombre' => 'Palmar en bici',
				'descripcion' => 'Info: picnic en la playa.',
				'recomendaciones' => 'Llevarse una bicicleta',
				'referencia' => 'REF_2',
				'banner' => base_url('assets/imgs/banner_bike.png'),
				'fecha_inicio' => '2017-11-01',
				'localidad_inicio' => 'Conil',
				'fecha_fin' => '2017-11-02',
				'localidad_fin' => 'El Palmar',
				'hora_inicio' => '12:00:00',
				'hora_fin' => '21:00:00',
				'min_personas' => 2,
				'max_personas' => 5,
				'estado' => 1,
				'info_estado' => 'Si llueve se anula.',
				'fecha_inicio_valido' => '2017-08-15',
				'fecha_fin_valido' => '2017-10-31',
				'tipo_servicio_fk' => 1,
			)
		)->insert('servicios');

		//006_paradas
		$this->db->set(
			array(
				'hora' => '11:11:00',
				'parada' => 'El Colorado',
				'servicio_fk' => 1,
				'vendedor_fk' => 1,
			)
		)->insert('servicios_paradas');

		//007_bookings
		$this->db->set(
            array(
                'tipo_cliente_fk' => 1,
                'valor_monetario' => '1.11',
                'comision' => '1.11',
                'tipo_comision_fk' => 1,
                'servicio_fk' => 1,
                'vendedor_fk' => 1,
            )
        )->insert('servicios_precios');
        $this->db->set(
            array(
                'tipo_cliente_fk' => 2,
                'valor_monetario' => '2.22',
                'comision' => '1.11',
                'tipo_comision_fk' => 1,
                'servicio_fk' => 1,
                'vendedor_fk' => 1,
            )
        )->insert('servicios_precios');
        $this->db->set(
            array(
                'tipo_cliente_fk' => 3,
                'valor_monetario' => '3.33',
                'comision' => '1.11',
                'tipo_comision_fk' => 1,
                'servicio_fk' => 1,
                'vendedor_fk' => 1,
            )
        )->insert('servicios_precios');

		$this->db->set(
            array(
                'numero_billete' => 3,
                'year' => 2017,
                'estado_reserva' => 1,
                'servicio_fk' => 1,
                'vendedor_fk' => 1,
                'hora_parada' => '14:49',
                'lugar_parada' => 'Servicio 1. Parada Chiclana'
            )
        )->insert('reservas');
        $this->db->set(
            array(
                'numero_billete' => 4,
                'year' => 2017,
                'estado_reserva' => 1,
                'servicio_fk' => 1,
                'vendedor_fk' => 1,
                'hora_parada' => '14:49',
                'lugar_parada' => 'Servicio 2. Parada Chiclana'
            )
        )->insert('reservas');

		$this->db->set(
			array(
				'tipo_cliente_fk' => 1,
				'valor_monetario' => '1.00',
				'comision' => '1.00',
				'tipo_comision_fk' => 1,
				'reserva_fk' => 1,
			)
		)->insert('reservas_precios');
		$this->db->set(
			array(
				'tipo_cliente_fk' => 2,
				'valor_monetario' => '1.00',
				'comision' => '1.00',
				'tipo_comision_fk' => 1,
				'reserva_fk' => 1,
			)
		)->insert('reservas_precios');
		$this->db->set(
			array(
				'tipo_cliente_fk' => 3,
				'valor_monetario' => '1.00',
				'comision' => '1.00',
				'tipo_comision_fk' => 1,
				'reserva_fk' => 1,
			)
		)->insert('reservas_precios');

		$this->db->set(
			array(
				'reserva_fk' => 1,
				'cliente_fk' => 1
			)
		)->insert('reservas_clientes');
		$this->db->set(
			array(
				'reserva_fk' => 2,
				'cliente_fk' => 1
			)
		)->insert('reservas_clientes');

		//008_requests
		$this->db->set(
			array(
				'asunto' => 'Primera comunicación interna',
				'vendedor_fk' => 1,
			)
		)->insert('peticiones');

		$this->db->set(
			array(
				'tipo' => 1,
				'mensaje' => 'Hola Don Pepito!',
				'peticion_fk' => 1
			)
		)->insert('peticiones_mensajes');
		$this->db->set(
			array(
				'tipo' => 2,
				'mensaje' => 'Hola Don José!',
				'peticion_fk' => 1
			)
		)->insert('peticiones_mensajes');
    }

    public function down()
    {
		$this->db->query('set foreign_key_checks = 0');
		$this->db->truncate('liquidaciones');
		$this->db->truncate('tipos_comisiones');
		$this->db->truncate('tipos_servicios');
		$this->db->truncate('vendedores');
		$this->db->truncate('clientes');
		$this->db->truncate('tipos_clientes');
		$this->db->truncate('modelos');
		$this->db->truncate('modelos_paradas');
		$this->db->truncate('modelos_precios');
		$this->db->truncate('servicios');
		$this->db->truncate('servicios_paradas');
		$this->db->truncate('servicios_precios');
		$this->db->truncate('reservas');
		$this->db->truncate('reservas_precios');
		$this->db->truncate('reservas_clientes');
		$this->db->truncate('peticiones');
		$this->db->truncate('peticiones_mensajes');
		$this->db->query('set foreign_key_checks = 1');
    }
}
