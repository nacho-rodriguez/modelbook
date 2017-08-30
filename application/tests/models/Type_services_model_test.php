<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_services_model_test extends TestCase
{
    private $obj;

    public function setUp()
    {
        $this->resetInstance();
		$this->CI->load->model('type_services_model', 'typeserm');
        $this->obj = $this->CI->typeserm;
    }

	public function test_getAllTypeServices(){
		$expected = [
            1 => 'Excursión',
            2 => 'Ruta',
            3 => 'Traslado'
        ];
		$list = $this->obj->getAllTypeServices();

        foreach($list as $element)
        {
            $this->assertEquals($expected[$element->id_tipo_servicio], $element->nombre);
        }
	}
}
