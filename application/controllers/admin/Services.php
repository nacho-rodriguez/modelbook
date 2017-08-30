<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('commissions_model', 'comm');
        $this->load->model('model_model', 'mm');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
        $this->load->model('services_paradas_model', 'sparm');
        $this->load->model('services_prices_model', 'sprim');
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('type_services_model', 'typeserm');
        $this->load->model('users_model', 'um');
    }

    //carga la pre-vista de creación
    public function createService()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/dashboard';
            $data['modelsList'] = $this->mm->getAvailableModels();
            $data['title'] = 'Crear servicio';
            $this->load->view('admin/services/show_models', $data);
        } else {
            redirect(index_page());
        }
    }

    //carga la vista de creación
    public function newService()
    {
        $id_modelo = $this->input->post('model');

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/services/createservice';
        $data['code_result'] = 0;
        $data['modelInfo'] = $this->mm->getModelInformation($id_modelo);
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromModel($id_modelo);
        $data['title'] = 'Nuevo servicio';
        $this->load->view('admin/services/new_service', $data);
    }

    //servicio ya creado
    public function creatingService()
    {
        $id_modelo = $this->input->post('modelID');

        $data = $this->prepareService();

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['backRoute'] = 'admin/services/createservice';
        $data['modelInfo'] = $this->mm->getModelInformation($id_modelo);
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromModel($id_modelo);
        $data['title'] = 'Nuevo servicio';
        $this->session->set_flashdata('success', 'El servicio se ha creado correctamente. Por favor, continúe completando los detalles del servicio en la siguiente pestaña.');
        $this->load->view('admin/services/new_service', $data);
    }

    //ahora creamos el servicio
    public function prepareService()
    {
        $modelo = $this->input->post('Modelo');
        $id_typeservice = $this->input->post('typeService');
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

        $referencia = $this->input->post('Referencia');
        $fecha_inicio = $this->input->post('FechaInicio');
        $fecha_fin = $this->input->post('FechaFin');
        $status = $this->input->post('Estado');
        $info_estado = $this->input->post('InfoEstado');
        $fecha_inicio_valido = $this->input->post('fechaReservasInicio');
        $fecha_fin_valido = $this->input->post('fechaReservasFin');
        $id_model = $this->input->post('modelID');

        if (!$this->upload->do_upload('userfile')) {
            $foto = $this->mm->getPhotoFromModel($id_model);
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
        }

		$data['code_result'] = 1;
        $data['serviceID'] = $this->serm->createNewService($modelo, $id_typeservice, $titulo, $descripcion, $recomendaciones, $foto, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $referencia, $fecha_inicio, $fecha_fin, $unique_passenger, $status, $info_estado, $fecha_inicio_valido, $fecha_fin_valido, $id_model);

        return $data;
    }

    public function createStopsForService()
    {
        $idService = $this->input->post('idServicio');
        $data = $this->input->post('paradasServicio');

        $allSellersWithParadas = explode('#', $data);

		foreach ((array)$allSellersWithParadas as $seller) {
            $allParadasSeller = explode('&', $seller);

            $fullSeller = explode('=', $allParadasSeller[0]);
            $id_seller = $fullSeller[1];

            for ($j = 1; $j < count($allParadasSeller); $j += 2) {
                $timeFull = explode('=', $allParadasSeller[$j]);
                $paradaFull = explode('=', $allParadasSeller[$j + 1]);
                $finalParada = str_replace('+', ' ', $paradaFull[1]);

                if ($finalParada !== '' && $timeFull[1] !== '') {
                    $this->sparm->insertParadaService($timeFull[1], $finalParada, $id_seller, $idService);
                }
            }
        }
    }

    public function savePriceAndCommissionsForServices()
    {
        $id_service = $this->input->post('idServicio');
        $data = $this->input->post('comisionesServicio');
        $number_prices = $this->typeclim->noOfTypeClients();
        $allComisiones = explode('#', $data);

		foreach ($allComisiones as $comisionn) {
            $componentesPrecioIndividual = explode('&', $comisionn);

            $id_seller_full = explode('=', $componentesPrecioIndividual[0]);
            $vendedor = (count($id_seller_full) > 1) ? $id_seller_full[1] : 0;

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

                $this->sprim->insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $vendedor);
            }
        }

        echo '';//echonull
    }

    public function showServices()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/services/createservice';
            $data['available_services'] = $this->serm->getAvailableServices();
            $data['not_available_services'] = $this->serm->getNotAvailableServices();
            $data['title'] = 'Servicios';
            $this->load->view('admin/services/show_services', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsService()
    {
        $id_service = $this->input->post('service');

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/services/showservices';
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromService($id_service);
        $data['serviceID'] = $id_service;
        $data['serviceInfo'] = $this->serm->getServiceInformation($id_service);
        $data['title'] = 'Detalles del servicio';
        $this->load->view('admin/services/details_service', $data);
    }

    public function updateService()
    {
        $id_service = $this->input->post('serviceID');

        $this->prepareServiceForUpdate();

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/services/createservice';
        $data['serviceID'] = $id_service;
        $data['serviceInfo'] = $this->serm->getServiceInformation($id_service);
        $data['title'] = 'Detalles del servicio';
        $this->session->set_flashdata('success', 'La información del servicio se ha actualizado correctamente.');
        $this->load->view('admin/services/details_service', $data);
    }

    public function prepareServiceForUpdate()
    {
        $id_service = $this->input->post('serviceID');

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

        $referencia = $this->input->post('Referencia');
        $fecha_inicio = $this->input->post('FechaInicio');
        $fecha_fin = $this->input->post('FechaFin');
        $status = $this->input->post('Estado');
        $info_estado = $this->input->post('InfoEstado');
        $fecha_inicio_valido = $this->input->post('fechaReservasInicio');
        $fecha_fin_valido = $this->input->post('fechaReservasFin');

        if (!$this->upload->do_upload('userfile')) {
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
        }

        $last_id_inserted = $this->serm->updateServiceM($id_service, $id_typeservice, $modelo, $titulo, $descripcion, $recomendaciones, $localidad_inicio, $localidad_fin, $hora_inicio, $hora_fin, $min_personas, $max_personas, $referencia, $fecha_inicio, $fecha_fin, $unique_passenger, $status, $info_estado, $fecha_inicio_valido, $fecha_fin_valido, $foto);
    }

    public function updateStopsForService()
    {
        $id_service = $this->input->post('idServicio');
        $this->sparm->deleteAllParadasFromService($id_service);
        $this->createStopsForService();
    }

    public function updatePriceAndCommissionsForServices()
    {
        $id_service = $this->input->post('idServicio');
        $data = $this->input->post('comisionesServicio');
        $number_prices = $this->typeclim->noOfTypeClients();
        $allComisiones = explode('#', $data);

        $this->sprim->deleteAllPricesFromService($id_service);

		foreach ((array)$allComisiones as $comisionn) {
            $componentesPrecioIndividual = explode('&', $comisionn);

            $id_seller_full = explode('=', $componentesPrecioIndividual[0]);
            $vendedor = (count($id_seller_full) > 1) ? $id_seller_full[1] : 0;

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

                $this->sprim->insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $vendedor);
            }
        }
    }

    public function updateBanner()
    {
        $id_service = $this->input->post('serviceId');

        if (!$this->upload->do_upload('userfile')) {
            $this->session->set_flashdata('warning', 'No se ha podido actualizar el báner.');
        } else {
            $foto = base_url('assets/uploads/'.$this->upload->data('file_name'));
			$foto = $this->security->xss_clean($foto);
            $this->session->set_flashdata('success', 'El báner se ha actualizado correctamente.');
            $this->serm->updateBannerS($id_service, $foto);
        }

        //carga el servicio con datos actualizados
        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['all_type_services'] = $this->typeserm->getTypeServices();
        $data['backRoute'] = 'admin/services/showservices';
        $data['sellers_saved_paradas'] = $this->selm->getSellerSavedParadasFromService($id_service);
        $data['serviceID'] = $id_service;
        $data['serviceInfo'] = $this->serm->getServiceInformation($id_service);
        $data['title'] = 'Detalles del servicio';
        $this->load->view('admin/services/details_service', $data);
    }
}
