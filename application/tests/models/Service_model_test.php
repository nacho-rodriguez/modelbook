<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('service_model', 'serm');
        $this->obj = $this->CI->serm;
    }

	public function test_getAvailableServices(){
		$expected = [
			1 => 'Doñana en bus',
            2 => 'Palmar en bici'
        ];
		$list = $this->obj->getAvailableServices();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_servicio], $element->nombre);
        }
	}
}
