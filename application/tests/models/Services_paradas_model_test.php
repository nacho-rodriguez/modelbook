<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_paradas_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('services_paradas_model', 'sparm');
        $this->obj = $this->CI->sparm;
    }

	public function test_getAllParadasFromService(){
		$expected = [
			1 => 'Primera parada en Chiclana',
            2 => 'Segunda parada en SF'
        ];
		$list = $this->obj->getAllParadasFromService(1);

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_servicio_parada], $element->parada);
        }
	}
}
