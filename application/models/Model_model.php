<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('models_paradas_model', 'mparm');
        $this->load->model('sellers_model', 'selm');
    }

    //crea el modelo
    public function createNewModel($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $unique_passenger)
    {
        $data = array(
            'modelo' => $modelo,
            'tipo_servicio_fk' => $id_typeservice,
            'nombre' => $titulo,
            'descripcion' => $descripcion,
            'recomendaciones' => $recomendaciones,
            'foto' => $foto,
            'localidad_inicio' => $localidad_inicio,
            'localidad_fin' => $localidad_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'minimo_personas' => $min_personas,
            'maximo_personas' => $max_personas,
            'unique_passenger' => $unique_passenger
        );
        $this->db->insert('modelos', $data);

        //devuelve el id de la BD del último modelo insertado
        return $this->db->insert_id();
    }

    //actualiza el modelo
    public function updateModelM($id_model, $modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $unique_passenger, $status)
    {
        $data = array(
            'modelo' => $modelo,
            'tipo_servicio_fk' => $id_typeservice,
            'nombre' => $titulo,
            'descripcion' => $descripcion,
            'recomendaciones' => $recomendaciones,
            'foto' => $foto ? $foto : $this->db->from('modelos')->where('id_modelo', $id_model)->get()->result()[0]->foto,
            'localidad_inicio' => $localidad_inicio,
            'localidad_fin' => $localidad_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'minimo_personas' => $min_personas,
            'maximo_personas' => $max_personas,
            'unique_passenger' => $unique_passenger,
            'estado' => $status
        );

        $this->db->where('id_modelo', $id_model)
            ->update('modelos', $data);
    }

    //actualiza el banner del modelo
    public function updateBannerM($id_model, $foto)
    {
        $data = array('banner' => $foto);
        $this->db->where('id_modelo', $id_model)
            ->update('modelos', $data);
    }

    //desactiva el modelo
    public function disableModel($id_model)
    {
        $data = array('estado' => 0);
        $this->db->where('id_modelo', $id_model)
            ->update('modelos', $data);
    }

    //devuelve los modelos activos
    public function getAvailableModels()
    {
        return $this->db->select('id_modelo,modelo,modelos.nombre as titulo, tipos_servicios.nombre as tipo_servicio')
            ->from('modelos, tipos_servicios')
            ->where('tipo_servicio_fk', 'id_tipo_servicio', false)
            ->where('modelos.estado', 1)
            ->order_by('id_modelo', 'asc')
            ->get()->result();
    }

    //devuelte los modelos inactivos
    public function getDisableModels()
    {
        return $this->db->select('id_modelo,modelo,modelos.nombre as titulo, tipos_servicios.nombre as tipo_servicio')
            ->from('modelos, tipos_servicios')
            ->where('tipo_servicio_fk', 'id_tipo_servicio', false)
            ->where('modelos.estado', 0)
			->order_by('id_modelo', 'asc')
            ->get()->result();
    }

    //devuelve todos los modelos
    public function getAllModels()
    {
        return $this->db->from('modelos')->order_by('id_modelo', 'asc')->get()->result();
    }

    //devuelve información del modelo completo
    public function getModelInformation($id_model)
    {
        $modelInfo = $this->db->from('modelos')->where('id_modelo', $id_model)->get()->result()[0];

        $modelInfo->paradasModelo = $this->mparm->getAllParadasFromModel($id_model);
        $modelInfo->preciosComisionesModelos = $this->selm->getPreciosComisionesSellersFromModel($id_model);

        return $modelInfo;
    }

    //devuelve la foto del modelo
    public function getPhotoFromModel($id_model)
    {
        return $this->db->from('modelos')->where('id_modelo', $id_model)->get()->result()[0]->foto;
    }

    //devuelve el banner del modelo
    public function getBannerFromModel($id_model)
    {
        return $this->db->from('modelos')->where('id_modelo', $id_model)->get()->result()[0]->banner;
    }
}
