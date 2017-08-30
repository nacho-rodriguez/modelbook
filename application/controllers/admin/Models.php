<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('commissions_model', 'comm');
        $this->load->model('model_model', 'mm');
        $this->load->model('models_paradas_model', 'mparm');
        $this->load->model('models_prices_model', 'mprem');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('type_services_model', 'typeserm');
        $this->load->model('users_model', 'um');
    }

    //carga la vista de creación
    public function newModel()
    {
        if ($this->um->imAdmin()) {
            $data['code_result'] = 0;
            $data['all_commissions'] = $this->comm->getAllCommissions();
            $data['all_sellers'] = $this->selm->getAllSellers();
            $data['all_type_clients'] = $this->typeclim->getTypeClients();
            $data['all_type_services'] = $this->typeserm->getTypeServices();
            $data['backRoute'] = 'admin/dashboard';
            $data['title'] = 'Nuevo modelo';
            $this->load->view('admin/models/new_model', $data);
        } else {
            redirect(index_page());
        }
    }

    //modelo ya creado
    public function creatingModel()
    {
        $data = $this->prepareModel();

        $all_commissions = $this->comm->getAllCommissions();
        $all_sellers = $this->selm->getAllSellers();
        $all_models = $this->mm->getAllModels();
        $all_type_clients = $this->typeclim->getTypeClients();

        $data['all_commissions'] = $all_commissions;
        $data['all_models'] = $all_models;
        $data['all_sellers'] = $all_sellers;
        $data['all_type_clients'] = $all_type_clients;
        $data['backRoute'] = 'admin/dashboard';
        $data['title'] = 'Nuevo modelo';
        $this->session->set_flashdata('success', 'El modelo se ha creado correctamente. Por favor, continúe completando los detalles del modelo en la siguiente pestaña.');
        $this->load->view('admin/models/new_model', $data);
    }

    //ahora creamos el modelo
    public function prepareModel()
    {
        $modelo = $this->input->post('Modelo');
        $id_typeservice = $this->input->post('type_service');
        $titulo = $this->input->post('Titulo');
        $descripcion = $this->input->post('Descripcion');
        $recomendaciones = $this->input->post('Recomendaciones');
        $localidad_inicio = $this->input->post('LocalidadInicio');
        $localidad_fin = $this->input->post('LocalidadFin');
        $hora_inicio = $this->input->post('HoraInicio');
        $hora_fin = $this->input->post('HoraFin');
        $min_personas = $this->input->post('NumeroMinimoPersonas');
        $max_personas = $this->input->post('NumeroMaximoPersonas');
        $unique_passenger = ($this->input->post('unique_passenger') == true) ? 1 : 0;

        if (!$this->upload->do_upload('userfile')) {
            $foto = base_url('assets/imgs/photo_150x200.png');
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
        }

        $data['code_result'] = 1;
        $data['modelID'] = $this->mm->createNewModel($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $unique_passenger);

        return $data;
    }

    public function updateModel()
    {
        $id_model = $this->input->post('modelID');

        $this->prepareModelForUpdate();

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/models/showmodels';
        $data['modelID'] = $id_model;
        $data['modelInfo'] = $this->mm->getModelInformation($id_model);
        $data['title'] = 'Detalles del modelo';
        $this->session->set_flashdata('success', 'La información del modelo se ha actualizado correctamente.');
        $this->load->view('admin/models/details_model', $data);
    }

    public function prepareModelForUpdate()
    {
        $id_model = $this->input->post('modelID');
        $modelo = $this->input->post('Modelo');
        $id_typeservice = $this->input->post('typeService');
        $titulo = $this->input->post('Titulo');
        $descripcion = $this->input->post('Descripcion');
        $recomendaciones = $this->input->post('Recomendaciones');
        $foto = $this->input->post('foto');
        $localidad_inicio = $this->input->post('LocalidadInicio');
        $localidad_fin = $this->input->post('LocalidadFin');
        $hora_inicio = $this->input->post('HoraInicio');
        $hora_fin = $this->input->post('HoraFin');
        $min_personas = $this->input->post('NumeroMinimoPersonas');
        $max_personas = $this->input->post('NumeroMaximoPersonas');
        $unique_passenger = ($this->input->post('unique_passenger') == true) ? 1 : 0;
        $status = $this->input->post('state_model');

        if (!$this->upload->do_upload('userfile')) {
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
        }
        $this->mm->updateModelM($id_model, $modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $unique_passenger, $status);
    }

    // actualiza el banner
    public function updateBanner()
    {
        $id_model = $this->input->post('modelId');

        if (!$this->upload->do_upload('userfile')) {
            $this->session->set_flashdata('warning', 'No se ha podido actualizar el báner.');
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
            $this->session->set_flashdata('success', 'El báner se ha actualizado correctamente.');
            $this->mm->updateBannerM($id_model, $foto);
        }

        //carga el modelo con datos actualizados
        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/models/showmodels';
        $data['modelID'] = $id_model;
        $data['modelInfo'] = $this->mm->getModelInformation($id_model);
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromModel($id_model);
        $data['title'] = 'Detalles del modelo';
        $this->load->view('admin/models/details_model', $data);
    }

    public function createStopsForModel()
    {
        $id_model = $this->input->post('idModelo');
        $data = $this->input->post('paradasModelo');

        $allSellersWithParadas = explode('#', $data);

		foreach ($allSellersWithParadas as $seller) {
            $allParadasSeller = explode('&', $seller);

            $fullSeller = explode('=', $allParadasSeller[0]);
            $id_seller = $fullSeller[1];

            for ($j = 1; $j < count($allParadasSeller); $j += 2) {
                $timeFull = explode('=', $allParadasSeller[$j]);
                $paradaFull = explode('=', $allParadasSeller[$j + 1]);
                $finalParada = str_replace('+', ' ', $paradaFull[1]);

                if ($finalParada !== '' && $timeFull[1] !== '') {
                    $this->mparm->insertParadaModel($timeFull[1], $finalParada, $id_seller, $id_model);
                }
            }
        }
    }

    public function savePriceAndCommissionsForModel()
    {
        $id_model = $this->input->post('idModelo');
        $data = $this->input->post('comisionesServicio');
        $number_prices = $this->typeclim->noOfTypeClients();
        $allComisiones = explode('#', $data);

		foreach ($allComisiones as $comisionn) {
            $componentesPrecioIndividual = explode('&', $comisionn);

            $id_seller_full = explode('=', $componentesPrecioIndividual[0]);
            $id_seller = (count($id_seller_full) > 1) ? $id_seller_full[1] : 0;

            $k = 0;

            for ($j = 0; $j < $number_prices; ++$j) {
                $id_precio_tipo_clienteFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $valorFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $tipo_comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);

                $id_typeclient = (count($id_seller_full) > 1) ? $id_precio_tipo_clienteFULL[1] : 0;
                $valor = (count($id_seller_full) > 1) ? $valorFULL[1] : 0;
                $comision = (count($id_seller_full) > 1) ? $comisionFULL[1] : 0;
                $tipo_comision = (count($id_seller_full) > 1) ? $tipo_comisionFULL[1] : 0;

                $this->mprem->insertNewIndividualPriceModel($id_typeclient, $valor, $comision, $tipo_comision, $id_model, $id_seller);
            }
        }
    }

    public function showModels()
    {
        if ($this->um->imAdmin()) {
            $data['availableModels'] = $this->mm->getAvailableModels();
            $data['backRoute'] = 'admin/models/newmodel';
            $data['disableModels'] = $this->mm->getDisableModels();
            $data['title'] = 'Modelos';
            $this->load->view('admin/models/show_models', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsModel()
    {
        $id_modelo = $this->input->post('model');

        $data = array();
        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/models/showmodels';
        $data['modelID'] = $id_modelo;
        $data['modelInfo'] = $this->mm->getModelInformation($id_modelo);
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromModel($id_modelo);
        $data['title'] = 'Detalles del modelo';
        $this->load->view('admin/models/details_model', $data);
    }

    public function updateStopsForModel()
    {
        $id_model = $this->input->post('idModelo');
        $this->mparm->deleteAllParadasFromModel($id_model);
        $this->createStopsForModel();
    }

    public function updatePriceAndCommissionsForModels()
    {
        $id_model = $this->input->post('idModelo');
        $data = $this->input->post('preciosComisionesModelo');
        $number_prices = $this->typeclim->noOfTypeClients();
        $allComisiones = explode('#', $data);

        $this->mprem->deleteAllPricesFromModel($id_model);

		foreach ($allComisiones as $comisionn) {
            $componentesPrecioIndividual = explode('&', $comisionn);

            $id_seller_full = explode('=', $componentesPrecioIndividual[0]);
            $id_seller = (count($id_seller_full) > 1) ? $id_seller_full[1] : 0;

            $k = 0;

            for ($j = 0; $j < $number_prices; ++$j) {
                $id_precio_tipo_clienteFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $valorFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);
                $tipo_comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);

                $id_typeclient = (count($id_seller_full) > 1) ? $id_precio_tipo_clienteFULL[1] : 0;
                $valor = (count($id_seller_full) > 1) ? $valorFULL[1] : 0;
                $comision = (count($id_seller_full) > 1) ? $comisionFULL[1] : 0;
                $tipo_comision = (count($id_seller_full) > 1) ? $tipo_comisionFULL[1] : 0;

                $this->mprem->insertNewIndividualPriceModel($id_typeclient, $valor, $comision, $tipo_comision, $id_model, $id_seller);
            }
        }
    }
}
