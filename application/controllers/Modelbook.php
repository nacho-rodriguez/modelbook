<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelbook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('bookings_clients_model', 'bcm');
        $this->load->model('bookings_prices_model', 'booprim');
        $this->load->model('clients_model', 'clim');
        $this->load->model('closeouts_model', 'clom');
        $this->load->model('commissions_model', 'comm');
        $this->load->model('model_model', 'mm');
        $this->load->model('models_paradas_model', 'mparm');
        $this->load->model('models_prices_model', 'mprem');
        $this->load->model('request_model', 'reqm');
        $this->load->model('requests_messages_model', 'reqmm');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
        $this->load->model('services_paradas_model', 'sparm');
        $this->load->model('services_prices_model', 'sprim');
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('type_services_model', 'typeserm');
        $this->load->model('users_model', 'um');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function setUp()
    {
        if ($this->migration->current() === false) {
            show_error($this->migration->error_string());
        } else {
            print 'La instalacion del sistema se ha realizado correctamente.';
        }
    }

	public function t(){
		print_r($this->reqmm->getMessagesFromRequest(1));
	}


    public function test()
    {
		$sleep = 1;
        print 'Comenzando la creacion de datos...'.PHP_EOL; sleep($sleep);
		print 'Creando los tipos de servicio: '; sleep($sleep);
		//insertNewTypeService($name, $status, $order)
		$this->typeserm->insertNewTypeService('Traslado', 1, 3);
		print 'OK!'.PHP_EOL;

		print 'Creando los tipos de cliente:'; sleep($sleep);
		//insertNewTypeClient($name, $status, $edad_min, $edad_max)
		$this->typeclim->insertNewTypeClient('Adulto (+18)', 1, 18, 99);
		print 'OK!'.PHP_EOL;

		print 'Creando vendedores: '; sleep($sleep);
		//newSeller($cif, $name, $direccion, $poblacion, $provincia, $email, $phone, $status, $password, $show_info)
		$this->selm->newSeller('123456789', 'Vendedor1 Chiclana', 'Dirección Vendedor1', 'Chiclana', 'Cádiz', 'vendedoruno@modelbook.com', '956445566', 1, 'vendedoruno', 1);
		$this->selm->newSeller('123456789', 'Vendedor2 San Fernando', 'Dirección Vendedor2', 'San Fernando', 'Cádiz', 'vendedordos@modelbook.com', '956445566', 1, 'vendedordos', 1);
		print 'OK!'.PHP_EOL;

		print 'Creando clientes: '; sleep($sleep);
		//insertNewClient($dni, $name, $surname, $fecha_nac, $phone, $email)
		$this->clim->insertNewClient('44444444', 'Antonio', 'López', '1987-01-01', '666555444', 'antoniolopez@mail.com');
		$this->clim->insertNewClient('55555555', 'Juan', 'Rodríguez', '1987-01-01', '666555444', 'juanrodriguez@mail.com');
		print 'OK!'.PHP_EOL;

		print 'Creando modelos: '; sleep($sleep);
		//createNewModel($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $unique_passenger)
		$this->mm->createNewModel('DOÑANA', 1, 'Doñana Tours', 'Doñana Tour, gran empresa del sector.', 'Recomendaciones Doñana Tour. Pide factura.', '', 'Conil', 'Doñana', '09:00:00', '21:00:00', 5, 10, 1);
		$this->mm->createNewModel('PALMAR', 2, 'Palmar Tours', 'Palmar Tour, gran empresa del sector.', 'Recomendaciones Palmar Tour. Pide factura.', '', 'Conil', 'El Palmar', '17:00:00', '21:00:00', 5, 10, 1);
		print 'OK!'.PHP_EOL;

		print 'Asignando paradas a los modelos: '; sleep($sleep);
		//insertParadaModel($hora, $parada, $id_seller, $id_model)
		$this->mparm->insertParadaModel('10:00:00', 'Primera parada en Chiclana', 1, 1);
		$this->mparm->insertParadaModel('10:30:00', 'Segunda parada en San Fernando', 1, 1);
		$this->mparm->insertParadaModel('17:00:00', 'Primera parada en El Punto', 1, 2);
		$this->mparm->insertParadaModel('17:15:00', 'Segunda parada en el paseo marítimo', 1, 2);
		print 'OK!'.PHP_EOL;

		print 'Asignando precios a los modelos: '; sleep($sleep);
		//insertNewIndividualPriceModel($id_typeclient, $valor, $comision, $tipo_comision, $id_model, $id_seller)
		$this->mprem->insertNewIndividualPriceModel(1, 10, 10, 1, 1, 1);
		$this->mprem->insertNewIndividualPriceModel(2, 15, 10, 1, 1, 1);
		$this->mprem->insertNewIndividualPriceModel(3, 20, 10, 1, 1, 1);
		$this->mprem->insertNewIndividualPriceModel(4, 25, 10, 2, 1, 1);
		$this->mprem->insertNewIndividualPriceModel(1, 5, 5, 1, 2, 1);
		$this->mprem->insertNewIndividualPriceModel(2, 5, 5, 1, 2, 1);
		$this->mprem->insertNewIndividualPriceModel(3, 7, 5, 1, 2, 1);
		$this->mprem->insertNewIndividualPriceModel(4, 7, 5, 1, 2, 1);
		print 'OK!'.PHP_EOL;

		print 'Creando los servicios: '; sleep($sleep);
		//createNewService($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $referencia, $fecha_inicio, $fecha_fin, $unique_passenger, $status, $info_estado, $fecha_inicio_valido, $fecha_fin_valido, $id_model)
		$this->serm->createNewService(1, 1, 'Doñana en bus', 'Info: Primera parada en Chiclana, luego en San Fernando.', 'Se recomienda calzado cómodo', '', 'Conil', 'Doñana', '09:00:00', '21:00:00', 5, 10, 'REF_1', '2017-10-01', '2017-10-01', 1, 1, 'Si llueve se anula.', '2017-08-15', '2017-09-15', 1);
		$this->serm->createNewService(1, 2, 'Palmar en bici', 'Info: Primero a Sevilla y luego a Huelva.', 'Se recomienda calzado cómodo', '', 'Conil', 'Doñana', '12:00:00', '17:00:00', 5, 10, 'REF_1', '2017-10-01', '2017-10-01', 1, 1, 'Si llueve se anula.', '2017-08-15', '2017-09-15', 2);
		print 'OK!'.PHP_EOL;

		print 'Asignando paradas a los servicios: '; sleep($sleep);
		//insertParadaService($hora, $parada, $id_seller, $id_service)
		$this->sparm->insertParadaService('10:00:00', 'Primera parada en Chiclana', 1, 1);
		$this->sparm->insertParadaService('10:30:00', 'Segunda parada en SF', 1, 1);
		$this->sparm->insertParadaService('17:00:00', 'Primera parada en El Punto', 1, 2);
		$this->sparm->insertParadaService('17:15:00', 'Segunda parada en el paseo marítimo', 1, 2);
		print 'OK!'.PHP_EOL;

		print 'Asignando precios a los servicios: '; sleep($sleep);
		//insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $id_seller)
		$this->sprim->insertNewIndividualPriceService(1, 10, 10, 1, 1, 1);
		$this->sprim->insertNewIndividualPriceService(2, 15, 10, 1, 1, 1);
		$this->sprim->insertNewIndividualPriceService(3, 20, 10, 1, 1, 1);
		$this->sprim->insertNewIndividualPriceService(4, 25, 10, 2, 1, 1);
		$this->sprim->insertNewIndividualPriceService(1, 5, 5, 1, 2, 1);
		$this->sprim->insertNewIndividualPriceService(2, 5, 5, 1, 2, 1);
		$this->sprim->insertNewIndividualPriceService(3, 7, 5, 1, 2, 1);
		$this->sprim->insertNewIndividualPriceService(4, 7, 5, 1, 2, 1);
		print 'OK!'.PHP_EOL;

		print 'Creando reservas en el sistema: '; sleep($sleep);
		//insertNewBooking($numero_billete_reserva, $id_service, $id_seller, $id_parada, $main_passenger)
		$this->boom->insertNewBooking(1, 1, 1, 1, 'true');
		$this->boom->insertNewBooking(2, 2, 1, 3, 'true');
		print 'OK!'.PHP_EOL;

		print 'Asignando el precio de las reservas: '; sleep($sleep);
		$pricesService1 = $this->sprim->getComisionesFromSellerAndService(1, 1);
		foreach ($pricesService1 as $priceService) {
			$this->booprim->insertBookingPrice($priceService, 1);
		}
		$pricesService2 = $this->sprim->getComisionesFromSellerAndService(1, 2);
		foreach ($pricesService2 as $priceService) {
			$this->booprim->insertBookingPrice($priceService, 2);
		}
		print 'OK!'.PHP_EOL;

		print 'Creando mas clientes en el sistema: '; sleep($sleep);
		//$this->clim->insertNewClient($dni, $name, $surname, $fecha_nac, $phone, $email);
		$this->clim->insertNewClient("Sin DNI", '', '', "2001-01-01", '', '');
		$this->clim->insertNewClient("Sin DNI", '', '', "2001-01-01", '', '');
		print 'OK!'.PHP_EOL;

		print 'Asignando clientes creados a las reservas: '; sleep($sleep);
		//insertNewRelationBookingClient($id_booking, $id_client);
		$this->bcm->insertNewRelationBookingClient(1, 1);
		$this->bcm->insertNewRelationBookingClient(1, 3);
		$this->bcm->insertNewRelationBookingClient(1, 4);
		$this->bcm->insertNewRelationBookingClient(2, 1);
		$this->bcm->insertNewRelationBookingClient(2, 2);
		$this->bcm->insertNewRelationBookingClient(2, 3);
		$this->bcm->insertNewRelationBookingClient(2, 4);
		print 'OK!'.PHP_EOL;

		print 'Emitiendo los documentos de liquidacion: '; sleep($sleep);
		//confirmCloseoutBooking($id_booking, insertCloseout($fecha_emision))
		$this->boom->confirmCloseoutBooking(1, $this->clom->insertCloseout('2017-09-01'));
		$this->boom->confirmCloseoutBooking(2, $this->clom->insertCloseout('2017-09-02'));
		print 'OK!'.PHP_EOL;

		print 'Cobrando las liquidaciones: '; sleep($sleep);
		//confirmCloseoutDocuments($id_closeout, $fecha_cobro)
		$this->clom->confirmCloseoutDocuments(1, "2017-10-01");
		$this->clom->confirmCloseoutDocuments(2, "2017-10-02");
		print 'OK!'.PHP_EOL;

		print 'Abriendo dos peticiones: '; sleep($sleep);
		//insertNewRequest($asunto, $id_seller)
		$id_request1 = $this->reqm->insertNewRequest('Sugerencias', 1);
		//insertNewMessage($who, $message, $id_request)
		$this->reqmm->insertNewMessage(1, 'Hola vendedor, ¿necesita algún servicio en la plataforma?', $id_request1);
		$id_request2 = $this->reqm->insertNewRequest('Más plazas', 1);
		$this->reqmm->insertNewMessage(2, 'Hola gestor, necesitaría más plazas en la excursión de Doñana.', $id_request2);
		print 'OK!'.PHP_EOL;

		print 'Anadiendo mensajes a las peticiones: '; sleep($sleep);
		$this->reqmm->insertNewMessage(2, 'Hola, pues me vendría bien un servicio de desplazamiento al aeropuerto de Jerez.', 1);
		$this->reqmm->insertNewMessage(1, 'De acuerdo, lo añadiré en breve. Gracias.', 1);
		$this->reqmm->insertNewMessage(1, 'Hola, lo hablo con el conductor. Saludos.', 2);
		$this->reqmm->insertNewMessage(2, 'Muchas gracias.', 2);
		print 'OK!'.PHP_EOL;

		print 'Cerrando las peticiones: '; sleep($sleep);
		$this->reqm->closeRequest(1);
		$this->reqm->closeRequest(2);
		print 'OK!'.PHP_EOL;
    }

	public function clean(){
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
