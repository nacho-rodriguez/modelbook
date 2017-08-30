<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('request_model', 'reqm');
        $this->obj = $this->CI->reqm;
    }

	public function test_getAllRequests(){
		$expected = [
			1 => 'Sugerencias',
            2 => 'Más plazas'
        ];
		$list = $this->obj->getAllRequests();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_peticion], $element->asunto);
        }
	}

	public function test_getRequestsFromSeller(){
		$expected = [
			1 => 'Sugerencias',
			2 => 'Más plazas'
		];
		$list = $this->obj->getRequestsFromSeller(1);

		foreach($list as $element)
		{
			$this->assertEquals($expected[$element->id_peticion], $element->asunto);
		}
	}
}
