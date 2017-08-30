<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_clients_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('type_clients_model', 'typeclim');
        $this->obj = $this->CI->typeclim;
    }

	public function test_getAllTypeClients(){
		$expected = [
            1 => 'Niño (1-3)',
            2 => 'Niño (4-12)',
            3 => 'Adolescente (13-17)',
			4 => 'Adulto (+18)'
        ];
		$list = $this->obj->getAllTypeClients();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_tipo_cliente], $element->nombre);
        }
	}
}
