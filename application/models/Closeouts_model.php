<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Closeouts_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookings_clients_model', 'bcm');
    }

	//añade una liquidación
    public function insertCloseout($fecha_emision)
    {
        $data = array(
            'fecha_emision' => $fecha_emision,
        );
        $this->db->insert('liquidaciones', $data);

        return $this->db->insert_id();
    }

	//generamos el documento de cobro
    public function confirmCloseoutDocuments($id_closeout, $fecha_cobro)
    {
        $data = array(
            'fecha_creacion_cobro' => date('y-m-d H:m:s'),
            'fecha_cobro' => $fecha_cobro,
            'liquidado' => 1,
        );

        $this->db->where('id_liquidacion', $id_closeout)
            ->update('liquidaciones', $data);
    }

	//devuelve los documentos de liquidación
    public function getCloseoutDocumentsBySellerFromDates($id_seller, $dateStartBegin, $dateEndBegin, $startDateEnd, $dateEndFinalize, $tipo)
    {
        $datesStatement = '';
        $datesStatement2 = '';

        $filtro = $tipo == 1 ? 0 : 1;

        if ($dateStartBegin != '' && $dateEndBegin != '') {
            //$dateEndPlusOne = date('Y-m-d H:i:s', strtotime( "$dateEndBegin + 1 day" ));
            $datesStatement = " AND (fecha_emision BETWEEN '".$dateStartBegin."' AND '".$dateEndBegin."') ";
        }

        if ($startDateEnd != '' && $dateEndFinalize != '') {
            // $dateEndPlusOne = date('Y-m-d H:i:s', strtotime( "$dateEndFinalize + 1 day" ));
            $datesStatement2 = " AND (fecha_cobro BETWEEN '".$startDateEnd."' AND '".$dateEndFinalize."') ";
        }

        $query = $this->db->query("SELECT id_liquidacion,liquidado,DATE_FORMAT(fecha_emision,'%d/%m/%Y') as fecha_emision_liquidacion,DATE_FORMAT(fecha_cobro,'%d/%m/%Y') as fecha_cobro_liquidacion, COUNT(*) as totalReservasAsociadas FROM reservas,liquidaciones WHERE liquidaciones.id_liquidacion=reservas.liquidacion_fk AND liquidado=" .$filtro.' '.$datesStatement.$datesStatement2.' AND vendedor_fk=' .$id_seller. ' GROUP BY id_liquidacion ORDER BY id_liquidacion asc');

        return $query->result();
    }

	//devuelve los documentos de liquidación para el pdf
    public function getCloseoutDocumentForPrint($id_closeout)
    {
		$query = $this->db->select('id_servicio,nombre,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_fin,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision_liquidacion,DATE_FORMAT(fecha_cobro,"%d/%m/%Y") as fecha_cobro_liquidacion,liquidado,id_reserva,numero_billete,year as reserva_year,fecha_reserva,vendedor_fk')
			->from('servicios,reservas,liquidaciones')
			->where('id_servicio', 'servicio_fk', false)
			->where('id_liquidacion', 'liquidacion_fk', false)
			->where('id_liquidacion', $id_closeout)
			->get();

        $resultReservas = array();
        $resultReservas['reservas'] = $query->result();
        $totalReservaGlobal = 0;
        $totalComisionGlobal = 0;

        for ($k = 0; $k < count($resultReservas['reservas']); ++$k) {
            $dataClients = $this->bcm->getClientsFromBooking($resultReservas['reservas'][$k]->id_reserva, $resultReservas['reservas'][$k]->vendedor_fk);

            $resultReservas['reservas'][$k]->totalReserva = $dataClients['totalReserva'];
            $resultReservas['reservas'][$k]->totalComision = $dataClients['totalComision'];
            $resultReservas['reservas'][$k]->clientes = $dataClients;

            $totalReservaGlobal += $dataClients['totalReserva'];
            $totalComisionGlobal += $dataClients['totalComision'];
        }

        $resultReservas['totalReservaGlobal'] = $totalReservaGlobal;
        $resultReservas['totalComisionGlobal'] = $totalComisionGlobal;

        return $resultReservas;
    }

	//devuelve la información del vendedor del documento
    public function getSellerInfoFromCloseoutDocument($id_closeout)
    {
		return $this->db->select('telefono,vendedores.nombre,direccion,poblacion,provincia,email')
			->from('vendedores,reservas,liquidaciones')
			->where('id_vendedor', 'vendedor_fk', false)
			->where('id_liquidacion', 'liquidacion_fk', false)
			->where('id_liquidacion', $id_closeout)
			->get()->result()[0];
    }
}
