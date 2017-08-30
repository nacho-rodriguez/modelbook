<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('commissions_model', 'comm');
        $this->load->model('sellers_model', 'selm');
        $this->load->model('service_model', 'serm');
        $this->load->model('services_prices_model', 'sprim');
        $this->load->model('type_clients_model', 'typeclim');
        $this->load->model('users_model', 'um');
    }

    public function newSeller()
    {
        if ($this->um->imAdmin()) {
            $data['all_commissions'] = $this->comm->getAllCommissions();
            $data['all_services'] = $this->serm->getServicesCurrentlyAvailables();
            $data['all_type_clients'] = $this->typeclim->getTypeClients();
            $data['backRoute'] = 'admin/dashboard';
            $data['title'] = 'Nuevo vendedor';
            $this->load->view('admin/sellers/new_seller', $data);
        } else {
            redirect(index_page());
        }
    }

    public function createSeller()
    {
        $cif = $this->input->post('CIF');
        $name = $this->input->post('Nombre');
        $direccion = $this->input->post('Direccion');
        $poblacion = $this->input->post('Poblacion');
        $provincia = $this->input->post('Provincia');
        $phone = $this->input->post('Telefono');

        $status = $this->input->post('estado_select');
        $email = $this->input->post('Email');
        $password = $this->input->post('Password');
        $show_info = $this->input->post('mostrar_info') ? 1 : 0;

        $this->selm->newSeller($cif, $name, $direccion, $poblacion, $provincia, $email, $phone, $status, $password, $show_info);

        $data['all_sellers'] = $this->selm->getAllSellers();
        $data['backRoute'] = 'admin/sellers/newseller';
        $data['result'] = 0;
        $data['title'] = 'Vendedores';
        $this->session->set_flashdata('success', 'Se ha registrado correctamente el nuevo vendedor. Modifique a continuación las tarifas y precios de los servicios disponibles.');
        $this->load->view('admin/sellers/show_sellers', $data);
    }

    public function updatePrices()
    {
        $id_seller = $this->input->post('id_vendedor');
        $id_service = $this->input->post('id_servicio');
        $number_prices = $this->input->post('numberPrices');
        $data = $this->input->post('comisionesServicio');

        if ($number_prices == 0) {
            $number_prices = $this->typeclim->noOfTypeClients();
        }
        // Eliminar precios anteriores y actualizar a los nuevos.
        $this->sprim->deleteAllPricesFromService($id_service);

        $componentesPrecioIndividual = explode('&', $data);
        $k = -1;

        for ($j = 0; $j < $number_prices; ++$j) {
            $id_precio_tipo_clienteFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $valorFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $tipo_comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);

            $id_typeclient = $id_precio_tipo_clienteFULL[1];
            $valor = $valorFULL[1];
            $comision = $comisionFULL[1];
            $tipo_comision = $tipo_comisionFULL[1];

            $this->sprim->insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $id_seller);
        }
    }

    public function updatePriceForOneSeller()
    {
        $id_seller = $this->input->post('id_vendedor');
        $id_service = $this->input->post('id_servicio');
        $number_prices = $this->input->post('numberPrices');
        $data = $this->input->post('comisionesServicio');

        if ($number_prices == 0) {
            $number_prices = $this->typeclim->noOfTypeClients();
        }
        // Eliminar precios anteriores y actualizar a los nuevos.
        $this->sprim->deleteAllPricesFromServiceFromSeller($id_service, $id_seller);

        $componentesPrecioIndividual = explode('&', $data);
        $k = -1;

        for ($j = 0; $j < $number_prices; ++$j) {
            $id_precio_tipo_clienteFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $valorFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);
            $tipo_comisionFULL = explode('=', $componentesPrecioIndividual[++$k]);

            $id_typeclient = $id_precio_tipo_clienteFULL[1];
            $valor = $valorFULL[1];
            $comision = $comisionFULL[1];
            $tipo_comision = $tipo_comisionFULL[1];

            $this->sprim->insertNewIndividualPriceService($id_typeclient, $valor, $comision, $tipo_comision, $id_service, $id_seller);
        }
    }

    public function showSellers()
    {
        if ($this->um->imAdmin()) {
            $data['backRoute'] = 'admin/sellers/newseller';
            $data['all_sellers'] = $this->selm->getAllSellers();
            $data['title'] = 'Vendedores';
            $data['result'] = 0;
            $this->load->view('admin/sellers/show_sellers', $data);
        } else {
            redirect(index_page());
        }
    }

    public function detailsSeller()
    {
        $id_seller = $this->input->post('seller');
        $all_commissions = $this->comm->getAllCommissions();
        $all_type_clients = $this->typeclim->getTypeClients();
        $all_services_availables = $this->serm->getServicesCurrentlyAvailables();

        $data['all_commissions'] = $all_commissions;
        $data['all_services'] = $all_services_availables;
        $data['all_type_clients'] = $all_type_clients;
        $data['backRoute'] = 'admin/sellers/showsellers';
        $data['currentSeller'] = $this->sprim->getSellerWithAllPricesAndServices($id_seller);
        $data['id_seller'] = $id_seller;
        $data['services_availables'] = $this->serm->getServicesCurrentlyAvailables();
        $data['title'] = 'Detalles del vendedor';
        $this->load->view('admin/sellers/details_seller', $data);
    }

    public function showPrices()
    {
        $service = $this->input->post('service');
        $id_seller = $this->input->post('seller');

        $serviceName = $this->serm->getFullNameService($service);
        $fullSeller = $this->selm->getSeller($id_seller);

		$data['all_commissions'] = $this->comm->getAllCommissions();
		$data['all_types_clients'] = $this->typeclim->getTypeClients();
		$data['backRoute'] = 'admin/sellers/detailsseller';
		$data['codeBack'] = 3;
		$data['pricesService'] = $this->sprim->getPreciosComisionesService($service, $id_seller);
		$data['seller'] = $id_seller;
		$data['sellerName'] = $fullSeller->nombre;
		$data['service'] = $service;
		$data['serviceNameFull'] = $serviceName->nombre.' ('.$serviceName->referencia.'). Inicio: '.$serviceName->fecha_inicio;
		$data['title'] = 'Precios del vendedor';
        $this->load->view('admin/sellers/show_prices', $data);
    }

    public function updateSeller()
    {
        $id = $this->input->post('idSeller');
        $cif = $this->input->post('CIF');
        $name = $this->input->post('Nombre');
        $direccion = $this->input->post('Direccion');
        $poblacion = $this->input->post('Poblacion');
        $provincia = $this->input->post('Provincia');
        $phone = $this->input->post('Telefono');
        $status = $this->input->post('estado_select');
        $email = $this->input->post('Email');
        $show_info = $this->input->post('mostrar_info') ? 1 : 0;
        $this->selm->updateSellerM($id, $cif, $name, $direccion, $poblacion, $provincia, $email, $phone, $status, $show_info);

        $data['all_commissions'] = $this->comm->getAllCommissions();
        $data['all_type_clients'] = $this->typeclim->getTypeClients();
        $data['backRoute'] = 'admin/sellers/showsellers';
        $data['currentSeller'] = $this->selm->getSeller($id);
        $data['id_seller'] = $id;
        $data['services_availables'] = $this->serm->getServicesCurrentlyAvailables();
        $data['title'] = 'Detalles del vendedor';
        $this->session->set_flashdata('success', 'La información del vendedor se ha actualizado correctamente.');
        $this->load->view('admin/sellers/details_seller', $data);
    }
}
