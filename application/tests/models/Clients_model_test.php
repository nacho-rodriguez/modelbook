<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('clients_model', 'clim');
        $this->obj = $this->CI->clim;
    }

	public function test_getAllClients(){
		$expected = [
			1 => '44444444',
            2 => '55555555'
        ];
		$list = $this->obj->getAllClients();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_cliente], $element->dni);
        }
	}
}
