<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_prices_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('services_prices_model', 'sprim');
        $this->obj = $this->CI->sprim;
    }

	public function test_getPreciosComisionesService(){
		$expected = [
			1 => '10.00',
            2 => '15.00',
			3 => '20.00',
			4 => '25.00'
        ];
		$list = $this->obj->getPreciosComisionesService(1,1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_servicio_precio], $element->valor_monetario);
        }
	}
}
