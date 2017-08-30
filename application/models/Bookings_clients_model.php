<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings_clients_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('service_model', 'serm');
        $this->load->model('type_clients_model', 'typeclim');
    }

    //devuelve el número de clientes de una reserva
    public function getNumberOfClients($id_booking)
    {
        return $this->db->from('reservas_clientes')
            ->where('reserva_fk', $id_booking)
            ->get()->num_rows();
    }

    //devuelve datos de la reserva
    public function getNumberAndDataClients($id_booking)
    {
        $data = array();

        $query = $this->db->select('id_reserva_cliente,nombre,apellidos,telefono')
            ->from('reservas_clientes,clientes')
            ->where('cliente_fk', 'id_cliente', false)
            ->where('reserva_fk', $id_booking)
            ->get();

        $data['totalPers'] = $query->num_rows();
		$data['mainPassenger'] = $query->result() ? $query->result()[0] : new stdClass();

        return $data;
    }

    //añade una reserva de cliente
    public function insertNewRelationBookingClient($id_booking, $id_client)
    {
        $data = array(
            'reserva_fk' => $id_booking,
            'cliente_fk' => $id_client,
        );
        $this->db->insert('reservas_clientes', $data);
    }

	//devuelve datos del tipo de cliente
    public function getTypeClientBooking($id_service, $fecha_nac, $id_seller)
    {
        $fecha_nac = date_create($fecha_nac);
        $dateServicio = date_create($this->serm->getStartDate($id_service));

        $tipoClienteFinal = array();

        if ($fecha_nac) {
            $edad_cliente = date_diff($dateServicio, $fecha_nac)->format('%y');

            $allPricesServiceForThisSeller = $this->typeclim->getTypeClientForServiceAndSeller($id_service, $id_seller);
            $i = 0;

            while ($i < count($allPricesServiceForThisSeller)) {
                if ($edad_cliente >= $allPricesServiceForThisSeller[$i]->edad_minima && $edad_cliente <= $allPricesServiceForThisSeller[$i]->edad_maxima) {
                    $tipoClienteFinal['nombre'] = $allPricesServiceForThisSeller[$i]->nombre;
                    $tipoClienteFinal['valor_monetario'] = $allPricesServiceForThisSeller[$i]->valor_monetario;
                    $tipoClienteFinal['comision'] = $allPricesServiceForThisSeller[$i]->comision;
                    $tipoClienteFinal['tipo_comision_fk'] = $allPricesServiceForThisSeller[$i]->tipo_comision_fk;

                    $i = count($allPricesServiceForThisSeller);
                }
                ++$i;
            }
        }

        return $tipoClienteFinal;
    }

	//devuelve información de los clientes
    public function getClientsFromBooking($id_booking, $id_seller)
    {
		$id_service = $this->db->from('reservas')->where('id_reserva', $id_booking)->get()->result()[0]->servicio_fk;

		$query = $this->db->select('id_cliente,fecha_registro,dni,clientes.nombre,apellidos,telefono,email,fecha_nacimiento')
	        ->from('reservas_clientes,clientes,reservas')
	        ->where('reserva_fk','id_reserva', false)
			->where('cliente_fk','id_cliente', false)
			->where('id_reserva', $id_booking)
			->where('reserva_fk', $id_booking)
	        ->get();

		$query2 = $query->result();

        $totalReserva = 0;
        $totalComision = 0;
		foreach ($query2 as $booking) {
            $dataResult = $this->getTypeClientBooking($id_service, $booking->fecha_nacimiento, $id_seller);
            $tipo_comision = (int) $dataResult['tipo_comision_fk'];
            $valor_monetario = (float) $dataResult['valor_monetario'];
            $valor_comision = (float) $dataResult['comision'];
			if ($tipo_comision == 1){			//porcentaje
				$resPorcentaje = ($valor_monetario * $valor_comision) / 100;
				$booking->comisionTotal = $resPorcentaje;
			}else if ($tipo_comision == 2){		//valor fijo
				$booking->comisionTotal = $valor_comision;
			}

            $booking->tipo_cliente = $dataResult['nombre'];
            $booking->valor_monetario = $valor_monetario;
            $booking->comision = $valor_comision;
            $booking->tipo_comision = $tipo_comision;

            $totalReserva += $valor_monetario;
            $totalComision += $booking->comisionTotal;
        }

        $data['totalReserva'] = $totalReserva;
        $data['totalComision'] = $totalComision;
		$data['clientes'] = $query->result();

        return $data;
    }
}
