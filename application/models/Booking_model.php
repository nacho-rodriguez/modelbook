<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_Model extends CI_Model
{
	protected static $NOTCONFIRMED = 0;
	protected static $CONFIRMED = 1;
	protected static $CANCELED = 2;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookings_clients_model', 'bcm');
        $this->load->model('service_model', 'serm');
        $this->load->model('services_paradas_model', 'sparm');
    }

    //confirma la reserva
    public function confirmBooking($id_booking)
    {
        $data = array('estado_reserva' => self::$CONFIRMED);

        $this->db->where('id_reserva', $id_booking)
            ->update('reservas', $data);
    }

    //confirma la reserva por servicio
    public function confirmBookingByService($id_service)
    {
        $data = array('estado_reserva' => self::$CONFIRMED);

        $this->db->where('servicio_fk', $id_service)
            ->update('reservas', $data);
    }

    //cancela la reserva
    public function cancelBooking($id_booking)
    {
        $data = array('estado_reserva' => self::$CANCELED);

        $this->db->where('id_reserva', $id_booking)
            ->update('reservas', $data);
    }

    //cancela la reserva por servicio
    public function cancelBookingByService($id_service)
    {
        $data = array('estado_reserva' => self::$CANCELED);

        $this->db->where('servicio_fk', $id_service)
            ->update('reservas', $data);
    }

    //devuelve el vendedor de la reserva
    public function getSellerFromBooking($id_booking)
    {
        return $this->db->select('id_vendedor, nombre')
            ->from('reservas,vendedores')
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('id_reserva', $id_booking)
            ->get()->result()[0];
    }

    //devuelve el número de reservas hechas
    public function getNumberPeopleForCurrentBooking($id_service)
    {
        $query = $this->db->select('id_reserva')
            ->from('reservas')
            ->where('servicio_fk', $id_service)
            ->get()->result();

        $totalPersonas = 0;
        foreach ((array)$query as $q) {
            $totalPersonas += $this->bcm->getNumberOfClients($q->id_reserva);
        }

        return $totalPersonas;
    }

    //devuelve las reservas confirmadas
    public function getBookingsConfirmedByService($id_service)
    {
        $query = $this->db->select('id_reserva,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,estado_reserva,numero_billete,year as reserva_year,referencia,vendedores.nombre as nombre_vendedor,CONCAT(numero_billete,"/",year) as identificador_reserva')
            ->from('reservas,servicios,vendedores')
            ->where('id_servicio', 'servicio_fk', false)
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('servicio_fk', $id_service)
            ->where('estado_reserva', self::$CONFIRMED)
            ->order_by('id_reserva', 'asc')
            ->get()->result();

        foreach ((array)$query as $q) {
            $q->totalPersonas = $this->bcm->getNumberOfClients($q->id_reserva);
        }

        return $query;
    }

    //devuelve las reservas no confirmadas
    public function getBookingsNotConfirmedByService($id_service)
    {
        $query = $this->db->select('id_reserva,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,estado_reserva,numero_billete,year as reserva_year,referencia,vendedores.nombre as nombre_vendedor,CONCAT(numero_billete,"/",year) as identificador_reserva')
            ->from('reservas,servicios,vendedores')
            ->where('id_servicio', 'servicio_fk', false)
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('servicio_fk', $id_service)
            ->where('estado_reserva', self::$NOTCONFIRMED)
            ->order_by('id_reserva', 'asc')
            ->get()->result();

        foreach ((array)$query as $q) {
            $q->totalPersonas = $this->bcm->getNumberOfClients($q->id_reserva);
        }

        return $query;
    }

    //devuelve información básica de la reserva
    public function getShortInfo($id_booking)
    {
        return $this->db->select('numero_billete,year as year_reserva')
            ->from('reservas')
            ->where('id_reserva', $id_booking)
            ->get()->result()[0];
    }

    //devuelve las reservas hechas por el vendedor
    public function getBookingsBySeller($id_seller)
    {
        return $this->db->select('id_reserva')
            ->from('reservas')
            ->where('vendedor_fk', $id_seller)
            ->get()->result();
    }

    //devuelve las reservas hechas por el cliente
    public function getBookingsFromClient($id_client)
    {
        return $this->db->select('id_reserva,fecha_reserva,numero_billete,year as reservas_year,estado_reserva,id_servicio,servicios.nombre as nombre,tipos_servicios.nombre as tipo_servicio,liquidacion_fk as documento_liquidacion')
            ->from('reservas,servicios,reservas_clientes,tipos_servicios')
			->where('reserva_fk', 'id_reserva', false)
            ->where('servicio_fk', 'id_servicio', false)
			->where('id_tipo_servicio', 'tipo_servicio_fk', false)
            ->where('cliente_fk', $id_client)
            ->order_by('id_reserva', 'asc')
            ->get()->result();
    }

    //devuelve la reserva junto a la información del cliente
    public function getBooking($id_booking, $id_seller)
    {
        $query =  $this->db->select('id_reserva,numero_billete,reservas.year as reservas_year,estado_reserva,hora_parada,lugar_parada,liquidacion_fk as documento_liquidacion,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,id_servicio,servicios.nombre as nombreServicio,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio_reserva,localidad_inicio,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_fin_reserva,localidad_fin,DATE_FORMAT(hora_inicio,"%H:%i") as hora_inicio_reserva,DATE_FORMAT(hora_fin,"%H:%i") as hora_fin_reserva,descripcion,recomendaciones,banner')
            ->from('servicios,reservas')
            ->where('id_servicio', 'servicio_fk', false)
            ->where('id_reserva', $id_booking)
            ->get()->result()[0];

        $clients = $this->bcm->getClientsFromBooking($id_booking, $id_seller);

        $query->totalReserva = $clients['totalReserva'];
        $query->totalComision = $clients['totalComision'];
        $query->clients = $clients['clientes'];

        return $query;
    }

    //comprobamos si para el servicio se pueden hacer ese número de reservas
    public function checkBookingAvailability($id_service, $num_clients)
    {
        //número máximo permitido
        $max_personas = $this->serm->getMaxPersonasService($id_service);

		//calculamos el número de reservas hechas
		$query = $this->db->select('id_reserva')
			->from('reservas')
			->where('servicio_fk', $id_service)
			->where('estado_reserva', self::$CONFIRMED)
			->get();

		if ($query->num_rows() >= 0) {
			$totalBooking = 0;
			foreach ((array)$query->result() as $row)  {
				$totalBooking += $this->bcm->getNumberOfClients($row->id_reserva);
			}
			//se puede hacer la reserva
			if ($max_personas >= ($totalBooking + $num_clients)) {
				$data['status'] = "ok";
			}
			else{ //no hay sitio suficiente para las reservas
				$data['status'] = "fail";
			}
		}

		return $data;
    }

    //añade una reserva al sistema
    public function insertNewBooking($numero_billete_reserva, $id_service, $id_seller, $id_parada, $main_passenger)
    {
        $datosParada = $this->sparm->getParadaInformation($id_parada);

        $data = array(
            'numero_billete' => $numero_billete_reserva,
            'year' => date("Y"),
            'servicio_fk' => $id_service,
            'vendedor_fk' => $id_seller,
            'hora_parada' => $datosParada->hora_parada,
            'lugar_parada' => $datosParada->parada,
        	'main' => strcmp($main_passenger, 'true') == 0 ? 1: 0
        );
        $this->db->insert('reservas', $data);

        return $this->db->insert_id();
    }

    //añade una reserva al sistema sin confirmar
    public function insertNewBookingNotConfirmed($numero_billete_reserva, $id_service, $id_seller, $id_parada, $main_passenger)
    {
        $datosParada = $this->sparm->getParadaInformation($id_parada);

        $data = array(
            'numero_billete' => $numero_billete_reserva,
            'year' => date("Y"),
            'servicio_fk' => $id_service,
            'vendedor_fk' => $id_seller,
            'estado_reserva' => self::$NOTCONFIRMED,
            'hora_parada' => $datosParada->hora_parada,
            'lugar_parada' => $datosParada->parada,
        	'main' => strcmp($main_passenger, 'true') == 0 ? 1: 0
        );
        $this->db->insert('reservas', $data);

        return $this->db->insert_id();
    }

    //devuelve todas las reseras del vendedor
    public function getAllBookingFromSeller($id_seller)
    {
        $query = $this->db->select('id_reserva,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,estado_reserva,numero_billete,reservas.year as reserva_year,referencia,servicios.nombre as nombre_servicio,tipos_servicios.nombre as tipo_servicio,vendedores.nombre as nombre_vendedor,CONCAT(numero_billete,"/",reservas.year) as identificador_reserva, CONCAT(servicios.nombre," (",referencia,")") as servicio_completo')
            ->from('reservas,servicios,vendedores,tipos_servicios')
            ->where('servicio_fk', 'id_servicio', false)
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('id_tipo_servicio', 'tipo_servicio_fk', false)
            ->where('vendedor_fk', $id_seller)
            ->order_by('id_reserva', 'asc')
            ->get()->result();

        foreach ((array)$query as $reserva) {
            $reserva->totalPersonas = $this->bcm->getNumberOfClients($reserva->id_reserva);
        }

        return $query;
    }

    //devuelve las reservas canceladas por vendedor
    public function getCancelledBookings($id_seller)
    {
        $query = $this->db->select('id_reserva,fecha_reserva,numero_billete,reservas.year as reservas_year,estado_reserva,id_servicio,nombre,servicios.tipo_servicio_fk as tipo_servicio,referencia,fecha_inicio,CONCAT(numero_billete,"/",reservas.year) as identificacion_reserva, CONCAT(nombre,"/",referencia) as servicio_completo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo')
            ->from('reservas,servicios')
            ->where('servicio_fk', 'id_servicio', false)
            ->where('vendedor_fk', $id_seller)
            ->where('estado_reserva', self::$CANCELED)
			->order_by('id_reserva', 'asc')
            ->get()->result();

        foreach ($query as $booking) {
            $booking->totalPersonas = $this->bcm->getNumberOfClients($booking->id_reserva);
        }

        return $query;
    }

    //devuelve las reservas canceladas por servicio
    public function getCancelledBookingsFromService($id_service)
    {
        $query = $this->db->select('id_reserva,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,estado_reserva, numero_billete,reservas.year as reserva_year,referencia,vendedores.nombre as nombre_vendedor,CONCAT(numero_billete,"/",reservas.year) as identificador_reserva')
            ->from('reservas,servicios,vendedores')
            ->where('servicio_fk', 'id_servicio', false)
            ->where('id_vendedor', 'vendedor_fk', false)
            ->where('servicio_fk', $id_service)
            ->where('estado_reserva', self::$CANCELED)
            ->order_by('id_reserva', 'asc')
            ->get()->result();

        foreach ($query as $booking) {
            $booking->totalPersonas = $this->bcm->getNumberOfClients($booking->id_reserva);
        }

        return $query;
    }

    //devuelve la información del servicio
    public function getServiceStructureToPrint($id_service)
    {
        $query = $this->db->select('nombre,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion,localidad_inicio,localidad_fin')
            ->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0];

        $query->confirmadas = $this->getParadasAndBookingsFromService($id_service, self::$CONFIRMED);
        $query->noConfirmadas = $this->getParadasAndBookingsFromService($id_service, self::$NOTCONFIRMED);
        $query->anuladas = $this->getParadasAndBookingsFromService($id_service, self::$CANCELED);

        return $query;
    }

	//devuelve reservas y paradas
    public function getParadasAndBookingsFromService($id_service, $type)
    {
        $totalNumberBooking = 0;
        $query = $this->db->select('hora_parada,lugar_parada')
            ->from('reservas')
            ->where('servicio_fk', $id_service)
            ->group_by('hora_parada')
            ->get();

        $stops['paradas'] = $query->result();

        foreach ($stops['paradas'] as $parada) {
            $query2 = $this->db->select('id_reserva,DATE_FORMAT(fecha_reserva,"%d/%m/%Y, %H:%i") as fecha_emision_reserva,vendedores.nombre as nombre_vendedor,CONCAT(numero_billete,"/",reservas.year) as identificador_reserva')
                ->from('reservas,vendedores')
                ->where('id_vendedor', 'vendedor_fk', false)
                ->where('estado_reserva', $type)
                ->where('hora_parada', $parada->hora_parada)
                ->where('lugar_parada', $parada->lugar_parada)
				->order_by('id_reserva', 'asc')
                ->get();

            $parada->reservas = $query2->result();

            $totalPersonasParada = 0;
            foreach ($parada->reservas as $reserva) {
                $infoPassenger = $this->bcm->getNumberAndDataClients($reserva->id_reserva);
                $reserva->totalPersonas = $infoPassenger['totalPers'];

                if ($infoPassenger['totalPers']) {
                    $reserva->nombre = $infoPassenger['mainPassenger']->nombre;
                    $reserva->apellidos = $infoPassenger['mainPassenger']->apellidos;
                    $reserva->telefono = $infoPassenger['mainPassenger']->telefono;
                    $totalPersonasParada += $reserva->totalPersonas;
                    $totalNumberBooking += $reserva->totalPersonas;
                }
            }
            $parada->totalPersonasParada = $totalPersonasParada;
        }

        $stops['totalPersonas'] = $totalNumberBooking;
        return $stops;
    }

	//devuelve reservas pendientes
    public function getPendingPaymentsBooking($id_seller)
    {
		$query = $this->db->select('id_reserva,fecha_reserva,numero_billete,reservas.year as reservas_year, estado_reserva,id_servicio,nombre,servicios.tipo_servicio_fk as tipo_servicio,referencia,fecha_inicio, CONCAT(numero_billete,"/",reservas.year) as identificacion_reserva, CONCAT(nombre," (",referencia,")") as servicio_completo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo')
	            ->from('reservas,servicios')
				->where('reservas.servicio_fk', 'id_servicio', false)
				->where('vendedor_fk', $id_seller)
	            ->where('estado_reserva', self::$CONFIRMED)
				->where('liquidacion_fk', 0)
	            ->order_by('id_reserva', 'asc')
	            ->get()->result();

		foreach ((array)$query as $booking) {
			$booking->totalPersonas = $this->bcm->getNumberOfClients($booking->id_reserva);
		}

        return $query;
    }

	//añade el id del documento de liquidación
    public function confirmCloseoutBooking($id_booking, $id_closeout)
    {
        $data = array('liquidacion_fk' => $id_closeout);

        $this->db->where('id_reserva', $id_booking)
            ->update('reservas', $data);
    }

	//devuelve las pendientes
    public function getPendingPaymentsBookingFromDates($id_seller, $dateStartBegin, $dateEndBegin, $dateStartFinalize, $dateEndFinalize)
    {
        $datesStatement = '';
        $datesStatement2 = '';

        if ($dateStartBegin != '' && $dateEndBegin != '') {
            $dateEndPlusOne = date('Y-m-d H:i:s', strtotime("$dateEndBegin + 1 day"));
            $datesStatement = " AND (fecha_inicio BETWEEN '".$dateStartBegin."' AND '".$dateEndPlusOne."') ";
        }

        if ($dateStartFinalize != '' && $dateEndFinalize != '') {
            $dateEndPlusOne = date('Y-m-d H:i:s', strtotime("$dateEndFinalize + 1 day"));
            $datesStatement2 = " AND (fecha_fin BETWEEN '".$dateStartFinalize."' AND '".$dateEndPlusOne."') ";
        }

        $query = $this->db->query("SELECT id_reserva,fecha_reserva,numero_billete,reservas.year as reservas_year, estado_reserva,id_servicio,nombre,servicios.tipo_servicio_fk as tipo_servicio,referencia,fecha_inicio, CONCAT(numero_billete,'/',reservas.year) as identificacion_reserva, CONCAT(nombre,' (',referencia,')') as servicio_completo,DATE_FORMAT(fecha_fin,'%d/%m/%Y') as fecha_finalizacion,DATE_FORMAT(fecha_inicio,'%d/%m/%Y') as fecha_comienzo FROM reservas,servicios WHERE estado_reserva=".self::$CONFIRMED." AND liquidacion_fk=0 AND reservas.servicio_fk=id_servicio ".$datesStatement.$datesStatement2.' AND vendedor_fk='.$id_seller.' ORDER BY id_reserva asc');
        $result = $query->result();

		foreach ((array)$result as $reserva) {
            $reserva->totalPersonas = $this->bcm->getNumberOfClients($reserva->id_reserva);
        }

        return $result;
    }

	//devuelve las liquidadas
    public function getPastPaymentsBooking($id_seller, $dateStartBegin, $dateEndBegin, $dateStartFinalize, $dateEndFinalize)
    {
        $datesStatement = '';
        $datesStatement2 = '';

        if ($dateStartBegin != '' && $dateEndBegin != '') {
            $dateEndPlusOne = date('Y-m-d H:i:s', strtotime("$dateEndBegin + 1 day"));
            $datesStatement = " AND (fecha_inicio BETWEEN '".$dateStartBegin."' AND '".$dateEndPlusOne."') ";
        }

        if ($dateStartFinalize != '' && $dateEndFinalize != '') {
            $dateEndPlusOne = date('Y-m-d H:i:s', strtotime("$dateEndFinalize + 1 day"));
            $datesStatement2 = " AND (fecha_fin BETWEEN '".$dateStartFinalize."' AND '".$dateEndPlusOne."') ";
        }

        $query = $this->db->query("SELECT id_reserva,fecha_reserva,numero_billete,reservas.year as reservas_year,estado_reserva,id_servicio,nombre,servicios.tipo_servicio_fk as tipo_servicio,referencia,fecha_inicio,CONCAT(numero_billete,'/',reservas.year) as identificacion_reserva,CONCAT(nombre,' (',referencia,')') as servicio_completo,DATE_FORMAT(fecha_fin,'%d/%m/%Y') as fecha_finalizacion,DATE_FORMAT(fecha_inicio,'%d/%m/%Y') as fecha_comienzo FROM reservas,servicios WHERE liquidacion_fk!=0 AND reservas.servicio_fk=id_servicio ".$datesStatement.$datesStatement2.' AND vendedor_fk='.$id_seller.' ORDER BY id_reserva asc');
        $result = $query->result();

		foreach ((array)$result as $reserva) {
            $reserva->totalPersonas = $this->bcm->getNumberOfClients($reserva->id_reserva);
        }

        return $result;
    }

	//devolvemos la informacion para las liquidaciones
    public function getResumeInfo($id_seller)
    {
		//reservas sin liquidar
		$query = $this->db->select('id_servicio,nombre,modelo,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio')
			->from('servicios,reservas')
			->where('id_servicio', 'reservas.servicio_fk', false)
			->where('vendedor_fk', $id_seller)
			->where('estado_reserva', self::$CONFIRMED)
			->group_by('id_servicio')
			->get();

        $resultServicios['servicios'] = $query->result();
        $totalReservaGlobal = 0;
        $totalComisionGlobal = 0;

		foreach ($resultServicios['servicios'] as $servicio) {
            $id_service = $servicio->id_servicio;

			$query2 = $this->db->select('id_reserva,numero_billete,year as reserva_year,fecha_reserva')
				->from('reservas')
				->where('vendedor_fk', $id_seller)
				->where('servicio_fk', $id_service)
				->where('estado_reserva', self::$CONFIRMED)
				->where('liquidacion_fk', 0)
				->get();

            $resultReservas = $query2->result();
            $totalReservaServicio = 0;
            $totalComisionServicio = 0;

			foreach ($resultReservas as $reserva) {
                $dataClients = $this->bcm->getClientsFromBooking($reserva->id_reserva, $id_seller);

                $reserva->totalReserva = $dataClients['totalReserva'];
                $reserva->totalComision = $dataClients['totalComision'];
                $reserva->clientes = $dataClients;

                $totalReservaServicio += $dataClients['totalReserva'];
                $totalComisionServicio += $dataClients['totalComision'];
            }

            $totalReservaGlobal += $totalReservaServicio;
            $totalComisionGlobal += $totalComisionServicio;

            $servicio->totalReservaServicio = $totalReservaServicio;
            $servicio->totalComisionServicio = $totalComisionServicio;
            $servicio->reservas = $resultReservas;
        }

        $resultServicios['totalReservaGlobal'] = $totalReservaGlobal;
        $resultServicios['totalComisionGlobal'] = $totalComisionGlobal;

        return $resultServicios;
    }

    //devuelve si la salida está garantizada
    public function checkServiceConfirmedForStart($id_service)
    {
        $query = $this->db->select('id_reserva')
            ->from('reservas')
            ->where('servicio_fk', $id_service)
            ->get()->result();

        $totalPersonConfirmed = 0;
        foreach ((array)$query as $reserva) {
            $totalPersonConfirmed += $this->bcm->getNumberOfClients($reserva->id_reserva);
        }

        $min_personas = $this->serm->getMinPersonasService($id_service);

        $data['numeroPersonasActualesQueHanReservado'] = $totalPersonConfirmed;
        $data['garantizada'] = ($min_personas <= $totalPersonConfirmed)? 1 : 0;

        return $data;
    }
}
