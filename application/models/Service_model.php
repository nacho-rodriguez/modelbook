<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_Model extends CI_Model
{
    //CANCELED = 2

    public function __construct()
    {
        parent::__construct();
        $this->load->model('booking_model', 'boom');
        $this->load->model('model_model', 'mm');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('services_paradas_model', 'sparm');
    }

    //crea el servicio
    public function createNewService($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $referencia, $fecha_inicio, $fecha_fin, $unique_passenger, $status, $info_estado, $fecha_inicio_valido, $fecha_fin_valido, $id_model)
    {
        $data = array(
            'modelo' => $modelo,
            'nombre' => $titulo,
            'descripcion' => $descripcion,
            'recomendaciones' => $recomendaciones,
            'referencia' => $referencia,
            'foto' => $foto,
            'banner' => $this->mm->getBannerFromModel($id_model),
            'fecha_inicio' => $fecha_inicio,
            'localidad_inicio' => $localidad_inicio,
            'fecha_fin' => $fecha_fin,
            'localidad_fin' => $localidad_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'min_personas' => $min_personas,
            'max_personas' => $max_personas,
            'unique_passenger' => $unique_passenger,
            'estado' => $status,
            'info_estado' => $info_estado,
            'fecha_inicio_valido' => $fecha_inicio_valido,
            'fecha_fin_valido' => $fecha_fin_valido,
            'tipo_servicio_fk'=> $id_typeservice,
        );
        $this->db->insert('servicios', $data);

        //devuelve el id de la BD del último servicio insertado
        return $this->db->insert_id();
    }

    //actualiza el servicio
    public function updateServiceM($id_service, $id_typeservice, $modelo, $titulo, $descripcion, $recomendaciones, $localidad_inicio,  $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $referencia, $fecha_inicio, $fecha_fin, $unique_passenger, $status, $info_estado, $fecha_inicio_valido, $fecha_fin_valido, $foto)
    {
        $data = array(
            'modelo' => $modelo,
            'tipo_servicio_fk'=> $id_typeservice,
            'nombre' => $titulo,
            'descripcion' => $descripcion,
            'recomendaciones' => $recomendaciones,
            'referencia' => $referencia,
            'foto' => $foto,
            'fecha_inicio' => $fecha_inicio,
            'localidad_inicio' => $localidad_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'localidad_fin' => $localidad_fin,
            'min_personas' => $min_personas,
            'max_personas' => $max_personas,
			'unique_passenger' => $unique_passenger,
            'estado' => $status,
            'info_estado' => $info_estado,
            'fecha_inicio_valido' => $fecha_inicio_valido,
            'fecha_fin_valido' => $fecha_fin_valido,
        );

        $this->db->where('id_servicio', $id_service)
            ->update('servicios', $data);

        // Si el estado del servicio se va a cancelar, entonces cancelo todas las reservas realizadas por los vendedores.
        if ($status == 2) {
            $this->boom->cancelBookingByService($id_service);
        }
    }

    //actualiza el banner del servicio
    public function updateBannerS($id_service, $foto)
    {
        $data = array('banner' => $foto);
        $this->db->where('id_servicio', $id_service)
            ->update('servicios', $data);
    }

    //devuelve el mínimo numero de personas del servicio
    public function getMinPersonasService($id_service)
    {
        return $this->db->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0]->min_personas;
    }

    //devuelve el máximo numero de personas del servicio
    public function getMaxPersonasService($id_service)
    {
        return $this->db->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0]->max_personas;
    }

    //dvuelve la fecha de inicio del servicio
    public function getStartDate($id_service)
    {
        return $this->db->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0]->fecha_inicio;
    }

    //devuelve todos los servicios disponibles
    public function getAvailableServices()
    {
        $query = $this->db->select('id_servicio,nombre,referencia,estado,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion')
            ->from('servicios')
            ->where('fecha_fin >=', date('Y-m-d'))
            ->order_by('estado', 'desc')
            ->get()->result();

        foreach ((array)$query as $servicio) {
            $servicio->numero_actual_reservas_realizadas = $this->boom->getNumberPeopleForCurrentBooking($servicio->id_servicio);
        }

        return $query;
    }

    //devuelve todos los servicios disponibles
    public function getNotAvailableServices()
    {
        $query = $this->db->select('id_servicio,nombre,referencia,estado,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion')
            ->from('servicios')
            ->where('fecha_fin <', date('Y-m-d'))
            ->order_by('estado', 'desc')
            ->get()->result();

        foreach ((array)$query as $servicio) {
            $servicio->numero_actual_reservas_realizadas = $this->boom->getNumberPeopleForCurrentBooking($servicio->id_servicio);
        }

        return $query;
    }

    //devuelve todos los servicios aún disponibles
    public function getServicesCurrentlyAvailables()
    {
        $query = $this->db->select('id_servicio,nombre,referencia,estado,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion')
            ->from('servicios')
            ->where('estado', 1)
            ->where('fecha_fin >=', date('Y-m-d'))
            ->order_by('id_servicio', 'asc')
            ->get()->result();

        foreach ((array)$query as $q) {
            $q->numero_actual_reservas_realizadas = $this->boom->getNumberPeopleForCurrentBooking($q->id_servicio);
        }

        return $query;
    }

    //devuelve los datos del servicio
    public function getService($id_service)
    {
        $query = $this->db->select('id_servicio,modelo,nombre,descripcion,recomendaciones,foto,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_finalizacion,DATE_FORMAT(hora_inicio,"%H:%i") as hora_inicio,DATE_FORMAT(hora_fin,"%H:%i") as hora_fin,DATE_FORMAT(fecha_inicio_valido,"%d/%m/%Y") as fecha_comienzo_reservas,DATE_FORMAT(fecha_fin_valido,"%d/%m/%Y a las %H:%i") as fecha_finalizacion_reservas,localidad_inicio,localidad_fin,min_personas,max_personas,info_estado,unique_passenger')
            ->from('servicios')
            ->where('id_servicio', $id_service)
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result()[0];
        }

        return 0;
    }

    //devuelve datos básicos del servicio
    public function getFullNameService($id_service)
    {
        return $this->db->select('nombre,referencia,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio')
            ->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0];
    }

    //devuelve información del servicio completo
    public function getServiceInformation($id_service)
    {
        $query = $this->db->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0];

        $query->paradasServicio = $this->sparm->getAllParadasFromService($id_service);
        $query->preciosComisionesServicio = $this->selm->getPreciosComisionesSellersFromService($id_service);

        return $query;
    }

    //devuelve información del servicio con reservas
    public function getServiceInformationForBooking($id_service, $id_seller)
    {
        $query = $this->db->select('id_servicio,nombre,DATE_FORMAT(fecha_inicio,"%Y") as onlyyear,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_comienzo,DATE_FORMAT(fecha_fin_valido,"%d/%m/%Y") as fecha_reservas_fin,referencia,unique_passenger')
            ->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0];

        $query->paradasVendedor = $this->sparm->getAllParadasFromServiceFromSeller($id_service, $id_seller);

        return $query;
    }

    //devuelve si se pueden realizar reservas
    public function checkBookingValidDates($id_service)
    {
        $query = $this->db->select('DATE_FORMAT(fecha_fin_valido,"%Y-%m-%d %H:%i") as fecha_limite')
            ->from('servicios')
            ->where('id_servicio', $id_service)
            ->get()->result()[0]->fecha_limite;

        return (date('Y-m-d H:i') <= $query)? 1 : 0;
    }

    //devuelve todos los tipos de servicio que venda el vendedor
    public function getServicesAvailablesShortInfo($id_seller)
    {
        $query = $this->db->select('id_tipo_servicio,nombre,orden')
            ->from('tipos_servicios')
            ->where('estado', 1)
            ->order_by('orden', 'asc')
            ->get()->result();

        foreach ($query as $tipoServicio) {
            $query2 = $this->db->query(
                "SELECT id_servicio,servicios.nombre as nombre_servicio,id_tipo_servicio,tipos_servicios.nombre,DATE_FORMAT(fecha_fin_valido,'%d/%m/%Y') as fecha_fin_reservas,info_estado,servicios.estado,foto,tipos_servicios.nombre as tipo,max_personas,DATE_FORMAT(fecha_inicio,'%d/%m/%Y') as fecha_comienzo,DATE_FORMAT(fecha_inicio,'%W') as fecha_comienzo_dia,DATE_FORMAT(fecha_fin_valido,'%W') as fecha_fin_reservas_dia FROM servicios LEFT OUTER JOIN tipos_servicios ON id_tipo_servicio = tipo_servicio_fk LEFT OUTER JOIN servicios_precios ON servicio_fk=id_servicio AND vendedor_fk=".$id_seller." WHERE servicios_precios.servicio_fk IS NOT NULL AND tipos_servicios.id_tipo_servicio=" .$tipoServicio->id_tipo_servicio." AND valor_monetario != 0 AND servicios.estado=1 AND fecha_fin>DATE_SUB(NOW(),INTERVAL 1 DAY) GROUP BY id_servicio"
			);

            $queryResult = $query2->result();

            foreach ($queryResult as $result) {
				$result->fecha_comienzo_dia = utf8_encode(strftime("%A", strtotime($result->fecha_comienzo_dia)));
				$result->fecha_fin_reservas_dia =  utf8_encode(strftime("%A", strtotime($result->fecha_fin_reservas_dia)));

                $datos = $this->boom->checkServiceConfirmedForStart($result->id_servicio);

                $plazasRestantes = $result->max_personas - $datos['numeroPersonasActualesQueHanReservado'];
                $result->plazasRestantes = ($plazasRestantes < 0) ? 0 : $plazasRestantes;

                $result->garantizada = $datos['garantizada'];
                $result->realizarReservas = $this->checkBookingValidDates($result->id_servicio);
            }

            $tipoServicio->totalNumber = $query2->num_rows();
            $tipoServicio->result = $queryResult;
        }

        return $query;
    }
}
